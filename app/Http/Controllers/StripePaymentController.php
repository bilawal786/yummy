<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

class StripePaymentController extends Controller
{
  public function index()
  {
     return view('stripe');
  }

  public function process(Request $request)
  {
    \Log::info($request->all());

    $stripe = \Stripe\PaymentIntent::create([
          'source' => $request->get('tokenId'),
          'amount' => $request->get('amount') * 100,
          'currency' => 'EUR',
        ]);
      /*$stripe = Stripe::charges()->create([
          'source' => $request->get('tokenId'),
          'currency' => 'EUR',
          'amount' => $request->get('amount') * 100
      ]);*/
      return $stripe;
  }
}
