<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" >
    <meta name="apple-mobile-web-app-capable" content="yes" >
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#100DD1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <title>YummyBox</title>
      <link rel="preconnect" href="https://fonts.gstatic.com">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap">
      <!-- Favicon-->
      <link rel="icon" href="{{ asset('Yummy-box-picto.png') }}">
      <!-- Apple Touch Icon-->
      <link rel="apple-touch-icon" href="{{ asset('android/android-launchericon-96-96.png') }}">
      <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('android/android-launchericon-192-192.png') }}">
      <!-- CSS Libraries-->
      <link rel="stylesheet" href="{{ asset('v2/css/bootstrap.min.css')}}">
      <link rel="stylesheet" href="{{ asset('v2/css/animate.css')}}">
      <link rel="stylesheet" href="{{ asset('v2/css/owl.carousel.min.css')}}">
      <link rel="stylesheet" href="{{ asset('v2/css/font-awesome.min.css') }}">
      <link rel="stylesheet" href="{{ asset('v2/css/default/lineicons.min.css')}}">

      <!-- Stylesheet-->
      <link rel="stylesheet" href="{{ asset('style.css') }}">
      <!-- Web App Manifest-->
      @laravelPWA
      @stack('extra-style')
      <style>
          .lni {
              display: inline-block;
              font: normal normal normal 1.5em/1.5 'LineIcons';
              speak: none;
              text-transform: none;
              -webkit-font-smoothing: antialiased;
              -moz-osx-font-smoothing: grayscale;
          }
          /*snackbar*/
          #snackbar {
              visibility: hidden;
              min-width: 250px;
              margin-left: -125px;
              background-color: #ee4d9b;
              color: #fff;
              text-align: center;
              border-radius: 2px;
              padding: 5px;
              position: fixed;
              z-index: 1;
              left: 50%;
              bottom: 60px;
              font-size: 17px;
          }

          #snackbar.show {
              visibility: visible;
              -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
              animation: fadein 0.5s, fadeout 0.5s 2.5s;
          }
          #snackbar1 {
              visibility: hidden;
              min-width: 250px;
              margin-left: -125px;
              background-color: #ee4d9b;
              color: #fff;
              text-align: center;
              border-radius: 2px;
              padding: 5px;
              position: fixed;
              z-index: 1;
              left: 50%;
              bottom: 60px;
              font-size: 17px;
          }

          #snackbar1.show {
              visibility: visible;
              -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
              animation: fadein 0.5s, fadeout 0.5s 2.5s;
          }
          @-webkit-keyframes fadein {
              from {bottom: 0; opacity: 0;}
              to {bottom: 30px; opacity: 1;}
          }

          @keyframes fadein {
              from {bottom: 0; opacity: 0;}
              to {bottom: 30px; opacity: 1;}
          }

          @-webkit-keyframes fadeout {
              from {bottom: 30px; opacity: 1;}
              to {bottom: 0; opacity: 0;}
          }

          @keyframes fadeout {
              from {bottom: 30px; opacity: 1;}
              to {bottom: 0; opacity: 0;}
          }
          /*endsnackbar*/
          .weekly-product-card .product-thumbnail-side .wishlist-btn1 {
              position: absolute;
              bottom: 0.5rem;
              color: #ea4c62;
              line-height: 1;
              z-index: 11;
              font-size: 1.25rem;
          }
          .page-item.active .page-link {
              z-index: 3;
              color: #fff;
              background-color: #ea4c62;
              border-color: #ea4c62;
          }
      </style>
      @yield('style')

   </head>
   <body>
<?php
$location = \App\Models\Location::all();
$user = Auth::user();
?>
     <!-- Preloader-->
