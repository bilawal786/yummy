@extends('frontend.layouts.mobile')
@section('style')
<style>.dark body {background: #000!important;}</style>
@endsection
@section('main-content')
<div class="osahan-cart">
  <div class="p-3 border-bottom">
     <div class="d-flex align-items-center">
       <a class="font-weight-bold text-success text-decoration-none" href="{{ route('home') }}"><i class="icofont-rounded-left back-page"></i></a><span class="font-weight-bold ml-3 h6 mb-0">Panier</span>
     </div>
  </div>
  <div class="osahan-body">
    @if(!blank(Cart::content()))
     <div class="cart-items bg-white position-relative">
      @foreach(Cart::content() as $content)
        <div class="d-flex  align-items-center p-3">
           <a href="product_details.html"><img src="{{ $content->options->images }}" class="img-fluid"></a>
           <a href="#" class="ml-3 text-dark text-decoration-none w-100">
              <h5 class="mb-1">{{ $content->name }}</h5>
              <div class="d-flex align-items-center">
                 <p class="total_price font-weight-bold m-0">{{$content->price}}€</p>
                 <div class="input-group input-spinner ml-auto cart-items-number size-change">
                   <div class="input-group-append">
                      <button class="btn btn-success btn-sm quantity-change-btn" type="button" id="button-minus"> − </button>
                   </div>

                    <input type="text" class="form-control quantity-change" id="{{ $content->rowId }}" value="{{ $content->qty }}">

                    <div class="input-group-prepend">
                       <button class="btn btn-success btn-sm quantity-change-btn" type="button" id="button-plus"> + </button>
                    </div>
                 </div>
              </div>
           </a>
        </div>
        @endforeach
     </div>
     <div class="p-3 mt-5">
       <p class="text-center mb-3">
           <img src="{{ asset('frontend/images/misc/payments.png') }}" height="26" />
       </p>
        <a href="{{ route('checkout.index') }}" class="text-decoration-none @if(Cart::totalFloat() <= 0) disabled @endif">
           <div class="rounded shadow bg-success d-flex align-items-center p-3 text-white">
              <div class="more">
                 <h6 class="m-0">Sous total <span class="total-price-js">{{ currencyFormat(Cart::totalFloat()) }}</span></h6>
                 <p class="small m-0">Procéder au paiement</p>
              </div>
              <div class="ml-auto"><i class="icofont-simple-right"></i></div>
           </div>
        </a>
     </div>
     @else
     <div class="p-3 mt-5">
       <p class="text-center mb-3">
           Votre panier est vide
       </p>
     </div>
     @endif
  </div>
</div>
@endsection
@section('footer-js')
	<script src="{{ asset('frontend/js/cart/cart.js') }}"></script>
@endsection
