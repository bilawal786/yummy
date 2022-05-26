<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard.index') }}"><img class="osahan-logo mr-2"
                                                                src="{{ asset("images/".setting('site_logo')) }}"
                                                                alt="logo" style="width: 200px;"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard.index') }}">
                <img class="osahan-logo mr-2" src="{{ asset("images/".setting('site_logo')) }}" alt="logo">
            </a>
        </div>
        @php
            $user = Auth::user();
        @endphp
        <ul class="sidebar-menu">
            <li class="active"><a class="nav-link " href="/admin/dashboard"><i
                            class="fas fa-laptop"></i> <span>Tableau de bord</span></a></li>
            @if( Auth::user()->hasRole('Admin') )
                <li class="nav-item dropdown "><a class="nav-link has-dropdown" href="/admin/#"><i
                                class="fas fa-life-ring"></i> <span>Paramètre</span></a>
                    <ul class="dropdown-menu">
                        <li class=""><a class="nav-link " href="{{route('admin.salesPerson.dashboard')}}"><i
                                        class="fas fa-flag"></i> <span>Texte ajouter</span></a></li>
                        <li class=""><a class="nav-link " href="{{route('admin.salesPerson.status')}}"><i
                                        class="fas fa-flag"></i> <span>Ajouter un statut</span></a></li>


{{--                        <li class=""><a class="nav-link " href="{{route('admin.salesPerson.scale')}}"><i--}}
{{--                                        class="fas fa-flag"></i> <span>Ajouter un Bareme</span></a></li>--}}
                    </ul>
                </li>

                @if($user->p1 == 1)
                    <li class="nav-item dropdown "><a class="nav-link has-dropdown" href="/admin/#"><i
                                    class="fas fa-life-ring"></i> <span>Localisation</span></a>
                        <ul class="dropdown-menu">
                            <li class=""><a class="nav-link " href="/admin/location"><i
                                            class="fas fa-flag"></i> <span>Région</span></a></li>
                        </ul>
                    </li>
                @endif

                <li class=""><a class="nav-link " href="{{route('admin.document.index.admin')}}"><i class="fas fa-list-ul"></i>
                        <span>Document</span></a></li>

                @if($user->p2 == 1)
                    <li class=""><a class="nav-link " href="/admin/category"><i class="fas fa-list-ul"></i>
                            <span>Catégories</span></a></li>
                @endif
            @endif
            @if($user->p3 == 1)
                <li class=""><a class="nav-link " href="/admin/products"><i class="fas fa-gift"></i>
                        <span>Paniers</span></a></li>
            @endif
            @if($user->p4 == 1)
                <li class=""><a class="nav-link " href="/admin/shop"><i class="fas fa-university"></i>
                        <span>Boutique</span></a></li>
            @endif
            @if($user->p5 == 1)
                <li class=""><a class="nav-link " href="/admin/orders"><i class="fas fa-cart-plus"></i>
                        <span>Commandes</span></a></li>
            @endif
            @if( Auth::user()->hasRole('Admin') )
                @if($user->p6 == 1)
                    <li class="nav-item dropdown "><a class="nav-link has-dropdown" href="/admin/#"><i
                                    class="fas fa-id-card "></i> <span>Utilisateurs</span></a>
                        <ul class="dropdown-menu">
                            <li class=""><a class="nav-link " href="/admin/administrators"><i
                                            class="fas fa-users"></i> <span>Administrateurs</span></a></li>
                            <li class=""><a class="nav-link " href="/admin/customers"><i
                                            class="fas fa-user-secret"></i> <span>Clients</span></a></li>
                            <br>
                            <li class=""><a class="nav-link " href="{{route('admin.shop.admins')}}"><i
                                            class="fas fa-university"></i>
                                    <span>Administrateurs de la boutique</span></a>
                            </li>
                            <br>
                            <li class=""><a class="nav-link " href="{{route('admin.sales.person')}}"><i
                                            class="fas fa-university"></i>
                                    <span>Vendeurs</span></a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if($user->p7 == 1)
                    <li class=""><a class="nav-link " href="/admin/banner"><i class="fas fa-film"></i>
                            <span>Bannières</span></a></li>
                @endif
                @if($user->p8 == 1)
                    <li class=""><a class="nav-link " href="/admin/yummycoin"><i class="fas fa-coins"></i>
                            <span>YummyCoin</span></a></li>
                @endif
            @endif
            <?php
            $role = Spatie\Permission\Models\Role::find(3);

            ?>

            @if( Auth::user()->hasRole('Shop Owner') )
                <li class=""><a class="nav-link " href="{{route('admin.vendor.bank')}}"><i class="fas fa-bars"></i>
                        <span>
                    Coordonnées bancaires
                    </span></a></li>
                <li class=""><a class="nav-link " href="{{url('/stripe')}}"><i class="fas fa-bars"></i>
                        <span>
                    Connecter Stripe
                    </span></a></li>
                <li class=""><a class="nav-link " href="{{route('admin.vendor.send.notifications')}}"><i
                                class="fas fa-address-card"></i> <span>
                    Envoyer des notifications aux clients
                    </span></a></li>
            @endif
            @if( Auth::user()->hasRole('Admin') )
                @if($user->p9 == 1)
                    <li class=""><a class="nav-link " href="{{route('admin.admin.bank')}}"><i class="fas fa-bars"></i>
                            <span>
                    Coordonnées bancaires
                    </span></a></li>
                @endif
                <li class=""><a class="nav-link " href="{{route('admin.souscategorie.index')}}"><i
                                class="fas fa-calendar"></i> <span>
                    Catégorie Premium
                    </span></a></li>
                <li class=""><a class="nav-link " href="{{route('admin.suggestions')}}"><i
                                class="fas fa-balance-scale"></i> <span>
                    Suggérer un commerce
                    </span></a></li>
                @if($user->p10 == 1)
                    <li class=""><a class="nav-link " href="{{route('admin.send.notifications')}}"><i
                                    class="fas fa-address-card"></i> <span>
                    Envoyer des notifications aux clients
                    </span></a></li>
                @endif
            @endif

            @if( Auth::user()->hasRole('Shop Admin') )
                <li class=""><a class="nav-link " href="{{route('admin.shopadmin.products')}}"><i
                                class="fas fa-gift"></i> <span>Paniers</span></a>
                </li>
            @endif

            @if( Auth::user()->hasRole('Sales Person') )
                <li class=""><a class="nav-link " href="{{route('admin.document.index')}}"><i class="fas fa-list-ul"></i>
                        <span>Document</span></a></li>
                <li class=""><a class="nav-link " href="{{route('admin.salesperson.vendors')}}"><i
                                class="fas fa-gift"></i> <span>Mes commerçants</span></a>
                </li>
                <li class=""><a class="nav-link " href="{{route('admin.salesPerson.demo')}}"><i
                                class="fas fa-gift"></i> <span>Demo</span></a>
                </li>
                <li class=""><a class="nav-link " href="{{route('admin.salesPerson.account')}}"><i
                                class="fas fa-gift"></i> <span>Mon compte</span></a>
                </li>
            @endif


            <li class=""><a class="nav-link " href="{{route('home')}}"><i class="fas fa-mobile"></i> <span>Retour à l'application</span></a>
            </li>
        </ul>
    </aside>
</div>
