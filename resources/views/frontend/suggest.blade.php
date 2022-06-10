@extends('frontend.layouts.mobile')
@section('style')

@endsection
@section('main-content')
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{route('suggest.store')}}">
                        @csrf
                        <div class="row">
                            @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ __('message.succès!') }} </strong> {{ Session::get('message') }}
                                </div>
                            @endif
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">{{ __('message.tu') }} </label>
                                    <select required name="type" class="form-control" id="">
                                        <option value="Un utilisateur de l’application">{{ __('message.application') }} </option>
                                        <option value="Un représentant du commerce">{{ __('message.représentant') }} </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">{{ __('message.commerce') }} </label>
                                    <input required type="text" class="form-control" name="name">
                                </div>
                            </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="">{{ __('message.est') }} </label>
                                        <select required name="category" class="form-control" id="">
                                            <option value="Une épicerie">{{ __('message.épicerie') }} </option>
                                            <option value="Une boulangerie">{{ __('message.boulangerie') }} </option>
                                            <option value="Un traiteur">{{ __('message.traiteur') }} </option>
                                            <option value="Un restaurant">{{ __('message.restaurant') }} </option>
                                            <option value="Une boucherie">{{ __('message.boucherie') }} </option>
                                            <option value="Un primeur">{{ __('message.primeur') }}</option>
                                            <option value="Un supermarché">{{ __('message.supermarché') }} </option>
                                            <option value="Autres">{{ __('message.autres') }} </option>
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">{{ __('message.département') }} </label>
                                    <select required name="postal" class="form-control" id="">
                                        <option value="Guadeloupe">{{ __('message.guadeloupe') }} </option>
                                        <option value="Martinique">{{ __('message.martinique') }} </option>
                                        <option value="Guyane">{{ __('message.guyane') }} </option>
                                        <option value="La Réunion">{{ __('message.réunion') }} </option>
                                        <option value="Ile de France">{{ __('message.france') }} </option>
                                        <option value="Saint Martin">{{ __('message.saint') }} </option>
                                        <option value="Autres">{{ __('message.autres') }} </option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">{{ __('message.situe') }}</label>
                                    <input required type="text" class="form-control" name="address">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">{{ __('message.numéro') }}
                                    </label>
                                    <input  required type="text" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">{{ __('message.pour') }}
                                    </label>
                                    <input  required type="text" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <button type="submit" style="background-color: #f80368; color: white" class="btn btn-default">{{ __('message.envoyer') }} </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-js')

@endsection
