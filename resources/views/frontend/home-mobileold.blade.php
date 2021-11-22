@extends('frontend.layouts.mobile')
@section('main-content')

<!-- home page -->
<div class="osahan-home-page">
   <div class="border-bottom p-3">
      <div class="title d-flex align-items-center">
         <a href="{{ route('home') }}" class="text-decoration-none text-white d-flex align-items-center">
             <img class="osahan-logo mr-2" src="{{ asset("images/".setting('site_logo')) }}" alt="logo">
         </a>
               <a href="{{ route('yummycoin') }}" class="text-decoration-none text-white d-flex align-items-center"><img src="" width="10px">Découvre nos YummyCoin</a>
         <!--<p class="ml-auto m-0">
            <a href="#" class="text-decoration-none bg-white p-1 rounded shadow-sm d-flex align-items-center">
            <i class="text-dark icofont-notification"></i>
            <span class="badge badge-danger p-1 ml-1 small">0</span>
            </a>
         </p>-->
      </div>
      <!--<a href="search.html" class="text-decoration-none">
         <div class="input-group mt-3 rounded shadow-sm overflow-hidden bg-white">
            <div class="input-group-prepend">
               <button class="border-0 btn btn-outline-secondary text-success bg-white"><i class="icofont-search"></i></button>
            </div>
            <input type="text" class="shadow-none border-0 form-control pl-0" placeholder="Chercher" aria-label="" aria-describedby="basic-addon1">
         </div>
      </a>-->
   </div>
   <!-- body -->
   <div class="container osahan-body">
     <!-- Promos -->
     <div class="osahan-promos">
        <div class="promo-slider">
          @foreach($banners as $banner)
           <div class="osahan-slider-item">
              <a href="{{ $banner->link ? url('/boutique/'.$banner->link) : '#' }}"><img src="{{ $banner->images }}" class="img-fluid mx-auto"></a>
           </div>
           @endforeach
        </div>
     </div>

      <!-- categories -->
      <div class="osahan-categories py-3">
        <div class="py-2 title d-flex align-items-center">
        <h6 class="m-0">Meilleures catégories</h6>
      </div>
          <div class="category-slider">
          @foreach($cat as $value)
            <div class="col p-1">
              <div class="text-center bg-white shadow-sm rounded text-center px-2 py-3 c-it">
                <a href="{{ route('categories', $value->slug) }}">
                  @if($value->getFirstMediaUrl('categories'))
                  <img alt="image" src="{{ asset($value->getFirstMediaUrl('categories')) }}" class="img-fluid px-2">
                  @else
                  <img alt="image" src="{{ asset('assets/img/default/category.png') }}" class="img-fluid px-2">
                  @endif
                  @php $qty = 0 @endphp
                  <a href="#" style="font-size: 10px;position: absolute;top: 20px;left: 75px;" class="btn btn-dark btn-sm ml-auto rounded-qty">
                    @foreach($value->products as $pdt)
                    @foreach($value->products as $qt) @foreach($qt->shopproduct2 as $shopp) @php $qty = $shopp->sum('quantity'); @endphp @endforeach @endforeach @endforeach
                    {{$qty}}</a>
                    <p class="m-0 pt-2 text-darkness text-center">{{ $value->name }}</p>
                  </a>
                </div>
              </div>
          @endforeach
        </div>
        @if(!blank($proxim))
          <div class="py-2 title d-flex align-items-center">
            <h6 class="m-0">Les plus populaires à proximité</h6>
          </div>
          <div class="osahan-slider">
            @foreach($proxim as $proximite)
            @php
            $mytime = Carbon\Carbon::now();
            $heure = $mytime->format('H:i:s');
            $shopProduct = App\Models\ShopProduct::where(['shop_id' => $proximite->id])->where('quantity', '>', 0)->where('hdispoa', '<=', $heure)->where('hdispob', '>=', $heure)->with('product')->get();
            $qty = 0;
            @endphp
               <div class="osahan-slider-item m-2">
                  <div class="col-12">
                     <a href="{{ route('shop.show', $proximite->slug) }}" class="text-dark text-decoration-none">
                        <div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm">
                           <div class="rounded">
                             @foreach($shopProduct as $shops) @php $qty = $shops->quantity; @endphp @endforeach
                                  @if($qty != 0)
                                    @if($qty > 5)
                                      <div class="member-plan position-absolute"><span class="badge m-3 badge-rose">5+ à sauver</span></div>
                                    @else
                                      <div class="member-plan position-absolute"><span class="badge m-3 badge-danger">Seulement {{ $qty }} à sauver</span></div>
                                    @endif
                                  @else
                                    <div class="member-plan position-absolute"><span class="badge m-3 badge-grey">Rien à sauver</span></div>
                                  @endif
                             <img src="{{ $proximite->images }}" class="img-fluid mx-auto shadow-sm">
                             <div class="star position-absolute bg-white h-100 rounded" style="left: 20px;bottom: -85px;">
                               <div class="btn btn-sm ml-auto"><img src="{{ asset($proximite->getFirstMediaUrl('shops_logo')) }}" style="width: 40px;margin-top: 5px;"></div>
                             </div>
                           </div>
                           <div class="p-3 position-relative">
                              <h6 class="mb-1 font-weight-bold">{{ $proximite->name }}</h6>
                            </div>
                          </div>
                     </a>
                  </div>
               </div>
           @endforeach
          </div>
         @endif
      </div>
      </div>
   </div>
</div>
@endsection
