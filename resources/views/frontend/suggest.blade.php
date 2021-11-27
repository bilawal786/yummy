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
                                    <strong>Succès! </strong> {{ Session::get('message') }}
                                </div>
                            @endif
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">Es-tu?</label>
                                    <select required name="type" class="form-control" id="">
                                        <option value="Un utilisateur de l’application">Un utilisateur de l’application</option>
                                        <option value="Un représentant du commerce">Un représentant du commerce</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">Quel est le nom du commerce?</label>
                                    <input required type="text" class="form-control" name="name">
                                </div>
                            </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="">Est-ce?</label>
                                        <select required name="category" class="form-control" id="">
                                            <option value="Une épicerie">Une épicerie</option>
                                            <option value="Une boulangerie">Une boulangerie</option>
                                            <option value="Un traiteur">Un traiteur</option>
                                            <option value="Un restaurant">Un restaurant</option>
                                            <option value="Une boucherie">Une boucherie</option>
                                            <option value="Un primeur">Un primeur</option>
                                            <option value="Un supermarché">Un supermarché</option>
                                            <option value="Autres">Autres</option>
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">Dans quel département se trouve t-il?</label>
                                    <select required name="postal" class="form-control" id="">
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Guyane">Guyane</option>
                                        <option value="La Réunion">La Réunion</option>
                                        <option value="Ile de France">Ile de France</option>
                                        <option value="Saint Martin">Saint Martin</option>
                                        <option value="Autres">Autres</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">À quelle adresse se situe le commerce?</label>
                                    <input required type="text" class="form-control" name="address">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">Quel est le numéro de téléphone du commerce?
                                    </label>
                                    <input  required type="text" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">Il y a t-il un e-mail pour contacter un représentant?
                                    </label>
                                    <input  required type="text" class="form-control" name="email">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <button type="submit" style="background-color: #f80368; color: white" class="btn btn-default">Envoyer</button>
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
