@extends('frontend.layouts.default')
@section('frontend.content')
    <article class="card mb-3">
        <div class="card-body">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                </div>
            @endif

            <figure class="icontext">
                <div class="icon">
                    <img width="100px" height="100px" class="rounded-circle img-sm border" src="{{ $user->images }}">
                </div>
                <div class="text">
                    <strong> {{ __('message.name') }} : {{ $user->name}} </strong> <br>
                    <strong> {{ __('message.Credit') }} : {{ currencyFormat($user->balance->balance) }} </strong> <br>
                </div>
            </figure>
            <hr>
            <div class="col-sm-6">
                <dl class="row">
                    <dt class="col-sm-3">{{ __('message.username') }}</dt>
                    <dd class="col-sm-9">{{ $user->username }}</dd>

                    <dt class="col-sm-3">{{ __('message.email') }}</dt>
                    <dd class="col-sm-9">{{ $user->email }}</dd>

                    <dt class="col-sm-3">{{ __('message.phone') }}</dt>
                    <dd class="col-sm-9">{{ $user->phone }}</dd>

                    <dt class="col-sm-3">{{ __('message.address') }}</dt>
                    <dd class="col-sm-9">{{ $user->address }}</dd>
                </dl>
            </div>
        </div> <!-- card-body .// -->
    </article> <!-- card.// -->
@endsection
