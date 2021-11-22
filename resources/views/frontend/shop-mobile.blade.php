@extends('frontend.layouts.mobile')

@section('main-content')
<div class="page-content-wrapper">

  <!-- Product Slides-->

  <div class="product-slides">
    <!-- Single Hero Slide-->
      <div class="single-product-slide" style="background-image: url('{{ $shop->images }}')"></div>
  </div>
  <div class="product-description">
    <!-- Product Title & Meta Data-->
    <div class="product-title-meta-data bg-white py-3">
      <div class="container d-flex justify-content-between">
        <div class="p-title-price">
          <h6 class="mb-1">{{ $shop->name }}</h6>
        </div>
      </div>
    </div>
    <ul class="page-nav ps-0 p-specification mb-3">
      <li><a href="http://maps.google.com/maps?q={{ $shop->address }}" id="address" target="_blank"><div class="coupon-text-wrap d-flex align-items-center">
        <h5 class="pe-3 mb-0"><i class="lni lni-map-marker"></i></h5>
        <p class="ps-2 mb-0"><address style="margin-bottom: unset;">{{ $shop->address }}</address></p>
      </div><i class="lni lni-chevron-right"></i></a></li>
    </ul>
    <!-- Flash Sale Slide-->
    @if($shopProduct->count() > 0)
    <div class="flash-sale-wrapper">
      <div class="container">
        <div class="section-heading d-flex align-items-center justify-content-between">
          <h6 class="me-1 d-flex align-items-center">
            <i class="lni lni-package"></i>&nbsp;PANIER DE CE COMMERCE
          </h6>
        </div>
        <!-- Flash Sale Slide--->
        <div class="flash-sale-slide owl-carousel">
          <!-- Single Flash Sale Card-->
          @foreach($shopProduct as $product)
          <div class="card flash-sale-card">
            <div class="card-body">
              @if($product->quantity != 0)
                @if($product->quantity > 5)
                  <div class="member-plan position-absolute"><span class="badge m-3 badge-rose">5+ à sauver</span></div>
                @else
                  <div class="member-plan position-absolute"><span class="badge m-3 badge-danger">{{ $product->quantity }} à sauver</span></div>
                @endif
              @else
                <div class="member-plan position-absolute"><span class="badge m-3 badge-grey">Rien à sauver</span></div>
              @endif
              <a href="{{ route('shop.product.details', ['shop'=>$shop->slug,'product'=>$product->product->slug]) }}"><img src="{{ asset($shop->getFirstMediaUrl('shops_logo')) }}"><span class="product-title">{{ $product->product->name }}</span>
                @if($product->quantity != 0)
                  <p>Disponible de {{\Carbon\Carbon::createFromFormat('H:i:s',$product->hdispoa)->format('H:i')}} à {{\Carbon\Carbon::createFromFormat('H:i:s',$product->hdispob)->format('H:i')}}</p>
                @endif
                <p class="sale-price">{{ $product->product->unit_price.'€' }} <small>({{ $product->product->unit_price*1000 }} YummyCoin)</small></p>
              </a>
              <a href="{{ route('shop.product.details', ['shop'=>$shop->slug,'product'=>$product->product->slug]) }}" class="btn btn-lg btn-danger cartProtect btn-block mr-1" data-shop_id="{{ $shop->id }}"> <span class="text">Réserver</span> <i class="lni lni-package"></i> </a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    @endif
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
});*/
</script>
@endsection
