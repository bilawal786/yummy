@if(!isset($check))
<!-- Footer Nav-->
<div id="snackbar">Ajouter aux favoris</div>
<div id="snackbar1">Déjà ajouté</div>
<div class="footer-nav-area" id="footerNav">
  <div class="container h-100 px-0">
    <div class="suha-footer-nav h-100">
      <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
        <li class="{{ (request()->is('/')) ? 'active' : '' }}"><a href="{{ route('home') }}"><i class="lni lni-home"></i>{{ __('message.découvrir') }}</a></li>
        <li class="{{ (request()->is('map')) ? 'active' : '' }}"><a href="{{ route('map') }}"><i class="lni lni-map-marker"></i> {{ __('message.carte') }}</a></li>
     <li class="{{ (request()->is('favourites')) ? 'active' : '' }}"><a href="{{route('favourites')}}"><i class="lni lni-heart"></i>{{ __('message.panier') }}</a></li>
        <li class="{{ (request()->is('account/order')) ? 'active' : '' }}"><a href="{{ route('account.order') }}"><i class="lni lni-package"></i> {{ __('message.réservations') }}Réservations</a></li>
{{--        <li class="{{ (request()->is('account/profile')) ? 'active' : '' }}"><a href="{{ route('account.profile') }}"><i class="lni lni-cog"></i>Profil</a></li>--}}
      </ul>
    </div>
  </div>
</div>
@endif
