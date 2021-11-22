<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" >
      <meta name="apple-mobile-web-app-capable" content="yes">
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
   <body class="fixed-bottom-padding">
      <!-- sign in -->
      <div class="osahan-signin">
         <div class="border-head p-5 d-flex align-items-center">
           <h2 class="my-head">Bienvenue</h2>
         </div>
         <div class="p-5" style="padding-top: 20px !important;padding-bottom: 20px !important;">
            <p class="small">Connectez-vous pour continuer.</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
               <div class="form-group">
                  <label for="demoemail">Email</label>
                  <input type="email" class="form-control" id="demoemail" type="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Email" aria-describedby="emailHelp">
                  @if($errors->has('email'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @elseif(session('block'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ session('block') }}</strong>
                      </span>
                  @endif
               </div>
               <div class="form-group">
                  <label for="demopassword">Mot de passe</label>
                  <input placeholder="********" id="demopassword" type="password" class="form-control @if($errors->has('password')) is-invalid @endif"
                         name="password" autocomplete="current-password">
                         @if($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('password') }}</strong>
                            </span>
                         @endif
               </div>
               <button type="submit" class="btn btn-success btn-lg rounded btn-block">Connexion</button>
               <br>                    @if (Route::has('password.request'))
                                          <a class="text-gray" href="{{ route('forget.password.get') }}">
                                             Mot de passe oublié?
                                          </a>
                                       @endif
            </form>
            <br>
            <a href="{{ route('facebook.login') }}" class="btn btn-fb btn-block rounded btn-lg btn-facebook">
               <i class="fab fa-facebook mr-2"></i> Continuer avec Facebook
               </a>

              <!--<br>
            <a href="#" class="btn btn-dark btn-block rounded btn-lg btn-apple">
            <i class="fab fa-apple mr-2"></i> Continuer avec Apple
          </a>-->
            <p class="text-muted text-center small m-0 py-3">ou</p>
            <a href="{{ route('register') }}" class="btn btn-success btn-lg rounded btn-block">
            Créer un compte
            </a>
         </div>
      </div>
      <!-- footer fixed -->
      <img style="width:50px;display: block;margin-left: auto;margin-right: auto;" src="/images/logo2.png">
      <!-- Bootstrap core JavaScript -->
      <script src="app/vendor/jquery/jquery.min.js"></script>
      <script src="app/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- slick Slider JS-->
      <script type="text/javascript" src="app/vendor/slick/slick.min.js"></script>
      <!-- Sidebar JS-->
      <script type="text/javascript" src="app/vendor/sidebar/hc-offcanvas-nav.js"></script>
      <!-- Custom scripts for all pages-->
      <script src="app/js/osahan.js"></script>
   </body>
</html>
