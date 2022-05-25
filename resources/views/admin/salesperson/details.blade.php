@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Détails de l\'activité') }}</h1>
             <button type="button" style="margin-left: 560px" class="btn btn-icon icon-left btn-primary " data-target="#rank" data-toggle="modal">{{ __('Mettre à jour le classement') }}</button>
            <div class="modal" id="rank">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Attribuer un rang</h5>
                        </div>
                        <form action="{{ route('admin.sales.person.update.rank') }}" method="POST">
                            @csrf
                        <div class="modal-body">

                            <input type="hidden" name="user_id" value="{{$id}}">
                            <div class="form-group">
                                <label>{{ __('Statut') }}</label> <span class="text-danger">*</span>
                                <select name="rank_id" class="form-control select2">
                                    <option >Sélectionnez le statut</option>
                                    @foreach($rank as $key => $row)
                                        <option value="{{$row->id}}">{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>


                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" >Submit</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="article-header">
                                <h5>{{ __('Commerçants créés') }}</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="maintable">
                                                <thead>
                                                <tr>
                                                    <th>{{ __('ID') }}</th>
                                                    <th>{{ __('Nom') }}</th>
                                                    <th>{{ __('Région') }}</th>
                                                    <th>{{ __('Adresse') }}</th>
                                                    <th>{{ __('Créé à') }}</th>
                                                    <th>{{ __('Details') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{$product->shop->id}}</td>
                                                        <td>{{$product->shop->name}}</td>
                                                        <td>{{$product->shop->location->name}}</td>
                                                        <td>{{$product->shop->address}}</td>
                                                        <td>{{$product->shop->created_at}}</td>
                                                        <td> <button type="button" class="btn btn-icon icon-left btn-primary" data-target="#coin" data-toggle="modal">{{ __('Afficher les questions') }}</button></td>
                                                    </tr>
                                                    <div class="modal" id="coin">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Des questions</h5>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="nbr">Comment avez vous contacté ce commerçant ? (Reseaux, phoning, porte à porte, sur recommandation)</label>
                                                                            <input type="text" class="form-control" value="{{$product->shop->q1}}"  readonly>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="valeur">Avez-vous rencontré le décisionnaire?</label>
                                                                            <input type="text" class="form-control" value="{{$product->shop->q2}}"  readonly>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="valeur">Est-il intéressé? Si non pourquoi?</label>
                                                                            <input type="text" class="form-control" value="{{$product->shop->q3}}"  readonly>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="valeur">Si oui, quand sera t-il pret pour commencer?</label>
                                                                            <input type="text" class="form-control" value="{{$product->shop->q4}}"  readonly>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="valeur">Avez-vous besoin d’aide?</label>
                                                                            <input type="text" class="form-control" value="{{$product->shop->q5}}"  readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="article-header">
                                <h5>{{ __('Paniers créés') }}</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="maintable">
                                                <thead>
                                                <tr>
                                                    <th>{{ __('ID') }}</th>
                                                    <th>{{ __('Panier Nom') }}</th>
                                                    <th>{{ __('Prix') }}</th>
                                                    <th>{{ __('Quantité') }}</th>
                                                    <th>{{ __('Vendu ou Annulé') }}</th>
                                                    <th>{{ __('Créé à') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($products as $product)
                                                    <tr>
                                                        <td>{{$product->product->id}}</td>
                                                        <td>{{$product->product->name}}</td>
                                                        <td>{{$product->unit_price}}</td>
                                                        <td>{{$product->quantity}}</td>
                                                        @php
                                                        $line = \App\Models\OrderLineItem::where('product_id', $product->product->id)->first();
                                                        if ($line){
                                                         $order = \App\Models\Order::where('id', $line->order_id)->first();
                                                        }
                                                        @endphp
                                                        <td>
                                                            @if(isset($order))
                                                                @if ($order->status == 20)
                                                                    Vendu
                                                                @elseif ($order->status == 10)
                                                                    Annuler
                                                                @else
                                                                    Prêt à récupérer
                                                                @endif
                                                            @else
                                                                Pas disponible
                                                            @endif
                                                        </td>
                                                        <td>{{$product->product->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

