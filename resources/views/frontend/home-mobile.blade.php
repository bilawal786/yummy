@extends('frontend.layouts.mobile')
@section('main-content')
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
                        <a href="{{$banner->link}}">
                            <div class="single-hero-slide" style="background-image: url('{{ $banner->images }}');  background-repeat: no-repeat;
                                    background-size: 100% 100%;">
                                <div class="slide-content h-100 d-flex align-items-center">
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Product Catagories-->
        <div class="product-catagories-wrapper py-3">
            <div class="container">
                <div class="section-heading">
                    <h6>{{ __('Nos Catégories') }}</h6>
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
                                                <img loading="lazy" alt="image"
                                                     src="{{ asset($value->getFirstMediaUrl('categories')) }}"
                                                     width="68" height="68">
                                            @else
                                                <img loading="lazy" alt="image"
                                                     src="{{ asset('assets/img/default/category.png') }}" width="28"
                                                     height="28">
                                            @endif
                                            @php $qty = 0 @endphp
                                            <a href="#" style="font-size: 10px;position: absolute;top: 20px;left: 75px;"
                                               class="btn btn-dark btn-sm ml-auto rounded-qty">
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
                    <h6>Premium</h6>
                </div>
                <div class="product-catagory-wrap">
                    <div class="row g-3">
                    @foreach($vipcats as $vip)
                        <!-- Single Catagory Card-->
                            <div class="col-4">
                                <div class="card catagory-card">
                                    <div class="card-body">
                                        <a class="text-danger" href="{{ route('sub-category', $vip->id) }}">
                                            @if($vip->image)
                                                <img loading="lazy" alt="image"
                                                     src="{{ asset($vip->image) }}" width="68"
                                                     height="68">
                                            @else
                                                <img loading="lazy" alt="image"
                                                     src="{{ asset('assets/img/default/category.png') }}" width="28"
                                                     height="28">
                                            @endif
                                            <?php
                                                $sh = \App\Models\Shop::where('subcategory', $vip->id)->pluck('id');
                                                $quantity = \App\Models\ShopProduct::whereIn('shop_id', $sh)->sum('quantity');
                                            ?>
                                            <a href="#" style="font-size: 10px;position: absolute;top: 20px;left: 75px;"
                                               class="btn btn-dark btn-sm ml-auto rounded-qty">
                                               {{$quantity}}</a>
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


        <!-- Weekly Best Sellers-->
        <div class="weekly-best-seller-area py-3">
            <div class="container">
                <div class="row g-3">
                    @foreach($cat as $cate)
                        @if(!blank($cate->products))
                            @foreach($cate->products as $proximite)
                                @php
                                    $mytime = Carbon\Carbon::now();
                                    $heure = $mytime->format('H:i:s');
                                    $shopProducts = App\Models\ShopProduct::where(['product_id' => $proximite->id])->where('quantity', '>', 0)->with('shop')->first();
                                    /*$shopProduct = App\Models\ShopProduct::where(['product_id' => $proximite->id])->where('quantity', '>', 0)->where('hdispoa', '<=', $heure)->where('hdispob', '>=', $heure)->with('product')->with('shop')->get();*/
                                    $shopProduct = App\Models\ShopProduct::where(['product_id' => $proximite->id])->where('quantity', '>', 0)->with('product')->with('shop')->get();
                                    $qty = 0;
                                    if (isset($shopProducts->shop)){
                                     $likes = \App\Favourite::where('product_creator', $shopProducts->shop->user->id)->get()->unique('user_id')->count();
                                     }else{
                                         $likes = 0;
                                     }
                                @endphp
                                @foreach($shopProduct as $shops) @php $qty = $shops->quantity; @endphp
                                @endforeach
                                @if($shopProducts)
                                    <div class="col-12 col-md-6">
                                        <div class="card weekly-product-card"
                                             style="@if($qty == 0) filter: opacity(50%); -webkit-filter: opacity(50%); @endif">
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
                                                    @auth
                                                    <?php
                                                    $check_fav = \App\Favourite::where('product_id', $proximite->id)->where('user_id', Auth::user()->id)->first();
                                                    ?>
                                                    @if($check_fav)
                                                        <a style="left: 0.5rem" id="{{$proximite->id}}"
                                                           c_id="{{$shopProducts->shop->user->id}}"
                                                           onClick="addtofav(this)" class="wishlist-btn">
                                                            <img loading="lazy" style="height: 25px;"
                                                                 src="{{asset('Yummy-box-picto.png')}}" alt="">
                                                        </a>
                                                    @endif
                                                    @endauth
                                                    <a class="product-thumbnail d-block"
                                                       href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}">
                                                        <img loading="lazy" style="width: 100%; height: 100px"
                                                             src="{{$shopProducts->shop->images??asset('assets/img/default/product.png')}}"
                                                             alt="">
                                                    </a>
                                                </div>
                                                <div class="product-description">
                                                    <a class="product-title d-block"
                                                       href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}">{{$shopProducts->shop->name}}
                                                        <br> <i style="color: #ea4c62; font-size: 10px;">{{ $proximite->name }}</i> </a>
                                                    <a style="right: 1.5rem;" class="wishlist-btn1">
                                                        <img loading="lazy"
                                                             style="height: 25px; border-radius: 50px; margin-bottom: 0.5rem"
                                                             src="{{asset($shopProducts->shop->logo)}}" alt="">
                                                        <img loading="lazy" src="{{asset('dislike.png')}}"
                                                             style="height: 10px" alt=""> <span
                                                                style="font-size: 13px"> {{$likes}}</span>
                                                    </a>
                                                    <br>
                                                    @if($qty != 0)
                                                        <p class="sale-price">Panier à {{$proximite->unit_price ?? ''}}€<span>{{$shopProducts->discount_price}}€</span><small
                                                                    style="display:none;">
                                                                ({{ $proximite->unit_price*1000 }} YummyCoin)</small>
                                                        </p>@endif
                                                    @if($qty != 0)<p class="sale-price">
                                                        <small style="color: grey;">Disponible
                                                            de @foreach($proximite->shopproduct as $heure) {{\Carbon\Carbon::createFromFormat('H:i:s',$heure->hdispoa)->format('H:i')}}
                                                            à {{\Carbon\Carbon::createFromFormat('H:i:s',$heure->hdispob)->format('H:i')}} @endforeach
                                                            <br>
                                                            {{$shopProducts->shop->user->country->name}}
                                                        </small>
                                                    </p>@endif

                                                    <div class="product-rating" style="display:none;"><i
                                                                class="lni lni-star-filled"></i>4.88 (39)
                                                    </div>
                                                    @if($qty != 0)<a class="btn btn-danger btn-sm"
                                                                     href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}"><i
                                                                class="me-1 lni lni-cart"></i>Réserver</a> @else <a
                                                            class="btn btn-dark btn-sm"
                                                            href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$proximite->slug]) }}"><i
                                                                class="me-1 lni lni-cart"></i>Plus de panier à
                                                        sauver</a> @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                        {{$cat->links()}}
                </div>
            </div>
        </div>
    </div>
{{--    <button onclick="getLocation()">Try It</button>--}}
    <p id="demo"></p>
@endsection

@section('footer-js')
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
    <script>
        var x = document.getElementById("demo");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;
        }
        // getLocation();
    </script>

    <script>

        var firebaseConfig = {
            apiKey: "AIzaSyC_5Wl09LtYyCVNZq9mn5A9HstB_TzCijI",
            authDomain: "carwash-64763.firebaseapp.com",
            projectId: "carwash-64763",
            storageBucket: "carwash-64763.appspot.com",
            messagingSenderId: "720025103840",
            appId: "1:720025103840:web:f5c124ff8f5095fc424f85",
            measurementId: "G-E9C01SPTJC"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function initFirebaseMessagingRegistration() {
            messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function (token) {
                    console.log(token);

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '{{ route("save-token") }}',
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            token: token
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            alert('Les notifications push sactivent avec succès.');
                        },
                        error: function (err) {
                            console.log('Une erreur sest produite, contactez le développeur' + err);
                        },
                    });

                }).catch(function (err) {
                console.log('Une erreur sest produite, contactez le développeur 1' + err);
            });
        }

        messaging.onMessage(function (payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });

    </script>
@endsection
