@if(!isset($check))
<!-- Footer Nav-->
<div class="footer-nav-area" id="footerNav">
  <div class="container h-100 px-0">
    <div class="suha-footer-nav h-100">
      <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
        <li class="{{ (request()->is('/')) ? 'active' : '' }}"><a href="{{ route('home') }}"><i class="lni lni-home"></i>Découvrir</a></li>
        <li class="{{ (request()->is('map')) ? 'active' : '' }}"><a href="{{ route('map') }}"><i class="lni lni-map-marker"></i>Carte</a></li>
        <!--<li class="{{ (request()->is('cart.index')) ? 'active' : '' }}"><a href="{{ route('cart.index') }}"><i class="lni lni-shopping-basket"></i>Panier</a></li>-->
        <li class="{{ (request()->is('account/order')) ? 'active' : '' }}"><a href="{{ route('account.order') }}"><i class="lni lni-package"></i>Réservations</a></li>
        <li class="{{ (request()->is('account/profile')) ? 'active' : '' }}"><a href="{{ route('account.profile') }}"><i class="lni lni-cog"></i>Profil</a></li>
      </ul>
    </div>
  </div>
</div>
@endif
