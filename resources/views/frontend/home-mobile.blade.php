@extends('frontend.layouts.mobile')
@section('main-content')
<!--&lt;!&ndash; PWA Install Alert&ndash;&gt;
<div class="toast pwa-install-alert shadow bg-white" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000" data-bs-autohide="true">
  <div class="toast-body">
    <div class="content d-flex align-items-center mb-2"><img src="{{ asset('Yummy-box-picto.png') }}" alt="">
      <h6 class="mb-0">Add to Home Screen</h6>
      <button class="btn-close ms-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
    </div><span class="mb-0 d-block">Add Suha on your mobile home screen. Click the<strong class="mx-1">"Add to Home Screen"</strong>button &amp; enjoy it like a regular app.</span>
  </div>
</div>-->

<style>
.card .card-body {
    padding: 0.5rem;
}
</style>
<div class="page-content-wrapper">
  <div class="container">
    <div class="pt-3">
      <!-- Hero Slides-->
      <div class="hero-slides owl-carousel">
        @foreach($banners as $banner)
        <!-- Single Hero Slide-->
         <a href="@if($banner->link != '#') {{ route('shop.show', $banner->link) }} @else {{ $banner->link }}  @endif"><div class="single-hero-slide" style="background-image: url('{{ $banner->images }}')">
           <div class="slide-content h-100 d-flex align-items-center">
           </div>
         </div></a>
         @endforeach
      </div>
    </div>
  </div>
  <!-- Product Catagories-->
  <div class="product-catagories-wrapper py-3">
    <div class="container">
      <div class="section-heading">
        <h6>Nos Catégories</h6>
      </div>
      <div class="product-catagory-wrap">
        <div class="row g-3">
          @foreach($cat as $value)
          <!-- Single Catagory Card-->
          <div class="col-4">
            <div class="card catagory-card">
              <div class="card-body">
                <a class="text-danger" href="{{ route('categories', $value->slug) }}">
                  @if($value->getFirstMediaUrl('categories'))
                  <img alt="image" src="{{ asset($value->getFirstMediaUrl('categories')) }}" width="68" height="68">
                  @else
                  <img alt="image" src="{{ asset('assets/img/default/category.png') }}" width="28" height="28">
                  @endif
                  @php $qty = 0 @endphp
                  <a href="#" style="font-size: 10px;position: absolute;top: 20px;left: 75px;" class="btn btn-dark btn-sm ml-auto rounded-qty">
                    @foreach($value->products as $qt)
                      @foreach($qt->shopproduct as $shopp)
                        @php $qty += $shopp->quantity; @endphp
                      @endforeach
                    @endforeach
                    {{$qty}}</a>
                  <span style="margin-top: 5px;">{{ $value->name }}</span>
                </a>
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>
  <!-- Product Catagories-->
  <div class="product-catagories-wrapper py-3">
    <div class="container">
      <div class="section-heading">
        <h6>PREMIUM</h6>
      </div>
      <div class="product-catagory-wrap">
        <div class="row g-3">
          @foreach($vipcats as $vip)
          <!-- Single Catagory Card-->
          <div class="col-4">
            <div class="card catagory-card">
              <div class="card-body">
                <a class="text-danger" href="{{ route('categories', $vip->slug) }}">
                  @if($vip->getFirstMediaUrl('categories'))
                  <img alt="image" src="{{ asset($vip->getFirstMediaUrl('categories')) }}" width="68" height="68">
                  @else
                  <img alt="image" src="{{ asset('assets/img/default/category.png') }}" width="28" height="28">
                  @endif
                  @php $qty = 0 @endphp
                  <a href="#" style="font-size: 10px;position: absolute;top: 20px;left: 75px;" class="btn btn-dark btn-sm ml-auto rounded-qty">
                    @foreach($vip->products as $qt)
                      @foreach($qt->shopproduct as $shopp)
                        @php $qty += $shopp->quantity; @endphp
                      @endforeach
                    @endforeach
                    {{$qty}}</a>
                  <span style="margin-top: 5px;">{{ $vip->name }}</span>
                </a>
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </div>
    </div>
  </div>

  @foreach($cat as $cate)

  <!-- Weekly Best Sellers-->
  <div class="weekly-best-seller-area py-3">
    <div class="container">
      <div class="section-heading d-flex align-items-center justify-content-between">
        <h6>{{ $cate->name }}</h6><a class="btn btn-success btn-sm" href="{{ route('categories', $cate->slug) }}">Voir</a>
      </div>
      <div class="row g-3">
          <!-- Single Weekly Product Card-->
          @if(!blank($cate->products))
              @foreach($cate->products->take(3) as $proximite)
              @php
              $mytime = Carbon\Carbon::now();
              $heure = $mytime->format('H:i:s');
              $shopProducts = App\Models\ShopProduct::where(['product_id' => $proximite->id])->with('shop')->first();
              /*$shopProduct = App\Models\ShopProduct::where(['product_id' => $proximite->id])->where('quantity', '>', 0)->where('hdispoa', '<=', $heure)->where('hdispob', '>=', $heure)->with('product')->with('shop')->get();*/
              $shopProduct = App\Models\ShopProduct::where(['product_id' => $proximite->id])->where('quantity', '>', 0)->with('product')->with('shop')->get();
              $qty = 0;
              @endphp
              <div class="col-12 col-md-6">
                @foreach($shopProduct as $shops) @php $qty = $shops->quantity; @endphp @endforeach
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
                      <?php
                           $check_fav =  \App\Favourite::where('product_id', $proximite->id)->where('user_id', Auth::user()->id)->first();
                      ?>
                             @if($check_fav)
                        <a style="left: 0.5rem" id="{{$proximite->id}}" c_id="{{$shopProducts->shop->user->id}}" onClick="addtofav(this)" class="wishlist-btn">
                            <img style="height: 25px;" src="{{asset('Yummy-box-picto.png')}}" alt="">
                        </a>
                             @endif
                             <a class="product-thumbnail d-block" href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}">
                                 <img style="width: 100%; height: 100px" src="{{$shopProducts->shop->images??asset('assets/img/default/product.png')}}" alt=""></a></div>
                  <div class="product-description">
                      <a class="product-title d-block" href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}">{{ $proximite->name }}</a>
                      <a style="right: 1.5rem;"  class="wishlist-btn1">
                          <img style="height: 25px; border-radius: 50px; margin-bottom: 0.5rem" src="{{asset($shopProducts->shop->logo)}}" alt="">
                      </a>
                      <br>
                    @if($qty != 0)
                    <p class="sale-price">Panier à {{$proximite->unit_price ?? ''}}€<span>{{$shopProducts->discount_price}}€</span><small style="display:none;"> ({{ $proximite->unit_price*1000 }} YummyCoin)</small></p>@endif
                    @if($qty != 0)<p class="sale-price"><small style="color: grey;">Disponible de @foreach($proximite->shopproduct as $heure) {{\Carbon\Carbon::createFromFormat('H:i:s',$heure->hdispoa)->format('H:i')}} à {{\Carbon\Carbon::createFromFormat('H:i:s',$heure->hdispob)->format('H:i')}} @endforeach</small></p>@endif
                    <div class="product-rating" style="display:none;"><i class="lni lni-star-filled"></i>4.88 (39)</div>
                    @if($qty != 0)<a class="btn btn-danger btn-sm" href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}"><i class="me-1 lni lni-cart"></i>Réserver</a> @else <a class="btn btn-dark btn-sm" href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}"><i class="me-1 lni lni-cart"></i>Plus de panier à sauver</a> @endif
                  </div>
                </div>
              </div>
            </div>
             @endforeach
           @else
           <p>Pas de panier disponible dans cette catégorie pour le moment</p>
           @endif
      </div>
    </div>
  </div>

  @endforeach
  <!-- Discount Coupon Card-
  <div class="container">
    <div class="card discount-coupon-card border-0">
      <div class="card-body">
        <div class="coupon-text-wrap d-flex align-items-center p-3">
          <h5 class="text-white pe-3 mb-0">Get 20% <br> discount</h5>
          <p class="text-white ps-3 mb-0">To get discount, enter the<strong class="px-1">GET20</strong>code on the checkout page.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- Featured Products Wrapper-->
</div>
@endsection
