@extends('frontend.layouts.mobile')
@section('main-content')
    <div class="page-content-wrapper">
        <!-- Weekly Best Sellers-->
        <div class="weekly-best-seller-area py-3">
            <div class="container">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="top-search-form">
                            <form action="{{route('traders.search')}}" method="POST">
                                @csrf
                                <input style="width:100%; max-width: 100%" class="form-control" name="name" placeholder="Entrez le nom du commerçant">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    @foreach($traders as $trader)
                        <div class="col-12 col-md-6">
                            <div class="card weekly-product-card" style="">
                                <div class="card-body d-flex align-items-center">
                                    <div class="product-thumbnail-side">
                                        <a class="product-thumbnail d-block"
                                           href="#">
                                            <img loading="lazy" style="width: 100%; height: 100px"
                                                 src="{{$trader->images}}" alt="">
                                        </a>
                                    </div>
                                    <?php
                                    if (isset($trader->user)) {
                                        $shop_product = \App\Models\ShopProduct::where('shop_id', $trader->id)->first();
                                        if ($shop_product){
                                            $product = \App\Models\Product::find($shop_product->product_id);
                                            if (Auth::user()){
                                                $check = \App\Favourite::where('product_id', $shop_product->product_id)->where('user_id', Auth::user()->id)->first();
                                            }
                                        }
                                        $likes = \App\Favourite::where('product_creator', $trader->user->id)->get()->unique('user_id')->count();
                                    } else {
                                        $likes = 0;
                                    }
                                    ?>

                                    <div class="product-description">
                                        <a class="product-title d-block"
                                           href="#"><font
                                                    style="vertical-align: inherit;"><font
                                                        style="vertical-align: inherit;">{{$trader->name}}</font></font></a>
                                        <a style="right: 1.5rem;" class="wishlist-btn1">
                                            <img loading="lazy"
                                                 style="height: 25px; border-radius: 50px; margin-bottom: 0.5rem"
                                                 src="{{$trader->logo}}" alt="">
                                            <img loading="lazy" src="{{asset('dislike.png')}}"
                                                 style="height: 10px"
                                                 alt=""> <span style="font-size: 13px"><font
                                                        style="vertical-align: inherit;"><font
                                                            style="vertical-align: inherit;"> {{$likes}}</font></font></span>
                                        </a>
                                        <div style="float: right">
                                            @if(isset($trader->user))
                                                @auth
                                                @if(isset($check))
                                                    <a id="{{$product->id}}" class="dislike" c_id="{{$trader->user->id}}" onClick="addtofav(this)" >
                                                        <img style="height: 30px; margin-bottom: 10px" src="{{asset('Yummy-box-picto.png')}}" alt="">
                                                    </a>
                                                @else
                                                <a id="{{$product->id}}" class="like{{$product->id}}" c_id="{{$trader->user->id}}" onClick="addtofavtrader(this)" >
                                                    <img loading="lazy" src="{{asset('like.png')}}"
                                                         style="height: 30px"
                                                         alt="">
                                                </a>
                                                <a id="{{$product->id}}" style="display: none" class="temporary{{$product->id}}" c_id="{{$trader->user->id}}" onClick="addtofavtrader(this)" >
                                                    <img style="height: 30px; margin-bottom: 10px" src="{{asset('Yummy-box-picto.png')}}" alt="">
                                                </a>
                                                @endif
                                                @endauth
                                            @endif
                                        </div>

                                        <br>
                                        <p class="sale-price"><small style="color: grey;"><font
                                                        style="vertical-align: inherit;"><font
                                                            style="vertical-align: inherit;">Disponible
                                                        depuis {{\Carbon\Carbon::createFromFormat('H:i:s',$trader->opening_time)->format('H:i')}}
                                                        à {{\Carbon\Carbon::createFromFormat('H:i:s',$trader->closing_time)->format('H:i')}} </font></font></small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{$traders->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection
