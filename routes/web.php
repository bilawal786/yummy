<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\FaceBookController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use Illuminate\Http\Request;

Route::get('/', function (){
    $check =  preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    if($check){
        return  redirect('/intro-screens');
    }else{
        return  redirect('/login');
    }
});
Route::get('/ip', function (){
    $json = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . request()->ip());
    $details = json_decode($json);
    dd($details->geoplugin_timezone);
});
Route::get('/crontest', 'CronController@order_status');
Route::get('/testnotification', 'HomeController@testnotification');
Route::get('/change/location/{id}', 'HomeController@changelocation')->name('change.location');

Route::post('/save-token',function (Request $request){
    if (Auth::user()){
        Auth::user()->update(['device_token'=>$request->token]);
    }
    return response()->json(['token saved successfully.']);
})->name('save-token');
Route::get('/save-token/{token}/{type}',function ($token, $type){
    if (Auth::user()) {
        Auth::user()->update(['device_token' => $token, 'device_type' => $type]);
    }
    return redirect('home');
});
Route::get('mail',function (){
    $dataa = array(
        'firstName' => "sonu",
        'lastName' => "don",
    );
    return view('frontend.mail.register')->with('dataa', $dataa);
});
Route::get('/intro-screens',function (){
    return view('frontend.intro.1');
})->middleware('guest');

Route::group(['middleware' => ['installed']], function () {
    Auth::routes(['verify' => false]);
});
Route::get('/prod', 'CronController@order_update');
Route::group(['prefix' => 'install', 'as' => 'LaravelInstaller::', 'middleware' => ['web', 'install']], function () {
    Route::post('environment/saveWizard', [
        'as'   => 'environmentSaveWizard',
        'uses' => 'EnvironmentController@saveWizard',
    ]);

    Route::get('purchase-code', [
        'as'   => 'purchase_code',
        'uses' => 'PurchaseCodeController@index',
    ]);

    Route::post('purchase-code', [
        'as'   => 'purchase_code.check',
        'uses' => 'PurchaseCodeController@action',
    ]);
});

//Route::get('/stripe', function (){
////    $stripe = new \Stripe\StripeClient('sk_test_51Ia9JLGGZGzjCRwlo1pfllMTHuOT1sacxSijeBVjgkyxFXbQvrxy2YdrFkZSFxEecdgS1cK9s1Ptgp6iRsgtvAaI00rAoXzlbI');
//    $stripe = new \Stripe\StripeClient('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');
//
//    $data = $stripe->accounts->create(
//        [
//            'country' => 'US',
//            'type' => 'express',
//            'capabilities' => [
//                'card_payments' => ['requested' => true],
//                'transfers' => ['requested' => true],
//            ],
//            'business_type' => 'individual',
//            'business_profile' => ['url' => 'https://app.yummybox.fr/'],
//        ]
//    );
//    Auth::user()->update(['connect_id' => $data->id]);
//    $data2 = $stripe->accountLinks->create(
//        [
//            'account' => $data->id,
//            'refresh_url' => 'https://app.yummybox.fr/',
//            'return_url' => route('home'),
//            'type' => 'account_onboarding',
//        ]
//    );
//    return redirect($data2->url);
//});
//Route::get('/payout', function (){
////    \Stripe\Stripe::setApiKey('sk_test_51Ia9JLGGZGzjCRwlo1pfllMTHuOT1sacxSijeBVjgkyxFXbQvrxy2YdrFkZSFxEecdgS1cK9s1Ptgp6iRsgtvAaI00rAoXzlbI');
//    \Stripe\Stripe::setApiKey('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');
//
//    $transfer = \Stripe\Transfer::create([
//        "amount" => 100,
//        "currency" => "eur",
//        "destination" => Auth::user()->connect_id,
//    ]);
//    dd($transfer);
//});

Route::post('/fetchmaincategory', 'Admin\CategoryController@fetchmaincategory')->name('fetchmaincategory');
Route::post('/fetchsubcategory', 'Admin\CategoryController@fetchsubcategory')->name('fetchsubcategory');

