@extends('frontend.layouts.mobile')
@section('style')

@endsection
@section('main-content')
    <div class="page-content-wrapper">
        <div class="container" style="height: 100vh; padding-top: 500px; background-image:url('{{asset('part2.jpg')}}'); background-repeat: no-repeat; background-size: 100% 100%;">
{{--            <img style="width: 100%" src="{{asset('par.png')}}" alt="">--}}
           <div class="" style="margin-top: 30px">
                <div class="card-body">
                   <b> <h5 style="background-color: white; border-radius: 10px" id="copycontent" class="text-center">{{$user->refferal}} </h5></b>
                   <p class="text-center">
                       <a onclick="mycopyFunction()" style="background-color: #fab332" class="btn btn-sm">
                           {{ __('message.copie') }}
                    </a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-js')
<script>
    function mycopyFunction() {
        var copyText = document.getElementById("copycontent").innerText;
        var elem = document.createElement("textarea");
        document.body.appendChild(elem);
        elem.value = copyText;
        elem.select();
        document.execCommand("copy");
        document.body.removeChild(elem);
    }
</script>
@endsection
