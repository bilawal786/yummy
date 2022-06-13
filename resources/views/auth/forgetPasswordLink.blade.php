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
    <h2 class="my-head">{{ __('message.réinitialiser') }}(2/2)</h2>
  </div>
   <div class="p-5" style="padding-top: 20px !important;padding-bottom: 20px !important;">
     @if (session('status'))
         <div class="alert alert-success" role="alert">
             {{ session('status') }}
         </div>
     @endif
     <form method="POST" action="{{ route('reset.password.post') }}">
         @csrf
         <input type="hidden" name="token" value="{{ $token }}">
         <div class="form-group">
            <label>{{ __('message.email') }}{{ __('Email') }}</label><span class="text-danger">*</span>
            <input type="text" id="email_address" class="form-control" name="email" required autofocus>
             @if($errors->has('email'))
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $errors->first('email') }}</strong>
                 </span>
             @endif
         </div>
         <div class="form-group">
            <label>{{ __('message.mot') }}</label><span class="text-danger">*</span>
             <input type="password" id="password" class="form-control" name="password" required autofocus>
             @if($errors->has('password'))
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $errors->first('password') }}</strong>
                 </span>
             @endif
         </div>
         <div class="form-group">
            <label>{{ __('message.confirmation') }}</label><span class="text-danger">*</span>
              <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
             @if($errors->has('password_confirmation'))
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $errors->first('password_confirmation') }}</strong>
                 </span>
             @endif
         </div>
         <div class="form-group">
             <button type="submit" class="btn btn-success rounded btn-lg btn-block">
                 {{ __('message.réinitialiser') }}
             </button>
         </div>
     </form>
   </div>
</div>
