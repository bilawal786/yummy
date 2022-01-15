@extends('frontend.layouts.mobile')
@section('main-content')
    <div class="page-content-wrapper">
        <!-- Weekly Best Sellers-->
        <div class="weekly-best-seller-area py-3">
            <div class="container">
                <div class="row g-3">
                    <!-- Single Weekly Product Card-->
                    @foreach($notfications as $notfication)
                        @if($notfication->activity == "Nouveau panier")
                        @php
                        $product = \App\Models\Product::where('id', $notfication->generate_id)->first();
                           $shopProducts = App\Models\ShopProduct::where(['product_id' => $notfication->generate_id])->first();
                        @endphp
                        @if(isset($shopProducts->shop))
                        <a href="{{ route('shop.product.details', ['shop'=>$shopProducts->shop->slug,'product'=>$product->slug]) }}">
                            <div class="card weekly-product-card">
                                <div class="card-body d-flex">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="lni lni-bullhorn"></i>
                                        </div>
                                        <div class="col-10">
                                            <h5>{{$notfication->activity}}</h5>
                                            <p>{{$notfication->message}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                       @endif
                        @elseif($notfication->activity == "Message de l'administrateur")
                        <a href="#">
                            <div class="card weekly-product-card">
                                <div class="card-body d-flex">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="lni lni-bullhorn"></i>
                                        </div>
                                        <div class="col-10">
                                            <h5>{{$notfication->activity}}</h5>
                                            <p>{{$notfication->message}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
