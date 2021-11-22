@extends('frontend.layouts.mobile')
@section('style')
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
@endsection
@section('main-content')

<div class="page-content-wrapper">
   <div class="container">
     <div class="profile-wrapper-area py-3">
       <!-- User Information-->
       <div class="card user-info-card">
         <div class="card-body p-4 d-flex align-items-center">
           <div class="user-info">
             <p style="color:white" class="mb-0 counter">Vous avez actuellement {{ $user->balance->balance }} {{ __('YummyCoin') }}</p>
           </div>
         </div>
       </div>
          <!-- User Meta Data-->
          <div class="card user-data-card">
            <div class="card-body">
              <form id="payment-form" action="{{ route('yummycharge') }}" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                  <div class="title mb-2"><span>Nombre de YummyCOIN</span></div>
                    <select name="deposit_amount" id="deposit_amount" class="form-control" onchange="getval(this)">
                      @foreach ($yummycoin as $coin)
                      <option value="{{ $coin->valeur }}" data-montant="{{ $coin->nombre }}">{{ $coin->nombre }} YummyCOIN</option>
                      @endforeach
                    </select>
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><span>Paiement sécurisé par carte</span></div>
                  @csrf
                  @php $check =0; @endphp
                  <input type="text" class="form-control" name="coin" value="1" hidden>
                  <input type="text" name="valeur" id="valeur" hidden>
                    <select name="payment_type" id="payment_type" class="form-control @error('payment_type') is-invalid @enderror " hidden>
                        @if(setting('stripe_key') && setting('stripe_secret'))
                            <option value="{{ App\Enums\PaymentMethod::STRIPE }}" @if (old('payment_type') == App\Enums\PaymentMethod::STRIPE) selected="selected" @endif>{{ __('Payer par carte bancaire') }}</option>
                        @endif
                    </select>
                    @error('payment_type')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="form-group stripe-payment-method-div pb-3" style="margin-top: 1rem;">
                        <div id="card-element"></div>
                        <div id="card-errors" class="text-danger" role="alert"></div>
                    </div>
                </div>
                <div class="mb-3">
                  <h6 class="text-dark m-0">Total <span class="float-right counter" id="total"></span></h6>
                </div>
                <button id="card-button" class="btn btn-success w-100" type="submit">Recharger mon compte</button>
              </form>
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
<script>
$(document).ready(function() {
  var Valcoin = $('#deposit_amount option:selected').data('montant');
  document.getElementById("total").innerHTML = document.getElementById('deposit_amount').value+' €';
  document.getElementById("valeur").value =  Valcoin;
  console.log(document.getElementById("valeur").value);
  $.ajax({
       type:'POST',
       url: '/coinjson/',
       method:"POST",
       async: false,
       data:{
          valeur: document.getElementById('deposit_amount').value
        },
       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
       success:function(data){
          cardButton.dataset.secret = data;
          tmp = data;
       }
      });
  $('#deposit_amount').on("change",function(){
    var Valcoin = $('#deposit_amount option:selected').data('montant');
    document.getElementById("valeur").value = Valcoin;
    console.log(document.getElementById("valeur").value);
  });
});

function getval(sel){
  document.getElementById("total").innerHTML = sel.value+' €';
  $.ajax({
       type:'POST',
       url: '/coinjson/',
       method:"POST",
       async: false,
       data:{
          valeur: sel.value
        },
       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
       success:function(data){
          cardButton.dataset.secret = data;
          tmp = data;
       }
    });
  //document.getElementById("prix").innerHTML = sel.value+' €';

}
</script>
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('frontend/js/checkout/stripe.js') }}"></script>

@endsection
