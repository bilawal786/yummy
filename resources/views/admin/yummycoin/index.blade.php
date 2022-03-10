@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('YummyCoin') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @can('shop_create')
                        <div class="card-header">
                            <button type="button" class="btn btn-icon icon-left btn-primary" data-target="#coin" data-toggle="modal"><i class="fas fa-plus"></i> {{ __('Créer un YummyCoin achetable') }}</button>
                        </div>
                    @endcan
                    <!-- Modal -->
                    <div class="modal" id="coin">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <form action="{{ route('admin.yummycoin.store') }}" method="POST">
                            @csrf
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">YummyCoin</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="nbr">Nombre de YummyCoin</label>
                              <input type="number" class="form-control" id="nbr" name="nombre">
                            </div>
                            <div class="form-group">
                              <label for="valeur">Valeur en €</label>
                              <input type="number" class="form-control" id="valeur" name="valeur">
                            </div>
                            <div class="form-group">
                              <select name="actif" class="form-control">
                                <option value="1">Actif</option>
                                <option value="0">Désactiver</option>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button class="btn btn-primary" type="submit">Enregistrer</button>
                          </div>
                        </form>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="maintable">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Valeur</th>
                                        <th>Statut</th>
                                        <th>{{ __('levels.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($yummycoin as $coin)
                                  <tr role="row">
                                  <td><p class="p-0 m-0">{{$coin->nombre}} YummyCoin</p></td>
                                  <td>{{$coin->valeur}}€</td>
                                  <td>@if($coin->actif == 1) Actif @else Désactiver @endif</td>
                                  <td>
                                    <button type="button" class="btn btn-sm btn-icon float-left btn-primary" data-target="#coin{{$coin->id}}" data-toggle="modal"><i class="far fa-edit"></i></button>
                                    <form class="float-left pl-2" action="yummycoin/{{$coin->id}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"> <i class="fa fa-trash"></i></button></form>
                                  </td>

                                </tr>
                                <!-- Modal -->
                                <div class="modal" id="coin{{$coin->id}}">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <form action="{{ route('admin.yummycoin.update', $coin->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{$coin->nombre}} YummyCoin</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                        <div class="form-group">
                                          <label for="nbr">Nombre de YummyCoin</label>
                                          <input type="number" class="form-control" id="nbr" name="nombre" value="{{$coin->nombre}}">
                                        </div>
                                        <div class="form-group">
                                          <label for="valeur">Valeur en €</label>
                                          <input type="number" class="form-control" id="valeur" name="valeur" value="{{$coin->valeur}}">
                                        </div>
                                        <div class="form-group">
                                          <select name="actif" class="form-control">
                                            <option @if ($coin->actif == 1) selected @endif value="1">Actif</option>
                                            <option @if ($coin->actif == 0) selected @endif value="0">Désactiver</option>
                                          </select>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                        <button class="btn btn-primary" type="submit">Enregistrer</button>
                                      </div>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection



@section('css')
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">

@endsection

@section('scripts')
<script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
@endsection
