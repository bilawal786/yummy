<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use App\Models\YummyCoin;
use Illuminate\Http\Request;
use Stripe;
use Auth;
class YummyCoinController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['site_title'] = 'Frontend';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['namepage']  = "Créditer mon compte";
        $this->data['yummycoin'] = YummyCoin::where('actif', '=', '1')->get();
        $this->data['user'] = auth()->user();

        return view('frontend.yummycoin', $this->data);
    }
    public function json(Request $request){

      // Enter Your Stripe Secret
      \Stripe\Stripe::setApiKey(setting('stripe_secret'));
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
      $payment_intent = \Stripe\PaymentIntent::create([
        'amount' => $request->valeur *100,
        'currency' => 'EUR',
        'customer' => $customer_id,
        'description' => 'Panier YummyBox'
      ]);

      return $payment_intent->client_secret;

    }
}
