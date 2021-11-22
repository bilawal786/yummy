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
      <link rel="stylesheet" type="text/css" href="app/vendor/slick/slick.min.css"/>
      <link rel="stylesheet" type="text/css" href="app/vendor/slick/slick-theme.min.css"/>
      <!-- Icofont Icon-->
      <script src="https://kit.fontawesome.com/e5cca4eee6.js" crossorigin="anonymous"></script>
      <link href="app/vendor/icons/icofont.min.css" rel="stylesheet" type="text/css">

      <!-- Bootstrap core CSS -->
      <link href="app/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="app/css/style.css" rel="stylesheet">
      <!-- Sidebar CSS -->
      <link href="app/vendor/sidebar/demo.css" rel="stylesheet">
   </head>
<!-- sign up -->
@php $check=0; @endphp
<div class="osahan-signup">
  <div class="border-head p-5 d-flex align-items-center">
    <h2 class="my-head">Créez un compte !</h2>
  </div>
   <div class="p-5" style="padding-top: 20px !important;padding-bottom: 20px !important;">
      <form method="POST" action="{{ route('register') }}">
          @csrf
        <div class="form-row" style="display:none">
            <div class="col form-group">
                <label class="js-check box {{ old('roles', 2)== 2 ? 'active' : ''}}">
                    <input type="radio" name="roles" value="2" {{ old('roles', 2)== 2 ? 'checked' : ''}}>
                    <h7 class="title">Je suis un Client</h7>
                </label>
            </div>
            <div class="col form-group">
                <label class="js-check box {{ old('roles')== 3 ? 'active' : ''}}">
                    <input type="radio" name="roles" value="3" {{ old('roles')== 3 ? 'checked' : ''}}>
                    <h7 class="title">Je suis un Vendeur</h7>
                </label>
            </div>
        </div> <!-- row.// -->
         <div class="form-group">
           <label>{{ __('Prénom') }}</label><span class="text-danger">*</span>
           <input name="first_name" value="{{ old('first_name') }}" type="text"
               class="form-control @if($errors->has('first_name')) is-invalid @endif" placeholder="John">
           @if($errors->has('first_name'))
           <span class="invalid-feedback" role="alert">
               <strong>{{ $errors->first('first_name') }}</strong>
           </span>
           @endif
         </div>
         <div class="form-group">
           <label>{{ __('Nom') }}</label><span class="text-danger">*</span>
           <input name="last_name" value="{{ old('last_name') }}" type="text"
               class="form-control @if($errors->has('last_name')) is-invalid @endif" placeholder="Doe">
           @if($errors->has('last_name'))
           <span class="invalid-feedback" role="alert">
               <strong>{{ $errors->first('last_name') }}</strong>
           </span>
           @endif
         </div>
         <div class="form-group">
            <label for="email">Email</label>
            <input name="email" value="{{ old('email') }}" type="email"
                class="form-control @if($errors->has('email')) is-invalid @endif"
                placeholder="johndoe@example.com">
            <!--<small class="form-text text-muted">{{ __('We\'ll never share your email with anyone else.') }}</small>-->
            @if($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
         <div class="form-group">
            <label for="phone">Numéro de téléphone</label>
            <input name="phone" value="{{ old('phone') }}" type="text" class="form-control @if($errors->has('phone')) is-invalid @endif"
                placeholder="06 90 12 34 56">

            @if($errors->has('phone'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('phone') }}</strong>
            </span>
            @endif
         </div>
         <div class="form-group">
           <label>{{ __('Région') }}</label>
           <select class="form-control" name="address" class="form-control @if($errors->has('address')) is-invalid @endif">
             @php use App\Models\Location; $regions = Location::all(); @endphp
             @foreach($regions as $region)
             <option value="{{$region->id}}">{{$region->name}}</option>
             @endforeach
           </select>
           @if($errors->has('address'))
           <span class="invalid-feedback" role="alert">
               <strong>{{ $errors->first('address') }}</strong>
           </span>
           @endif
         </div>
         <div class="form-group">
           <label for="password">{{ __('Mot de passe') }}</label><span class="text-danger">*</span>
           <input name="password" class="form-control @if($errors->has('password')) is-invalid @endif"
               type="password" placeholder="Mot de passe">
           @if($errors->has('password'))
           <span class="invalid-feedback" role="alert">
               <strong>{{ $errors->first('password') }}</strong>
           </span>
           @endif
         </div>
         <div class="form-group">
            <label>{{ __('Confirmation du mot de passe') }}</label><span class="text-danger">*</span>
            <input name="password_confirmation"
                class="form-control @if($errors->has('password_confirmation')) is-invalid @endif"
                type="password" placeholder="Confirmation du mot de passe">
            @if($errors->has('password_confirmation'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
            @endif
         </div>
         <div class="form-group">
           <label  class="custom-control custom-checkbox">
               <input name="terms_and_conditions" class="custom-control-input @if($errors->has('terms_and_conditions')) is-invalid @endif" type="checkbox" {{  (old('terms_and_conditions') == 1 ? ' checked' : '') }} value="1">
               <span class="custom-control-label" id="terms_and_condition_color"> {{ __('J\'accepte les') }}</span> <a target="_blank" href="{{ route('page', 'terms-and-condition') }}">{{ __('termes et conditions') }}</a> <span class="text-danger">*</span>
               @if($errors->has('terms_and_conditions'))
                   <span class="invalid-feedback" role="alert">
                       <strong>{{ $errors->first('terms_and_conditions') }}</strong>
                   </span>
               @endif

           </label>
         </div>
         <button type="submit" class="btn btn-success rounded btn-lg btn-block">Créer un compte</button>
      </form>
      <!--
      <p class="text-muted text-center small py-2 m-0">ou</p>
      <a href="{{ route('login') }}" class="btn btn-success btn-lg rounded btn-block">J'ai déjà un compte</a><br>
      <a href="#" class="btn btn-fb btn-block rounded btn-lg btn-facebook"><i class="icofont-facebook mr-2"></i> Continuer avec Facebook</a><br>
      <a href="#" class="btn btn-dark btn-block rounded btn-lg btn-apple"><i class="icofont-brand-apple mr-2"></i> Continuer avec Apple</a>
      -->
   </div>
</div>
<!-- footer fixed -->
<img style="width:50px;display: block;margin-left: auto;margin-right: auto;" src="/images/logo2.png">
