<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard.index') }}"><img class="osahan-logo mr-2" src="{{ asset("images/".setting('site_logo')) }}" alt="logo" style="width: 200px;"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard.index') }}">
              <img class="osahan-logo mr-2" src="{{ asset("images/".setting('site_logo')) }}" alt="logo">
            </a>
        </div>

        <ul class="sidebar-menu">
            {!! $backendMenus !!}

            <?php
            $role =  Spatie\Permission\Models\Role::find(3);

            ?>
            @if( Auth::user()->hasRole('Shop Owner') )
            <li class=""><a class="nav-link " href="{{route('admin.vendor.bank')}}" ><i class="fas fa-bars"></i> <span>
Coordonnées bancaires
</span></a></li>
            @endif
            @if( Auth::user()->hasRole('Admin') )
            <li class=""><a class="nav-link " href="{{route('admin.admin.bank')}}" ><i class="fas fa-bars"></i> <span>
Coordonnées bancaires
</span></a></li>
                <li class=""><a class="nav-link " href="{{route('admin.souscategorie.index')}}" ><i class="fas fa-calendar"></i> <span>
Catégorie Premium
</span></a></li>
                <li class=""><a class="nav-link " href="{{route('admin.suggestions')}}" ><i class="fas fa-balance-scale"></i> <span>
Suggérer un commerce
</span></a></li>
                <li class=""><a class="nav-link " href="{{route('admin.send.notifications')}}" ><i class="fas fa-address-card"></i> <span>
Envoyer des notifications aux clients
</span></a></li>
            @endif
            <li class=""><a class="nav-link " href="{{route('home')}}" ><i class="fas fa-mobile"></i> <span>Retour à l'application</span></a></li>
        </ul>
    </aside>
</div>
