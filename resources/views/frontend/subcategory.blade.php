@extends('frontend.layouts.mobile')
@section('main-content')
    <div class="page-content-wrapper py-3">
        <div class="product-catagories-wrapper py-3">
            <div class="container">
                <div class="product-catagory-wrap">
                    <div class="row g-3">
                    @foreach($subcategory as $value)
                        <!-- Single Catagory Card-->
                            <div class="col-4">
                                <div class="card catagory-card">
                                    <div class="card-body">
                                        <a class="text-danger" href="{{route('subcategory.products', ['id' => $value->id])}}">

                                                <img loading="lazy" alt="image" src="{{asset(empty($value->image)? 'assets/img/default/category.png' : $value->image)}}" width="68" height="68">
                                            <a href="#" style="font-size: 10px;position: absolute;top: 20px;left: 75px;" class="btn btn-dark btn-sm ml-auto rounded-qty">
<?php
                                                $products = \App\Models\Product::where('subcategories', $value->id)->pluck('id');
                                              $count =   \App\Models\ShopProduct::whereIn('product_id',                                                            $products)->sum('quantity');
                                                $qty = 0
                                                ?>
                                               {{$count}}</a>
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
    </div>
@endsection
