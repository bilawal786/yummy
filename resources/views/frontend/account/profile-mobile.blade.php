@extends('frontend.layouts.mobile')

@section('main-content')
<div class="page-content-wrapper py-3">
      <div class="container">
        <div class="p-4 profile text-center border-tab">
           <img width="90px" height="90px" src="{{ $user->images }}" class="img-fluid rounded-pill">
           <h6 class="font-weight-bold m-0 mt-2">{{ $user->name}}</h6>
           <p class="small text-muted">{{ __('message.il') }} <span class="counter"> {{ $user->balance->balance }}</span> {{ __('YummyCoin') }}</p>
            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ __('message.succès!') }} </strong> {{ Session::get('message') }}
                </div>
            @endif
           <a href="{{ route('account.profile.index') }}" class="btn btn-success btn-sm"><i class="icofont-pencil-alt-5"></i>{{ __('message.editer') }} </a>
        </div>
        <ul class="page-nav ps-0">
          <li><a href="{{ route('account.order') }}">{{ __('message.mes') }} <i class="lni lni-chevron-right"></i></a></li>
          <li><a href="{{ route('yummycoin') }}">{{ __('message.recharger') }} <i class="lni lni-chevron-right"></i></a></li>
          <li><a href="/page/conditions-generales-dutilisation">{{ __('message.conditions') }}<i class="lni lni-chevron-right"></i></a></li>
          <li><a href="{{ route('how-it-works') }}">{{ __('message.comment') }}<i class="lni lni-chevron-right"></i></a></li>
        </ul>
      </div>
    </div>
@endsection