Route::get('partenaire/{shop}/panier/{product}', 'Frontend\ShopProductController')->name('shop.product.details');
Route::get('/home', 'Frontend\WebController@index')->name('home');
Route::get('/map', 'Frontend\WebController@mapshow')->name('map');
Route::get('categorie/{slug}', 'Frontend\CategorieController@index')->name('categories');

Route::group(['middleware' => ['installed'], 'namespace' => 'Frontend'], function () {
    Route::post('/addtowishlist', 'WebController@addtowishlist')->name('addtowishlist');
    Route::get('/notifications', 'WebController@notifications')->name('notifications')->middleware('auth');
    Route::view('/setup', 'frontend.account-setup');
    Route::get('/coin', 'YummyCoinController@index')->name('yummycoin')->middleware('auth');
    Route::get('/coinjson/{price}', 'YummyCoinController@json')->name('coinjson')->middleware('auth');
    Route::post('yummycharge', 'CheckoutController@yummycoin')->name('yummycharge')->middleware('auth');

    Route::get('/shop/map/{lat}/{lan}', 'WebController@shopMap')->name('shop.map')->middleware('auth');
    Route::get('map-data', 'WebController@map')->name('map.data');
    Route::get('partenaire/{shop}', 'ShopController')->name('shop.show')->middleware('auth');

    Route::get('cart', 'CartController@index')->name('cart.index')->middleware('auth');
    Route::post('cart', 'CartController@store')->name('cart.store')->middleware('auth');
    Route::get('cart/{id}', 'CartController@remove')->name('cart.remove');
    Route::post('cart-quantity', 'CartController@quantity')->name('cart.quantity');

    Route::get('checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
    Route::post('checkout', 'CheckoutController@store')->name('checkout.store')->middleware('auth');
    Route::post('order_validation', 'CheckoutController@order')->name('checkout.order_validation')->middleware('auth');

    Route::get('account/profile', 'AccountController@index')->name('account.profile')->middleware('auth');
    Route::get('account/password', 'AccountController@getPassword')->name('account.password')->middleware('auth');
    Route::put('account/password', 'AccountController@password_update')->name('account.password.update')->middleware('auth');
    Route::get('account/update', 'AccountController@profileUpdate')->name('account.profile.index')->middleware('auth');
    Route::put('account/update/{profile}', 'AccountController@update')->name('account.profile.update')->middleware('auth');
    Route::get('account/order', 'AccountController@getOrder')->name('account.order')->middleware('auth');
    Route::get('account/order/cancel/{id}', 'AccountController@getOrderCancel')->name('front.order.cancel')->middleware('auth');
    Route::get('account/get-order', 'AccountController@getOrderList')->name('account.get-order')->middleware('auth');
    Route::get('account/order/{id}', 'AccountController@orderShow')->name('account.order.show')->middleware('auth');
    Route::get('account/order-cancel/{id}', 'AccountController@orderCancel')->name('account.order.cancel')->middleware('auth');
    Route::get('account/order-file/{id}', 'AccountController@getDownloadFile')->name('account.order.file')->middleware('auth');

    Route::get('account/transaction', 'AccountController@getTransactions')->name('account.transaction')->middleware('auth');
    Route::get('account/review', 'AccountController@review')->name('account.review')->middleware('auth');
    Route::get('account/get-review', 'AccountController@getReview')->name('account.get-review')->middleware('auth');

    Route::get('account/shop-product-ratings/{shop}/{product}', 'AccountController@shopProductRatings')->name('account.shop-product-ratings')->middleware('auth');
    Route::post('account/shop-product-ratings-update', 'AccountController@shopProductRatingsUpdate')->name('account.shop-product-ratings-update')->middleware('auth');

    Route::get('/search', 'SearchController@filter')->name('search');
    Route::get('/{shop}/products/search', 'SearchController@filterProduct')->name('search-product');
    Route::get('shop-categories/{cat}/{id}', 'CategorieController@shop_categories')->name('shop-categories');
    Route::get('traders', 'CategorieController@tradersindex')->name('traders');
    Route::post('traders/search', 'CategorieController@tradersSearch')->name('traders.search');
    Route::get('sub-category/{id}', 'CategorieController@subcategory')->name('sub-category');
    Route::get('shop-products/{id}', 'CategorieController@shopProducts')->name('shop-products');
    Route::get('subcategory/products/{id}', 'CategorieController@subcategoryproducts')->name('subcategory.products');
    Route::get('/favourites', 'CategorieController@favourites')->name('favourites')->middleware('auth');
    Route::get('/fav/remove/{id}', 'CategorieController@favouritremove')->name('fav.remove');
    Route::get('/privacy', 'PrivacyController')->name('privacy');
    Route::get('/terms', 'TermController')->name('terms');
    Route::get('/faq', 'ContactController@faq')->name('faq');
    Route::get('/how-it-works', 'ContactController@how_it_works')->name('how-it-works');
    Route::get('/sponsership', 'ContactController@sponsership')->name('sponsership')->middleware('auth');
    Route::get('/suggest/business', 'ContactController@suggest')->name('suggest.business')->middleware('auth');
    Route::post('/suggest/store', 'ContactController@suggeststore')->name('suggest.store');
    Route::get('/contact', 'ContactController')->name('contact');
    Route::post('/contact', 'ContactController@store')->name('contact.store');

    Route::get('page/{slug}', 'FrontendPageController@index')->name('page');

    Route::post('areas', 'AreaController@index')->name('area.index');
});

Route::redirect('/admin', '/admin/dashboard')->middleware('backend_permission')->name('admin');

Route::group(['prefix' => 'admin', 'middleware' => ['installed'], 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm');
});
// Password reset
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'installed', 'backend_permission'], 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::post('day-wise-income-order', 'DashboardController@dayWiseIncomeOrder')->name('dashboard.day-wise-income-order');

    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::get('suggestions', 'ProfileController@suggestions')->name('suggestions');
    Route::get('send/notifications', 'ProfileController@sendNotifications')->name('send.notifications');
    Route::get('send/vendor/notifications', 'ProfileController@sendNotificationsVendor')->name('vendor.send.notifications');
    Route::post('store/notifications', 'ProfileController@storeNotifications')->name('notification.store');
    Route::post('vendor/store/notifications', 'ProfileController@storeNotificationsvendor')->name('vendor.notification.store');
    Route::get('suggest/delete/{id}', 'ProfileController@suggestDelete')->name('suggest.delete');
    Route::get('admin/banks', 'ProfileController@adminBank')->name('admin.bank');
    Route::get('vendor/bank', 'ProfileController@bankDetails')->name('vendor.bank');
    Route::post('bank/store/', 'ProfileController@bankDetailsStore')->name('bank.store');
    Route::put('profile/update/{profile}', 'ProfileController@update')->name('profile.update');
    Route::put('profile/change', 'ProfileController@change')->name('profile.change');

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::get('/', 'SettingController@index')->name('index');
        Route::post('/', 'SettingController@siteSettingUpdate')->name('site-update');
        Route::get('sms', 'SettingController@smsSetting')->name('sms');
        Route::post('sms', 'SettingController@smsSettingUpdate')->name('sms-update');
        Route::get('payment', 'SettingController@paymentSetting')->name('payment');
        Route::post('payment', 'SettingController@paymentSettingUpdate')->name('payment-update');
        Route::get('email', 'SettingController@emailSetting')->name('email');
        Route::post('email', 'SettingController@emailSettingUpdate')->name('email-update');
        Route::get('notification', 'SettingController@notificationSetting')->name('notification');
        Route::post('notification', 'SettingController@notificationSettingUpdate')->name('notification-update');
        Route::get('social-login', 'SettingController@socialLoginSetting')->name('social-login');
        Route::post('social-login', 'SettingController@socialLoginSettingUpdate')->name('social-login-update');
        Route::get('otp', 'SettingController@otpSetting')->name('otp');
        Route::post('otp', 'SettingController@otpSettingUpdate')->name('otp-update');
        Route::get('homepage', 'SettingController@homepageSetting')->name('homepage');
        Route::post('homepage', 'SettingController@homepageSettingUpdate')->name('homepage-update');

        Route::get('homepage', 'SettingController@homepageSetting')->name('homepage');
        Route::post('homepage', 'SettingController@homepageSettingUpdate')->name('homepage-update');

        Route::get('social', 'SettingController@socialSetting')->name('social');
        Route::post('social', 'SettingController@socialSettingUpdate')->name('social-update');

    });

    Route::resource('page', 'PageController');
    Route::get('get-page', 'PageController@getPage')->name('page.get-page');

    Route::resource('location', 'LocationController');
    Route::get('get-location', 'LocationController@getLocation')->name('location.get-location');

    Route::get('rating', 'RatingController@index')->name('rating.index');
    Route::put('rating/{id}', 'RatingController@update')->name('rating.update');
    Route::get('get-rating', 'RatingController@getRating')->name('rating.get-rating');

    Route::resource('area', 'AreaController');
    Route::get('get-area', 'AreaController@getArea')->name('area.get-area');

    Route::resource('souscategorie', 'SubCategoryController');
    Route::resource('category', 'CategoryController');
    Route::get('get-category', 'CategoryController@getCategory')->name('category.get-category');

    Route::resource('banner', 'BannerController');
    Route::post('sort-banner', 'BannerController@sortBanner')->name('sort.banner');

    Route::resource('request-withdraw', 'RequestWithdrawController');
    Route::get('get-request-withdraw', 'RequestWithdrawController@getRequestWithdraw')->name('request-withdraw.get-request-withdraw');

    Route::resource('administrators', 'AdministratorController');
    Route::get('get-administrators', 'AdministratorController@getAdministrators')->name('administrators.get-administrators');

    Route::resource('customers', 'CustomerController');
    Route::get('get-customers', 'CustomerController@getCustomers')->name('customers.get-customers');
    Route::get('get-customers/country/{id}', 'CustomerController@getCustomersCountry')->name('customers.get-customers.country');
    Route::get('users/export/', 'CustomerController@export')->name('users.export');
    Route::post('client/search/', 'CustomerController@search')->name('client.search');
    Route::get('get-country-users/{id}', 'CustomerController@countryUsers')->name('get-country-users');

    Route::get('shop/admins', 'CustomerController@shopAdmins')->name('shop.admins');
    Route::get('create/shopadmins', 'CustomerController@createShopAdmins')->name('create.shopadmins');
    Route::post('shopadmins/store', 'CustomerController@storeShopAdmins')->name('shopadmins.store');
    Route::get('shopadmin/products', 'CustomerController@shopAdminProducts')->name('shopadmin.products');

    Route::get('sales/person', 'AdministratorController@salesPerson')->name('sales.person');
    Route::get('sales/person/create', 'AdministratorController@salesPersonCreate')->name('sales.person.create');
    Route::post('sales/person/store', 'AdministratorController@salesPersonStore')->name('salesPerson.store');

    Route::get('salesperson/vendors', 'SalesPersonController@salesPersonVendors')->name('salesperson.vendors');
    Route::get('salesperson/details/{id}', 'SalesPersonController@details')->name('salesperson.details');

    Route::resource('delivery-boys', 'DeliveryBoyController');
    Route::get('get-delivery-boys', 'DeliveryBoyController@getDeliveryBoy')->name('delivery-boys.get-delivery-boys');

    Route::get('get-order-history', 'DeliveryBoyController@history')->name('delivery-boys.get-order-history');

    Route::resource('shop', 'ShopController');

    Route::get('order-notification', 'OrderNotificationController@index')->name('order-notification.index');
    Route::get('order-notification/{id}/accept/{deliveryStatus}', 'OrderNotificationController@accept')->name('order-notification.accept');
    Route::get('get-order-notification', 'OrderNotificationController@getOrderNotification')->name('order-notification.get-order-notifications');

    Route::resource('collection', 'CollectionController');
    Route::get('get-collection', 'CollectionController@getCollection')->name('collection.get-collection');
    Route::post('get-collection-delivery-boy', 'CollectionController@getDeliveryBoy')->name('collection.get-delivery-boy');

    Route::post('orders/{order}/product-receive', 'OrderController@productReceive')->name('orders.product-receive');

    Route::get('shop/{shop}/products', 'ShopController@products')->name('shop.products');
    Route::get('shop/{shop}/products/create', 'ShopController@productAdd')->name('shop.products.create');
    Route::post('shop/{shop}/products/create', 'ShopController@productStore')->name('shop.products.store');
    Route::get('shop/{shop}/products/{shopproduct}/edit', 'ShopController@shopProductEdit')->name('shop.shopproduct.edit');
    Route::put('shop/{shop}/products/{shopproduct}/update', 'ShopController@shopProductUpdate')->name('shop.products.update');
    Route::delete('shop/{shop}/products/{shopproduct}/delete', 'ShopController@shopProductDelete')->name('shop.shopproduct.delete');

    // Route::post('shop/{shop}/products/attach', 'ShopController@productAttach')->name('shop.product.attach');

    Route::post('shopstore', 'ShopController@shopstore')->name('shop.shopstore');
    Route::get('shopedit/{shop}', 'ShopController@shopedit')->name('shop.shopedit');
    Route::put('shopupdate/{shop}', 'ShopController@shopupdate')->name('shop.shopupdate');
    Route::get('get-shop', 'ShopController@getShop')->name('shop.get-shop');
    Route::get('get-shop-product', 'ShopController@getShopProduct')->name('shop.get-shop-product');
    Route::post('get-shop', 'ShopController@getArea')->name('shop.get-area');

    Route::get('admin/product/my/delete/{id}', 'ProductController@mydelete')->name('product.my.delete');
    Route::get('admin/product/duplicate/{id}', 'ProductController@duplicate')->name('product.duplicate');
    Route::resource('products', 'ProductController');
    Route::post('getMedia', 'ProductController@getMedia')->name('products.getMedia');
    Route::post('storeMedia', 'ProductController@storeMedia')->name('products.storeMedia');
    Route::post('storeMedia/{product}', 'ProductController@updateMedia')->name('products.updateMedia');
    Route::post('removeMedia', 'ProductController@removeMedia')->name('products.removeMedia');
    Route::post('deleteMedia', 'ProductController@deleteMedia')->name('products.deleteMedia');
    Route::get('get-products', 'ProductController@getProduct')->name('products.get-product');

    Route::resource('request-products', 'RequestProductController');
    Route::get('get-request-products', 'RequestProductController@getRequestProduct')->name('request-products.get-request-product');
    Route::post('request-product/getMedia', 'RequestProductController@getMedia')->name('request-products.getMedia');
    Route::post('request-product/storeMedia', 'RequestProductController@storeMedia')->name('request-products.storeMedia');
    Route::post('request-product/storeMedia/{product}', 'RequestProductController@updateMedia')->name('request-products.updateMedia');
    Route::post('request-product/removeMedia', 'RequestProductController@removeMedia')->name('request-products.removeMedia');
    Route::post('request-product/deleteMedia', 'RequestProductController@deleteMedia')->name('request-products.deleteMedia');

    Route::resource('orders', 'OrderController');
    Route::get('orders/{order}/delivery', 'OrderController@delivery')->name('orders.delivery');
    Route::get('get-orders', 'OrderController@getOrder')->name('orders.get-orders');
    Route::post('order-fetch-status', 'OrderController@orderFetchStatus')->name('order.fetch.status');
    Route::get('orders/order-file/{id}', 'OrderController@getDownloadFile')->name('orders.order-file');
    Route::get('orders/export/by/admin', 'OrderController@exportorders')->name('orders.export');
    Route::post('deliverytime/update', 'OrderController@deliverytime')->name('deliverytime.update');
    Route::post('order/fetch/traders', 'OrderController@fetchTraders')->name('order.fetch.traders');

    Route::resource('updates', 'UpdateController');
    Route::get('get-updates', 'UpdateController@getUpdates')->name('updates.get-updates');
    Route::get('checking-updates', 'UpdateController@checking')->name('updates.checking-updates');
    Route::get('update', 'UpdateController@update')->name('updates.update');
    Route::get('update-log', 'UpdateController@log')->name('updates.update-log');

    Route::get('payment', 'PaymentController@index')->name('payment.index');
    Route::get('payment/invoice', 'PaymentController@invoice')->name('payment.invoice');
    Route::get('payment/cancel', 'PaymentController@cancel')->name('payment.cancel');

    Route::get('transaction', 'TransactionController@index')->name('transaction.index');
    Route::get('get-transaction', 'TransactionController@getTransaction')->name('transaction.get-transaction');

    Route::get('shop-owner-sales-report', 'ShopOwnerSalesReportController@index')->name('shop-owner-sales-report.index');
    Route::post('shop-owner-sales-report', 'ShopOwnerSalesReportController@index')->name('shop-owner-sales-report.index');

    Route::get('admin-commission-report', 'AdminCommissionReportController@index')->name('admin-commission-report.index');
    Route::post('admin-commission-report', 'AdminCommissionReportController@index')->name('admin-commission-report.index');

    Route::get('credit-balance-report', 'CreditBalanceReportController@index')->name('credit-balance-report.index');
    Route::post('credit-balance-report', 'CreditBalanceReportController@index')->name('credit-balance-report.index');
    Route::post('get-role-user', 'CreditBalanceReportController@getUsers')->name('get-role-user');

    Route::get('cash-on-delivery-order-balance-report', 'CashOnDeliveryOrderBalanceReportController@index')->name('cash-on-delivery-order-balance-report.index');
    Route::post('cash-On-delivery-order-balance-report', 'CashOnDeliveryOrderBalanceReportController@index')->name('cash-on-delivery-order-balance-report.index');

    Route::resource('role', 'RoleController');
    Route::post('role/save-permission/{id}', 'RoleController@savePermission')->name('role.save-permission');

    Route::resource('withdraw', 'WithdrawController');
    Route::get('withdraw/create/{id?}', 'WithdrawController@create')->name('withdraw.create');
    Route::get('get-withdraw', 'WithdrawController@getWithdraw')->name('withdraw.get-withdraw');
    Route::post('get-user-info', 'WithdrawController@getUserInfo')->name('withdraw.get-user-info');
    Route::resource('yummycoin', 'YummyCoinController');


});
Route::get('webview/paypal/{id}', 'Admin\WebviewController@paypal')->name('webview.paypal');
Route::post('webview/paypal/payment', 'Admin\WebviewController@paypalpayment')->name('webview.paypal.payment');
Route::get('webview/paypal/{id}/return', 'Admin\WebviewController@paypalReturn')->name('webview.paypal.return');
Route::get('webview/paypal/{id}/cancel', 'Admin\WebviewController@paypalCancel')->name('webview.paypal.cancel');

Route::get('webview/stripe', 'Admin\WebviewController@stripe')->name('webview.stripe');
Route::get('webview/stripe', 'Admin\WebviewController@stripe')->name('webview.stripe');

Route::get('paypal/ec-checkout', 'Admin\PayPalController@getExpressCheckout');
Route::get('paypal/ec-checkout-success', 'Admin\PayPalController@getExpressCheckoutSuccess');
Route::get('paypal/adaptive-pay', 'Admin\PayPalController@getAdaptivePay');
Route::post('paypal/notify', 'Admin\PayPalController@notify');
Route::post('payment-process', [StripePaymentController::class, 'process']);

// Facebook Login URL
Route::get('auth/facebook', [FaceBookController::class, 'loginUsingFacebook'])->name('facebook.login');
Route::get('auth/facebook/callback', [FaceBookController::class, 'callbackFromFacebook'])->name('facebook.callback');
