@extends('frontend.layouts.mobile')
@section('main-content')
    <div class="page-content-wrapper">
        <!-- Weekly Best Sellers-->
        <div class="weekly-best-seller-area py-3">
            <div class="container">
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