<!--     <div class="preloader" id="preloader">
       <div class="spinner-grow text-secondary" role="status">
         <div class="sr-only">Chargement...</div>
       </div>
     </div>-->
     <!-- Header Area-->
     <div class="header-area" id="headerArea">
       <div class="container h-100 d-flex align-items-center justify-content-between">
         @if(Route::current()->getName() == 'home' or Route::current()->getName() == 'search')
         <!-- Logo Wrapper-->
         <div class="logo-wrapper"><a href="{{route('home')}}"><img src="{{ asset('Yummy-box-picto.png') }}" alt="" style="width: 40px;"></a></div>
         <!-- Search Form-->
         <div class="top-search-form">
           <form action="{{route('search')}}" method="GET">
             <input class="form-control" type="search" name="name" value="{{request()->query('name')}}" placeholder="{{ __('message.enterserch') }}">
             <button type="submit" ><i class="fa fa-search"></i></button>
           </form>
         </div>
         @else
         <div class="back-button"><a onclick="window.history.back()">
            <svg class="bi bi-arrow-left" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"></path>
            </svg></a>
          </div>
         <div class="page-heading">
          <h6 class="mb-0">{{$namepage ?? ''}}</h6>
        </div>
        @endif
         <!-- Navbar Toggler-->
         <div class="suha-navbar-toggler d-flex flex-wrap" id="suhaNavbarToggler"><i class="lni lni-user"></i></div>
       </div>
     </div>
     <!-- Sidenav Black Overlay-->
     <div class="sidenav-black-overlay"></div>
     <!-- Side Nav Wrapper-->
     <div class="suha-sidenav-wrapper" id="sidenavWrapper">
       <!-- Sidenav Profile-->
       <div class="sidenav-profile">
         <div class="user-info">
           <div class="user-profile"><img width="100px" height="100px" src="{{ $user->images??'https://media.istockphoto.com/vectors/user-icon-flat-isolated-on-white-background-user-symbol-vector-vector-id1300845620?k=20&m=1300845620&s=612x612&w=0&h=f4XTZDAv7NPuZbG0habSpU0sNgECM0X7nbKzTUta3n8=' }}"></div>
           <h6 class="user-name mb-0">{{ $user->name??'Guest User'}}</h6>
           <p class="available-balance"><span><span class="counter"> {{ $user->balance->balance??'0' }}</span> {{ __('message.yummycoin') }}</span></p>
         </div>
       </div>
       <!-- Sidenav Nav-->
       <ul class="sidenav-nav ps-0">
           @auth
        @if($user->myrole == 1 || $user->myrole == 3 || $user->myrole == 5|| $user->myrole == 6) <li><a href="{{ route('admin') }}"><i class="lni lni-briefcase"></i>{{ __('message.accès') }} </a></li> @endif
           @endauth
            <li><a href="{{ route('account.profile') }}"><i class="lni lni-user"></i>{{ __('message.myprofile') }}</a></li>
         <li><a href="{{ route('notifications') }}"><i class="lni lni-bullhorn"></i>{{ __('message.notfi') }}</a></li>
         <li><a href="{{ route('traders') }}"><i class="lni lni-surf-board"></i>{{ __('message.order') }}</a></li>
         <li><a href="{{ route('yummycoin') }}"><i class="lni lni-wallet lni-tada-effect"></i>{{ __('message.recharge') }}</a></li>
         <li><a href="{{ route('faq') }}"><i class="lni lni-book lni-tada-effect"></i>{{ __('message.center') }}</a></li>
         <li><a href="{{ route('suggest.business') }}"><i class="lni lni-bar-chart lni-tada-effect"></i>
                 {{ __('message.sug') }}
             </a></li>
         <li><a href="{{ route('sponsership') }}"><i class="lni lni-calendar lni-tada-effect"></i>{{ __('message.pari') }}</a></li>
            <li>
                <select onchange="location = this.value;" style="height: 30px" class="form-control" name="" id="">
                    @foreach($location as $loc)
                        <option {{$user->address??1 == $loc->id ? 'selected' : ''}} value="{{route('change.location', ['id' => $loc->id])}}">{{$loc->name}}</option>
                    @endforeach
                </select>
            </li>
         <li><a href="{{ route('logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form-sidebar').submit();"><i class="lni lni-power-switch"></i>{{ __('message.logout') }}</a>
           <form class="d-none" id="logout-form-sidebar" action="{{ route('logout') }}" method="POST">
               {{ csrf_field() }}
           </form></li>
       </ul>
       <!-- Go Back Button-->
       <div class="go-home-btn" id="goHomeBtn"><i class="lni lni-arrow-left"></i></div>
     </div>

     @include('frontend.layouts.partials.flash')
      <!-- home page -->
      @yield('main-content')
      <!-- Internet Connection Status-->
      <div class="internet-connection-status" id="internetStatus"></div>
      @include('frontend.layouts.partials.footer-nav')
      <!-- All JavaScript Files-->
      <script src="{{ asset('v2/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('v2/js/jquery.min.js') }}"></script>
      <script src="{{ asset('v2/js/waypoints.min.js') }}"></script>
      <script src="{{ asset('v2/js/jquery.easing.min.js') }}"></script>
      <script src="{{ asset('v2/js/owl.carousel.min.js') }}"></script>
      <!--<script src="{{ asset('v2/js/jquery.counterup.min.js') }}"></script>
      <script src="{{ asset('v2/js/jquery.countdown.min.js') }}"></script>-->
      <script src="{{ asset('v2/js/default/jquery.passwordstrength.js') }}"></script>
      <!--<script src="{{ asset('v2/js/default/dark-mode-switch.js') }}"></script>-->
      <script src="{{ asset('v2/js/default/no-internet.js') }}"></script>
      <script src="{{ asset('v2/js/default/active.js') }}"></script>
      @yield('footer-js')
     <script type="text/javascript">
         function addtofav(elem){
             let id = $(elem).attr("id");
             let c_id = $(elem).attr("c_id");
             let _token   = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                 url: "{{route('addtowishlist')}}",
                 type:"POST",
                 data:{
                     id:id,
                     c_id:c_id,
                     _token: _token
                 },
                 success:function(response){
                     if(response.success === "Successfully Added") {
                         $(".like").hide();
                         $(".temporary").show();
                         var fav_count = $(".fav_count").html();
                         $(".fav_count").html(+fav_count + +1);
                         var x = document.getElementById("snackbar");
                         x.className = "show";
                         setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                     }else {
                         var x = document.getElementById("snackbar1");
                         x.className = "show";
                         setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                     }
                 },
             });
         }
         function addtofavtrader(elem){
             let id = $(elem).attr("id");
             let c_id = $(elem).attr("c_id");
             let _token   = $('meta[name="csrf-token"]').attr('content');
             $.ajax({
                 url: "{{route('addtowishlist')}}",
                 type:"POST",
                 data:{
                     id:id,
                     c_id:c_id,
                     _token: _token
                 },
                 success:function(response){
                     if(response.success === "Successfully Added") {
                         $(".like"+id).hide();
                         $(".temporary"+id).show();
                         var fav_count = $(".fav_count").html();
                         $(".fav_count").html(+fav_count + +1);
                         var x = document.getElementById("snackbar");
                         x.className = "show";
                         setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                     }else {
                         var x = document.getElementById("snackbar1");
                         x.className = "show";
                         setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                     }
                 },
             });
         }
     </script>
{{--<script>--}}
{{--    function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {--}}
{{--        var R = 6371; // Radius of the earth in km--}}
{{--        var dLat = deg2rad(lat2-lat1);  // deg2rad below--}}
{{--        var dLon = deg2rad(lon2-lon1);--}}
{{--        var a =--}}
{{--            Math.sin(dLat/2) * Math.sin(dLat/2) +--}}
{{--            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *--}}
{{--            Math.sin(dLon/2) * Math.sin(dLon/2)--}}
{{--        ;--}}
{{--        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));--}}
{{--        var d = R * c; // Distance in km--}}
{{--        // return d;--}}
{{--        alert(d);--}}
{{--    }--}}

{{--    function deg2rad(deg) {--}}
{{--        return deg * (Math.PI/180)--}}
{{--    }--}}
{{--    getDistanceFromLatLonInKm(31.431160, 74.264343, 31.569123, 74.387895);--}}
{{--</script>--}}
   </body>
</html>
