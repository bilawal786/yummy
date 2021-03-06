@extends('frontend.layouts.mobile')

@section('main-content')
<div class="page-content-wrapper">
  <!-- Weekly Best Sellers-->
  <div class="weekly-best-seller-area py-3">
    <div class="container">
      <div class="row g-3">
          <!-- Single Weekly Product Card-->
          @if($products)
              @foreach($products as $proximite)
              @php
              $qty = $proximite->quantity;

              @endphp
              <div class="col-12 col-md-6">
              <div class="card weekly-product-card" style="@if($qty == 0) filter: opacity(50%); -webkit-filter: opacity(50%); @endif">
                <div class="card-body d-flex align-items-center">
                  <div class="product-thumbnail-side">
                         @if($qty != 0)
                           @if($qty > 5)
                             <span class="badge badge-success">5+</span>
                           @else
                             <span class="badge badge-danger">{{ $qty }}</span>
                           @endif
                         @else
                           <span class="badge badge-info">Rien à sauver</span>
                         @endif
                    <a class="wishlist-btn" href="#"><i class="lni lni-heart"></i></a><a class="product-thumbnail d-block" ><img src="{{ $proximite->shop->images }}" alt=""></a></div>
                  <div class="product-description"><a class="product-title d-block" >{{ $proximite->product->name }}</a>
                    @if($qty != 0)
                    <p class="sale-price">Panier à {{$proximite->product->unit_price ?? ''}}€<span>{{$proximite->discount_price}}€</span><small style="display:none;"> ({{ $proximite->unit_price*1000 }} YummyCoin)</small></p>@endif
                    @if($qty != 0)<p class="sale-price"><small style="color: grey;">Aujourd'hui de {{\Carbon\Carbon::createFromFormat('H:i:s',$proximite->hdispoa)->format('H:i')}} à {{\Carbon\Carbon::createFromFormat('H:i:s',$proximite->hdispob)->format('H:i')}}</small></p>@endif
                    <div class="product-rating" style="display:none;"><i class="lni lni-star-filled"></i>4.88 (39)</div>
                    @if($qty != 0)<a class="btn btn-danger btn-sm" href="{{ route('shop.product.details', ['shop'=>$proximite->shop->slug,'product'=>$proximite->product->slug]) }}"><i class="me-1 lni lni-cart"></i>Réserver</a> @else <a class="btn btn-dark btn-sm" href="{{ route('shop.product.details', ['shop'=>$proximite->shop->slug,'product'=>$proximite->product->slug]) }}"><i class="me-1 lni lni-cart"></i>Plus de panier à sauver</a> @endif
                  </div>
                </div>
              </div>
            </div>
             @endforeach
          @else
              <p>Élément recherché non trouvé </p>
          @endif
      </div>
    </div>
  </div>
</div>
@endsection
