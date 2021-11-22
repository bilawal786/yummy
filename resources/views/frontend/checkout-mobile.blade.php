@extends('frontend.layouts.mobile')
@section('main-content')
<style>

#card-element {
  border-radius: 4px 4px 0 0 ;
  border: 1px solid rgba(50, 50, 93, 0.1);
  width: 100%;
  background: white;
  padding-left: 12px;
  padding-right: 12px;
}

#payment-request-button {
  margin-bottom: 32px;
}

/* spinner/processing state, errors */
.spinner,
.spinner:before,
.spinner:after {
  border-radius: 50%;
}
.spinner {
  color: #ffffff;
  font-size: 22px;
  text-indent: -99999px;
  margin: 0px auto;
  position: relative;
  width: 20px;
  height: 20px;
  box-shadow: inset 0 0 0 2px;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
.spinner:before,
.spinner:after {
  position: absolute;
  content: "";
}
.spinner:before {
  width: 10.4px;
  height: 20.4px;
  background: #5469d4;
  border-radius: 20.4px 0 0 20.4px;
  top: -0.2px;
  left: -0.2px;
  -webkit-transform-origin: 10.4px 10.2px;
  transform-origin: 10.4px 10.2px;
  -webkit-animation: loading 2s infinite ease 1.5s;
  animation: loading 2s infinite ease 1.5s;
}
.spinner:after {
  width: 10.4px;
  height: 10.2px;
  background: #5469d4;
  border-radius: 0 10.2px 10.2px 0;
  top: -0.1px;
  left: 10.2px;
  -webkit-transform-origin: 0px 10.2px;
  transform-origin: 0px 10.2px;
  -webkit-animation: loading 2s infinite ease;
  animation: loading 2s infinite ease;
}

@-webkit-keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes loading {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

</style>
<div class="page-content-wrapper">
      <div class="container">
        <div class="checkout-wrapper-area py-3">
          <!-- Choose Payment Method-->
          <div class="choose-payment-method">
            <h6 class="mb-3 text-center">Méthode de Paiement</h6>
            <div class="row justify-content-center g-3 pb-3">
              <!-- Single Payment Method-->
              @if(auth()->user()->balance->balance >= ($shop->product->unit_price*1000))
              <div class="col-6 col-md-5">
                <div class="single-payment-method"><a class="bank active text-dark" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                  <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                  <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                </svg>
                    <h6>YummyCoin</h6> <small>{{auth()->user()->balance->balance}} restant</small></a></div>
              </div>
              @else
              <div class="col-6 col-md-5">
                <div class="single-payment-method"><a href="{{route('yummycoin')}}" class="text-dark">
                  <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cash-coin text-dark" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                  <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                  <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                  <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                </svg>
                    <h6>YummyCoin</h6> <small>Recharger mon compte</small></a></div>
              </div>
              @endif
              <!-- Single Payment Method-->
              @if(setting('stripe_key') && setting('stripe_secret'))
              <div class="col-6 col-md-5">
                <div class="single-payment-method"><a class="credit-card @php if(auth()->user()->balance->balance < ($shop->product->unit_price*1000)){ echo "active"; }@endphp" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-credit-card-2-front" viewBox="0 0 16 16">
                  <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"></path>
                  <path d="M2 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"></path>
                </svg>
                    <h6>Carte bancaire</h6> <br></a></div>
              </div>
              @endif
              @error('payment_type')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
              @enderror
            </div>
            <!-- Checkout Wrapper-->
            <div class="checkout-wrapper-area">
              <!-- Credit Card Info-->
              <div class="credit-card-info-wrapper">
                <div class="pay-credit-card-form">
                  <form id="payment-form" action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @php $check =0; @endphp
                      <input type="text" class="form-control @error('mobile') is-invalid @enderror" style="display:none;" placeholder="{{ __('Phone') }}" name="mobile" value="{{Auth::user()->phone}}">
                      <div class="form-group @php if(auth()->user()->balance->balance >= ($shop->product->unit_price*1000)){ echo "stripe-payment-method-div"; }@endphp pb-3">
                          <label>{{ __('Carte bancaire') }}</label> <span class="text-danger">*</span>
                          <div id="card-element"></div>
                          <div id="card-errors" class="text-danger" role="alert"></div>
                      </div>
                      <div class="col-12 col-md-6 pb-3">
                        <div class="card weekly-product-card">
                          <div class="card-body d-flex align-items-center">
                            <div class="product-thumbnail-side">
                              <a class="product-thumbnail d-block"><img src="{{ $shop->shop->images }}" alt=""></a>
                            </div>
                            <div class="product-description"><a class="product-title d-block">Panier {{$shop->product->name}}</a>
                              <p class="sale-price">Total {{ $shop->product->unit_price }}€  <small> ({{ $shop->product->unit_price*1000 }} YummyCoin)</small></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <input type="text" name="payment_type" id="payment_type" class="payment_type" style="display:none;" value="@php if(auth()->user()->balance->balance < ($shop->product->unit_price*1000)){ echo 15; }else{echo 20;}@endphp">
                      <input type="text" class="pid" name="pid" style="display:none;" value="{{ $shop->id }}">
                    <button id="card-button" class="btn btn-warning btn-lg w-100" type="submit" data-secret="{{ $intent }}">Réserver mon panier</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('footer-js')
	<script>
    const stripeKey = "{{ setting('stripe_key') }}";
  </script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="{{ asset('frontend/js/checkout/stripe.js') }}"></script>
  <script src="{{ asset('frontend/js/image-upload.js') }}"></script>
@endsection
