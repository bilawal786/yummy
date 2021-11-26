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
                                    <label for="">Quel est le nom de votre enseigne?</label>
                                    <input required type="text" class="form-control" name="name">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">Quel est votre numéro de téléphone?</label>
                                    <input required type="text" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">Quelle est votre type activite?</label>
                                    <select required name="type" class="form-control" id="">
                                        <option value="Epicerie/Super Marché">Epicerie/Super Marché</option>
                                        <option value="Boulangerie/Patisserie">Boulangerie/Patisserie</option>
                                        <option value="Restaurant/Traiteur">Restaurant/Traiteur</option>
                                        <option value="Boucherie">Boucherie</option>
                                        <option value="Primeur">Primeur</option>
                                        <option value="Agriculteur">Agriculteur</option>
                                        <option value="Autres">Autres</option>
                                        <option value="2 sur 4 répondus">2 sur 4 répondus</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">Quel est votre code postal?</label>
                                    <input required type="text" class="form-control" name="postal">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="">A quelle adresse mail pouvons nous vous contacter?
                                    </label>
                                    <input  required type="text" class="form-control" name="address">
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
