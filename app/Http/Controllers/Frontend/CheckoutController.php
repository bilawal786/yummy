<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Http\Controllers\FrontendController;
use App\Http\Services\CheckoutService;
use App\Http\Services\OrderService;
use App\Http\Services\StripeService;
use App\Libraries\MyString;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderLineItem;
use App\Models\Setting;
use App\Models\Shop;
use App\Notifications\NewShopOrderCreated;
use App\Notifications\OrderCreated;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\DepositService;
use App\Models\UserDeposit;
use App\Models\Balance;
use App\Models\ShopProduct;
use App\User;
use Stripe;
use Auth;
use Session;
class CheckoutController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Frontend';
    }

    public function index(Request $request)
    {
        $this->data['namepage']  = "Caisse";
        $this->data['user'] = auth()->user();

        \Stripe\Stripe::setApiKey(setting('stripe_secret'));
        $shop_product_id = session('shop_product_id');
        $this->data['shop'] = ShopProduct::findOrfail($shop_product_id);

        if(Auth::user()->customer_id != NULL){
          $customer_id = Auth::user()->customer_id;
        }else{
          $customer = \Stripe\Customer::create([
            'email' => Auth::user()->email,
            'name' => Auth::user()->first_name.' '.Auth::user()->last_name,
            'description' => 'Client créé via YummyBox'
          ]);

          $user = User::find(Auth::user()->id);
          $user->customer_id = $customer->id;
          $user->save();
          $customer_id = $customer->id;
        }

        $merchent = Shop::where('id', $this->data['shop']->shop_id)->first();
        $merchant_details = User::where('id', $merchent->user_id)->first();

        $payment_intent = \Stripe\PaymentIntent::create([
          'amount' => $this->data['shop']->product->unit_price *100,
          'currency' => 'EUR',
          'customer' => $customer_id,
          'description' => $merchent->name .' YummyBox'
        ]);

        $this->data['intent'] = $payment_intent->client_secret;

        return view('frontend.checkout-mobile', $this->data);
    }
    public $adminBalanceId = 1;

    public function store(Request $request)
    {
        $payment        = null;

        $request->session()->put('shop_product_id', $request->shop_product_id);
        //return session('shop_product_id');
        $shop_product_id = $request->pid ?? session('shop_product_id');

        $this->data['shop'] = ShopProduct::findOrfail($shop_product_id);

        if($request->payment_type){
            $merchent = Shop::where('id', $this->data['shop']->shop_id)->first();
            $firebaseToken = User::where('id', $merchent->user_id)->whereNotNull('device_token')->pluck('device_token')->all();
            $firebaseTokenForcurrentUser = User::where('id',Auth::user()->id)->whereNotNull('device_token')->pluck('device_token')->all();

            $SERVER_API_KEY = 'AAAAAjqrxA4:APA91bH2gSA-MK-gvM4ASC7-xfx7Fg--FMCzg1KdZ5wkwQb1fCOkWdDKvLWSHW4dJAwvX9SVjYWVQwHeYxElsi7fuwu3fuidKJzyWI0YlCipcGK5DnTStSmwvDNdCAfMxrYyDcqSRtEm';

            $data = [
                "registration_ids" => $firebaseToken,
                "notification" => [
                    "title" => "Yummy Box",
                    "body" => "Félicitations! Vous avez une nouvelle commande, ouvrez l'application pour plus de détails",
                ]
            ];
            $dataString = json_encode($data);

            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);
            //////////////////////////////////////
            $data1 = [
                "registration_ids" => $firebaseTokenForcurrentUser,
                "notification" => [
                    "title" => "Yummy Box",
                    "body" => "Félicitations, vous venez de faire un geste pour la planète 🌎",
                ]
            ];
            $dataString1 = json_encode($data1);

            $headers1 = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch1 = curl_init();

            curl_setopt($ch1, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch1, CURLOPT_POST, true);
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $dataString1);
            $response = curl_exec($ch1);
            ///////////////////////
        if ($shop_product_id > 0 or blank($request->coin)) {
            $shop = Shop::find($this->data['shop']->shop_id);
            $validation = [
                'mobile'       => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                'payment_type' => 'required|numeric',
            ];
            if(auth()->check()) {
                  $items = [
                    'shop_id'                   => $shop_product_id,
                    'product_id'                => (int) $this->data['shop']->product_id,
                    'unit_price'                => (float) $this->data['shop']->product->unit_price,
                    'quantity'                  => (int) 1,
                    'discounted_price'          => (float) '0.00',
                    'variation'                 => '',
                    'options'                   => '',
                  ];
                  $yumcoin = (float) $this->data['shop']->product->unit_price*1000;
                if ($request->payment_type == PaymentMethod::STRIPE && (is_object($payment) && $payment->isSuccessful())) {
                    $request->request->add([
                        'paid_amount'           => $this->data['shop']->product->unit_price,
                        'payment_method'        => $request->payment_type,
                        'payment_status'        => PaymentStatus::PAID
                    ]);
                } elseif($request->payment_type == PaymentMethod::WALLET) {
                  $balance = Balance::where('id', auth()->user()->balance_id)->first();

                  if($yumcoin <= $balance->balance){
                    $request->request->add([
                        'paid_amount'           => $this->data['shop']->product->unit_price,
                        'payment_method'        => $request->payment_type,
                        'payment_status'        => PaymentStatus::PAID
                    ]);

                    $sortant = Balance::where('id', auth()->user()->balance_id)->decrement('balance', $yumcoin);
                  }
                } else {
                    $request->request->add([
                        'paid_amount'           => 0,
                        'payment_method'        => PaymentMethod::CASH_ON_DELIVERY,
                        'payment_status'        => PaymentStatus::UNPAID
                    ]);
                }

                $request->request->add([
                    'items'                 => $items,
                    'shop_id'               => $this->data['shop']->shop_id,
                    'user_id'               => auth()->user()->id,
                    'total'                 => $this->data['shop']->product->unit_price,
                    'delivery_charge'       => $shop->delivery_charge,
                ]);
                  $orderService = app(OrderService::class)->order($request);


                if(!blank($orderService->status)) {
                    $order = Order::find($orderService->order_id);

                    /*Cart::destroy();
                    session()->put('session_cart_shop_id', 0);*/
                    $request->session()->forget('shop_product_id');

                    try {
                        $request->user()->notify(new OrderCreated($order));
                        $order->shop->user->notify(new NewShopOrderCreated($order));
                    } catch (\Exception $e) { }

                    Session::flash('message', 'Votre commande a été passée avec succès');
                    return redirect(route('account.order.show', $order->id))->withSuccess('You order completed successfully.');
                } else {
                    return redirect(route('checkout.index'))->withError($orderService->message);
                }
            } else {
                return redirect()->route('login');
            }
        }else {
            return redirect(route('checkout.index'))->withError('The shop not found');
        }
      }else{
        return redirect(route('checkout.index'));
      }
    }
    public function yummycoin(Request $request){
        $username = Auth::user()->username;
        Balance::where('name', $username)->increment('balance', $request->valeur);
        Session::flash('message', 'Succès! Votre recharge a bien été prise en compte');
        return redirect(route('account.profile'))->withSuccess('Votre compte à bien été rechargé');
    }
    public function order(Request $request)
    {
      Order::where('id', $request->order_id)
      ->update(['status' => 20]);
      return redirect(route('account.order.show', $request->order_id))->withSuccess('You order completed successfully.');
    }
}
