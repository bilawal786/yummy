@extends('frontend.layouts.mobile')
@section('main-content')
    <div class="page-content-wrapper">
        <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAeKxMwTMJzHH2AR1xt7OLWIWFMIzm-JLM&libraries
&q={{$lat}},{{$lan}}" width="100%" style="border:0; height: 100vh" allowfullscreen="" loading="lazy"></iframe>
    </div>
@endsection
