@extends('frontend.layouts.mobile')
@section('main-content')
<div class="page-content-wrapper">
  <!-- Weekly Best Sellers-->
  <div class="weekly-best-seller-area py-3">
    <div class="container">
      <div class="row g-3">
          <!-- Single Weekly Product Card-->
          @if(!blank($cate->products))
              @foreach($cate->products as $proximite)
              @php
              $mytime = Carbon\Carbon::now();
              $heure = $mytime->format('H:i:s');
              $shopProducts = App\Models\ShopProduct::where(['product_id' => $proximite->id])->where('quantity', '>', 0)->with('shop')->first();
              $shopProduct = App\Models\ShopProduct::where(['product_id' => $proximite->id])->where('quantity', '>', 0)->with('product')->with('shop')->get();
              $qty = 0;
              @endphp
              <div class="col-12 col-md-6">
                @foreach($shopProduct as $shops) @php $qty = $shops->quantity; @endphp @endforeach
                    @if($shopProducts)
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
                                 <a id="{{$proximite->id}}" c_id="{{$shopProducts->shop->user->id}}" onClick="addtofav(this)" class="wishlist-btn">
                                     <img loading="lazy" style="height: 25px;" src="{{asset('Yummy-box-picto.png')}}" alt="">
                                 </a>
                             @endif
                             <a class="product-thumbnail d-block" href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}">
                                 <img loading="lazy" style="width: 100%; height: 100px" src="{{ $shopProducts->shop->images }}" alt=""></a></div>
                  <div class="product-description">
                      <a class="product-title d-block" href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}">{{ $proximite->name }}</a>
                      <a style="right: 1.5rem;"  class="wishlist-btn1">
                          <img loading="lazy" style="height: 25px; border-radius: 50px; margin-bottom: 0.5rem" src="{{asset($shopProducts->shop->logo)}}" alt="">
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
                    @endif
            </div>
             @endforeach
           @endif
      </div>
    </div>
  </div>
</div>
@endsection
