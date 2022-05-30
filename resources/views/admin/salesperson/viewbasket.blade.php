@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Détails de l\'activité') }}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">

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
                                                @foreach($orders as $key=>$row)

                                                    <tr>
                                                        <td>{{$row->order_id}}</td>
                                                        <td>{{$row->product->name}}</td>
                                                        <td>{{$row->unit_price}}</td>
                                                        <td>{{$row->quantity}}</td>
                                                        @php
                                                            if ($row){
                                                             $order = \App\Models\Order::where('id', $row->order_id)->first();
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
                                                        <td>{{$order->created_at}}</td>
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

