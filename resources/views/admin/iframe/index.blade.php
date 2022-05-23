@extends('admin.layouts.master')
<style>
    .iframe{
        height: 600px;
        margin-top: 50px;
        width: 100%;
        border: 0px
    }
    @media only screen and (max-width: 668px) {
        .iframe{
            height: 100vh;
            width: 100%;

        }
    }


</style>
@section('main-content')

    <iframe src="https://demo.yummybox.fr/admin/login" class="iframe"  title="W3Schools Free Online Web Tutorials">
    </iframe>

@endsection