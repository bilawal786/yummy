@extends('frontend.layouts.mobile')
@section('main-content')
<div class="page-content-wrapper">
  @php
  \Carbon\Carbon::setlocale('fr');
  @endphp
  <!-- Product Slides-->

  <div class="product-slides">
      @if(Session::has('message'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Succès! </strong> {{ Session::get('message') }}
          </div>
  @endif
    <!-- Single Hero Slide-->
      <div class="single-product-slide" style="background-image: url('{{ $order->shop->images??'' }}')"></div>
  </div>
  <div class="product-description">
    <!-- Product Title & Meta Data-->
    <div class="product-title-meta-data bg-white py-3">
      <div class="container d-flex justify-content-between">
        <div class="p-title-price">
          <h6 class="mb-1">{{ $order->shop->name??'' }}</h6>
          <p><span>{{ \Carbon\Carbon::parse($order->created_at)->translatedformat('d M')}} </span></p>
            <p class="badge @if($order->status == 20) bg-success @elseif($order->status == 10) bg-danger @else bg-warning @endif ms-1">{{trans('order_status.' . $order->status)}}</p>
        </div>
      </div>
    </div>
    <ul class="page-nav ps-0 p-specification mb-3">
      <li><a href="http://maps.google.com/maps?q={{ $order->shop->address??'' }}" id="address" target="_blank"><div class="coupon-text-wrap d-flex align-items-center">
        <h5 class="pe-3 mb-0"><i class="lni lni-map-marker"></i></h5>
        <p class="ps-2 mb-0"><address style="margin-bottom: unset;">{{ $order->shop->address??'' }}</address></p>
      </div><i class="lni lni-chevron-right"></i></a></li>
    </ul>
    <!-- Flash Sale Slide-->
    <div class="p-specification bg-white mb-3 py-3">
      <div class="container">
        <h6>Votre commande</h6>
        <p>@foreach($order->items as $item) {{ $item->quantity }} x {{ $item->product->name }}<br>@endforeach</p>
      </div>
    </div>

    <div class="p-specification bg-white mb-3 py-3">
      <div class="container">
        <h6>Total : {{ currencyFormat($order->total) }}</h6>
      </div>
    </div>
    <!-- Add To Cart-->

    <div class="cart-form-wrapper bg-white mb-3 py-3">
      <div class="container">
        @if($order->status == '17')
        <form class="cart-form" action="{{ route('checkout.order_validation') }}" method="POST">
          @csrf
          <input type="hidden" value="{{ $order->id }}" name="order_id">
          <button type="submit" class="btn btn-lg btn-warning cartProtect btn-block mr-1"> <span class="text">J'ai récupéré ma commande</span> <i class="lni lni-package"></i> </button>
        </form>
        @elseif($order->status == '20')
        <button class="btn btn-lg btn-success cartProtect btn-block mr-1" disabled> <span class="text">{{trans('order_status.' . $order->status)}}</span></button>
        @else
        <button class="btn btn-lg btn-danger cartProtect btn-block mr-1" disabled> <span class="text">{{trans('order_status.' . $order->status)}}</span></button>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
@section('footer-js')
<script>
/*$(document).ready(function () {
    //Convert address tags to google map links
    $('address').each(function () {
        var link = "http://maps.google.com/maps?q=" + encodeURIComponent($(this).text());
        //$(this).html();
        $("a#address").prop("href", link);
    });
});*
</script>
@endsection
