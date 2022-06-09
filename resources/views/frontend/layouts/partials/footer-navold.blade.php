@if(!isset($check))
<!-- Footer -->
<div class="osahan-menu-fotter fixed-bottom bg-white text-center border-top">
   <div class="row m-0">
      <a href="{{ route('home') }}" class="small col text-decoration-none p-2 {{ (request()->is('/')) ? 'selected text-dark' : 'text-muted' }}">
         <p class="h5 m-0"><i class="{{ (request()->is('/')) ? 'text-success' : '' }} icofont-compass"></i></p>
         {{ __('message.découvrir') }}
      </a>
      <a href="{{ route('map') }}" class="small col text-decoration-none p-2 {{ (request()->routeIs('map')) ? 'selected text-dark' : 'text-muted' }}">
         <p class="h5 m-0"><i class="{{ (request()->routeIs('map')) ? 'text-success' : '' }} icofont-map"></i></p>
         {{ __('message.carte') }}
      </a>
      <a href="{{ route('cart.index') }}" class="col small text-decoration-none p-2 {{ (request()->routeIs('cart.index')) ? 'selected text-dark' : 'text-muted' }}">
         <p class="h5 m-0"><i class="{{ (request()->routeIs('cart.index')) ? 'text-success' : '' }} icofont-cart"></i></p>
         {{ __('message.panier') }}
      </a>
      <a href="{{ route('account.order') }}" class="col small text-decoration-none p-2 {{ (request()->routeIs('account.order')) ? 'selected text-dark' : 'text-muted' }}">
         <p class="h5 m-0"><i class="{{ (request()->routeIs('account.order')) ? 'text-success' : '' }} icofont-papers"></i></p>
         {{ __('message.commande') }}
      </a>
      <a href="{{ route('account.profile') }}" class="small col text-decoration-none p-2 {{ (request()->routeIs('account.profile')) ? 'selected text-dark' : 'text-muted' }}">
         <p class="h5 m-0"><i class="{{ (request()->routeIs('account.profile')) ? 'text-success' : '' }} icofont-user"></i></p>
         {{ __('message.profil') }}
      </a>
   </div>
</div>
@endif
