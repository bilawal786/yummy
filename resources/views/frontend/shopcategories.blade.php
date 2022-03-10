@extends('frontend.layouts.mobile')
@section('main-content')
    <style>
        .card .card-body {
            padding: 0.5rem;
        }
    </style>
    <div class="page-content-wrapper">
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
                                        <a class="text-danger" href="{{ route('shop-categories', ['cat' => $value->id, 'id' => $id]) }}">
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
                                                <?php
                                                $category = \App\Models\CategoryShop::where('category_id', $value->id)->pluck('shop_id');
                                                $shops = \App\Models\Shop::whereIn('id', $category)->where('subcategory', '=', $id)->get();
                                                ?>
                                                {{$shops->count()}}</a>
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
