@extends('frontend.layouts.mobile')

@section('main-content')

    <div class="page-content-wrapper">
    @php
        $mytime = Carbon\Carbon::now();
        $heure = $mytime->format('H:i:s');
        $shopProducts = App\Models\ShopProduct::where(['product_id' => $shopProduct->product->id])->where('quantity', '>', 0)->with('product')->with('shop')->first();
        $qty = $shopProducts->quantity ?? '0';
    @endphp
    <!-- Product Slides-->

        <div class="product-slides" @if($qty == 0) style=" filter: opacity(50%); -webkit-filter: opacity(50%); "@endif>
            <!-- Single Hero Slide-->
            {{--    @if(!blank($shopProduct->product->thumimages))--}}
            {{--      @foreach($shopProduct->product->thumimages as $thumimage)--}}
            {{--      <div class="single-product-slide" style="background-image: url('{{ $thumimage }}')"></div>--}}
            {{--      @endforeach--}}
            {{--    @else--}}
            <div class="single-product-slide"
                 style="background-image: url('{{ $shopProduct->product->images }}')"></div>
            {{--    @endif--}}
        </div>
        <div class="product-description">
            <!-- Product Title & Meta Data-->
            <div class="product-title-meta-data bg-white py-3">
                <div class="container d-flex justify-content-between"
                     @if($qty == 0) style=" filter: opacity(50%); -webkit-filter: opacity(50%); "@endif>
                    <div class="p-title-price">
                        <h6 class="mb-1">
                            @if($qty != 0)
                                @if($qty > 5)
                                    <span class="badge badge-success">5+</span>
                                @else
                                    <span class="badge badge-danger">{{ $qty }}</span>
                                @endif
                            @endif
                            {{ $shopProduct->product->name }}</h6>
                        <p class="sale-price mb-0">{{ $shopProduct->product->unit_price }}€<span>{{$shopProduct->discount_price}}€</span><small>
                                ({{ $shopProduct->product->unit_price*1000 }} YummyCoin)</small></p>
                    </div>
                    <div class="p-wishlist-share"
                         @if($qty == 0) style=" filter: opacity(50%); -webkit-filter: opacity(50%); "@endif>
                        <form class="cart-form" action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $shopProduct->id }}" name="shop_product_id">
                            @if($qty != 0)
                                <button class="btn btn-lg btn-danger cartProtect mr-1" type="submit"
                                        data-shop_id="{{ $shopProduct->shop_id }}"><span class="text">Réserver</span>
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            @if($qty != 0)
                <div class="p-specification bg-white" style="padding: 0.0rem 0.3rem;">
                    <div class="container">
                        <div class="coupon-text-wrap d-flex align-items-center">
                            <h5 class="pe-3 mb-0"><i class="lni lni-alarm-clock"></i></h5>
                            <p class="ps-2 mb-0">Disponible
                                de {{\Carbon\Carbon::createFromFormat('H:i:s',$shopProduct->hdispoa)->format('H:i')}}
                                à {{\Carbon\Carbon::createFromFormat('H:i:s',$shopProduct->hdispob)->format('H:i')}}</p>
                        </div>
                    </div>
                </div>
            @endif
            <ul class="page-nav ps-0 p-specification mb-3">
                <li><a href="{{ route('shop.show', $shopProduct->shop->slug) }}">
                        <div class="coupon-text-wrap d-flex align-items-center">
                            <h5 class="pe-3 mb-0"><i class="lni lni-map-marker"></i></h5>
                            <p class="ps-2 mb-0">{{ $shopProduct->shop->address }}</p>
                        </div>
                        <i class="lni lni-chevron-right"></i></a></li>
            </ul>
            <!-- Product Specification-->
            <div class="p-specification bg-white mb-3 py-3">
                <div class="container">
                    <h6>Ce que vous pouvez avoir</h6>
                    <p>{!! $shopProduct->product->description !!}</p>
                </div>
            </div>
            <div class="p-specification bg-white mb-3 py-3">
                <div class="container">
                    <h6>FAVORIS</h6>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body" style="text-align: center">

                                    @auth
                                        @if($check_fav)
                                            <a id="{{$shopProduct->product->id}}" class="dislike"
                                               c_id="{{$shopProduct->shop->user->id}}" onClick="addtofav(this)">
                                                <img style="height: 40px; margin-bottom: 10px"
                                                     src="{{asset('Yummy-box-picto.png')}}" alt="">
                                            </a>
                                        @else
                                            <a id="{{$shopProduct->product->id}}" class="like"
                                               c_id="{{$shopProduct->shop->user->id}}" onClick="addtofav(this)">
                                                <img style="height: 40px; margin-bottom: 10px"
                                                     src="{{asset('like.png')}}" alt="">
                                            </a>
                                            <a id="{{$shopProduct->product->id}}" style="display: none"
                                               class="temporary" c_id="{{$shopProduct->shop->user->id}}"
                                               onClick="addtofav(this)">
                                                <img style="height: 40px; margin-bottom: 10px"
                                                     src="{{asset('Yummy-box-picto.png')}}" alt="">
                                            </a>
                                        @endif
                                        <p>Favori</p>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body" style="text-align: center">
                                    <h2 class="fav_count">{{$favourites->count()}}</h2>
                                    <p>Favoris</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add To Cart-->
            <div class="cart-form-wrapper bg-white mb-3 py-3">
                <div class="container">
                    <form class="cart-form" action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $shopProduct->id }}" name="shop_product_id">
                        @if($qty != 0)
                            <button class="btn btn-lg btn-danger cartProtect btn-block mr-1" type="submit"
                                    data-shop_id="{{ $shopProduct->shop_id }}"><span class="text">Réserver</span> <i
                                        class="lni lni-package"></i></button>
                        @else
                            <button class="btn btn-lg btn-dark cartProtect btn-block mr-1" type="submit"
                                    data-shop_id="{{ $shopProduct->shop_id }}" disabled><span class="text">Aucun panier disponible</span>
                            </button>
                        @endif
                    </form>
                </div>
            </div>
            <!-- Product Specification-->
            <div class="p-specification bg-white py-3">
                <div class="container">
                    <h6>Ce que vous devez savoir</h6>
                    <p>{!! $shopProduct->shop->description !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-js')

@endsection
