@extends('frontend.layouts.mobile')
@section('main-content')
    <div class="page-content-wrapper">
        <iframe src="https://www.google.com/maps/search/?api=1&query={{$lat}},{{$lan}}" width="100%" style="border:0; height: 100vh" allowfullscreen="" loading="lazy"></iframe>
    </div>
@endsection
