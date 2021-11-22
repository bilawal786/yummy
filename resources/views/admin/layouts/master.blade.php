<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('admin.layouts.components.head')

<body>
    <div id="app">
        <div class="main-wrapper">
          @if (isset($errors) && count($errors))
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }} </li>
              @endforeach
            </ul>
          @endif
            @include('admin.layouts.components.navigation')
            @include('admin.layouts.components.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('main-content')
            </div>
            @include('admin.layouts.components.footer')
        </div>
    </div>
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6054f637067c2605c0ba5a42/1f15ukcel';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
    @include('admin.layouts.components.script')
</body>
</html>
