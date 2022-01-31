@extends('frontend.layouts.mobile')
@section('main-content')
    <div class="page-content-wrapper">
        <!-- Weekly Best Sellers-->
        <div class="weekly-best-seller-area py-3">
            <div class="container">
                <div class="row g-3">
                    @foreach($shops as $shop)
                        <?php
                        if (isset($shop)){
                            $likes = \App\Favourite::where('product_creator', $shop->user->id)->get()->unique('user_id')->count();
                        }else{
                            $likes = 0;
                        }
                        ?>
                      <div class="col-12 col-md-6">
                                    <div class="card weekly-product-card"
                                         >
                                        <div class="card-body d-flex align-items-center">
                                            <div class="product-thumbnail-side">
                                                <a class="product-thumbnail d-block"
                                                   href="{{route('shop-products', ['id' => $shop->id])}}">
                                                    <img
                                                        loading="lazy" style="width: 100%; height: 100px"
                                                        src="{{$shop->images??asset('assets/img/default/product.png')}}" alt=""></a></div>
                                            <div class="product-description">
                                                <a class="product-title d-block"
                                                   href="">
                                                    {{$shop->name}}</a>
                                                <img loading="lazy"
                                                     style="height: 25px; border-radius: 50px; margin-bottom: 0.5rem"
                                                     src="{{$shop->logo}}" alt="">
                                                <img loading="lazy" src="{{asset('dislike.png')}}" style="height: 10px"
                                                     alt=""> <span style="font-size: 13px"> {{$likes}}</span>

                                                <p class="sale-price">
                                                    <small style="color: grey;">
                                                        <br>
                                                        {{$shop->user->country->name}}
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
