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

                                                <img alt="image" src="{{asset(empty($value->image)? 'assets/img/default/category.png' : $value->image)}}" width="68" height="68">

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
