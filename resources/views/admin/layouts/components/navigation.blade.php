<style>
    .active{
       background-color: green!important;
    }

     .i3 {
        margin: 10px;
        font-size: 20px;
        color: green;
    }
</style>

    <div class="navbar-bg {{ env('APP_URL') == 'https://demo.yummybox.fr/'? 'active':'' }}" ></div>

<nav class="navbar navbar-expand-lg main-navbar">
    <div class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @if( Auth::user()->hasRole('Sales Person') )
                        <?php  $user = Auth::user();
                               $rank = \App\Rank::where('id','=',$user->rank_id)->first();
                        ?>
                    <b style="font-size: 18px;">Statue</b> <i class="fa fa-star " style="color: {{$rank->color ?? red}}" aria-hidden="true"></i>
                    @endif
                </a></li>
        </ul>
    </div>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown">
            <a href="{{ route('admin.profile') }}" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ auth()->user()->images }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{ __('Coucou') }}, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ __('Profil') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> {{ __('Déconnexion') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="display-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
