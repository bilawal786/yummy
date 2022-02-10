<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" >
      <meta name="apple-mobile-web-app-capable" content="yes" >
      <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
      <link rel="manifest" href="manifest.json">
      <link rel="icon" sizes="192x192" href="android/android-launchericon-192-192.png">
      <link rel="apple-touch-icon" href="android/android-launchericon-192-192.png">
      <link rel="apple-touch-startup-image" href="android/android-launchericon-192-192.png">

      <link rel="icon" type="image/png" href="android/android-launchericon-192-192.png">
      <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <title>YummyBox</title>
      <!-- Slick Slider -->
      <link rel="stylesheet" type="text/css" href="{{asset('app/vendor/slick/slick.min.css')}}"/>
      <link rel="stylesheet" type="text/css" href="{{asset('app/vendor/slick/slick-theme.min.css')}}"/>
      <!-- Icofont Icon-->
      <script src="https://kit.fontawesome.com/e5cca4eee6.js" crossorigin="anonymous"></script>
      <link href="{{asset('app/vendor/icons/icofont.min.css')}}" rel="stylesheet" type="text/css">

      <!-- Bootstrap core CSS -->
      <link href="{{asset('app/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="{{asset('app/css/style.css')}}" rel="stylesheet">
      <!-- Sidebar CSS -->
      <link href="{{asset('app/vendor/sidebar/demo.css')}}" rel="stylesheet">
   </head>
<!-- sign up -->
@php $check=0; @endphp
<div class="osahan-signup">
  <div class="border-head p-5 d-flex align-items-center">
    <h2 class="my-head">Réinitialiser mon mot de passe (1/2)</h2>
  </div>
   <div class="p-5" style="padding-top: 20px !important;padding-bottom: 20px !important;">
     @if (session('status'))
         <div class="alert alert-success" role="alert">
             {{ session('status') }}
         </div>
     @endif
     <form method="POST" action="{{ route('forget.password.post') }}">
         @csrf
         <div class="form-group">
            <label>{{ __('Email') }}</label><span class="text-danger">*</span>
             <input id="email" type="email" class="form-control @if($errors->has('email')) is-invalid @endif"
                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
             @if($errors->has('email'))
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $errors->first('email') }}</strong>
                 </span>
             @endif
         </div>
         <div class="form-group">
             <button type="submit" class="btn btn-success rounded btn-lg btn-block">
                 {{ __('Réinitialiser mon mot de passe') }}
             </button>
         </div>
     </form>
      <p class="text-muted text-center small py-2 m-0">ou</p>
      <a href="{{ route('login') }}" class="btn btn-success btn-lg rounded btn-block">
      J'ai déjà un compte
    </a>
   </div>
</div>
