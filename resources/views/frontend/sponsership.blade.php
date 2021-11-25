@extends('frontend.layouts.mobile')
@section('style')

@endsection
@section('main-content')
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <p class="text-center">Votre code de parrainage</p>
                    <p class="text-center">Invitez votre ami sur "YUMMY BOX" en utilisant ce code de parrainage. Vous obtiendrez 2000 "pièces YUMMY". Vous pouvez utiliser ces pièces pour passer une commande.</p>
                   <b> <h5 id="copycontent" class="text-center">{{$user->refferal}} </h5></b>
                   <p class="text-center"> <a onclick="mycopyFunction()" class="btn btn-sm btn-danger">
                           Copie
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
