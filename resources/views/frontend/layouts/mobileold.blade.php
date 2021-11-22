<!DOCTYPE html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <meta meta name="viewport" content="width=device-width, user-scalable=no" />
      @laravelPWA
      <title>YummyBox</title>
      <!-- Slick Slider -->
      <link rel="stylesheet" type="text/css" href="{{ asset('app/vendor/slick/slick.min.css') }}"/>
      <link rel="stylesheet" type="text/css" href="{{ asset('app/vendor/slick/slick-theme.min.css') }}"/>
      <!-- Icofont Icon-->
      <link href="{{ asset('app/vendor/icons/icofont.min.css') }}" rel="stylesheet" type="text/css">
      <!-- Bootstrap core CSS -->
      <link href="{{ asset('app/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
      <!-- Custom styles for this template -->
      <link href="{{ asset('app/css/style.css') }}" rel="stylesheet">
      <!-- Sidebar CSS -->
      <link href="{{ asset('app/vendor/sidebar/demo.css') }}" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
      @stack('extra-style')
      @yield('style')

   </head>
   <body class="fixed-bottom-padding js-Pjax">
     @include('frontend.layouts.partials.flash')
      <!-- home page -->
      @yield('main-content')
      @include('frontend.layouts.partials.footer-nav')
      <script src="{{ asset('routes.js') }}"></script>
      <!-- Bootstrap core JavaScript -->
      <script src="{{ asset('app/vendor/jquery/jquery.min.js') }}"></script>
      <script src="https://cdn.jsdelivr.net/gh/arvgta/ajaxify@8.1.5/ajaxify.min.js"></script>
      <script>/*#('.js-Pjax').ajaxify();*/</script>
      <script src="{{ asset('app/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <!-- slick Slider JS-->
      <script type="text/javascript" src="{{ asset('app/vendor/slick/slick.min.js') }}"></script>
      <!-- Sidebar JS-->
      <script type="text/javascript" src="{{ asset('app/vendor/sidebar/hc-offcanvas-nav.js') }}"></script>
      <!-- Custom scripts for all pages-->
      <script src="{{ asset('app/js/osahan.js') }}"></script>
      @yield('footer-js')
   </body>
</html>
