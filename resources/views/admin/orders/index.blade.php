@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Commandes') }}</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.order.fetch.status')}}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <p>Ordres de Recherche: </p>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group input-daterange" id="date-picker">
                                <select class="form-control" id="status" name="status" id="">
                                    <option value="0">Tous</option>
                                    <option value="20">Tout vendu</option>
                                    <option value="10">Annulé</option>
                                    <option value="17">Prêt à récupérer</option>
                                </select>
                                <input autocomplete="off" class="form-control" id="start_date" type="date" name="start_date" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}">
                                <input autocomplete="off" class="form-control" id="end_date" type="date" name="end_date" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" >{{ __('Rechercher') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                    </div>
                    </form>
                    <br>
                    <form action="{{route('admin.order.fetch.traders')}}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <p>Ordres des commerçants à l'exportation</p>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group input-daterange" id="date-picker">
                                <select  id="location" name="shop_id"
                                        class="select2 form-control">
                                    @if( Auth::user()->hasRole('Admin') )
                                    <option value="">Sélectionnez un commerçant</option>
                                    <?php
                                    $shops = \App\Models\Shop::all();
                                    ?>
                                    @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                    @endforeach
                                    @else
                                        <option value="{{Auth::user()->shop->id}}">{{Auth::user()->shop->name}}</option>
                                    @endif

                                </select>
                                <input autocomplete="off" class="form-control" id="start_date" type="date" name="start_date" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}">
                                <input autocomplete="off" class="form-control" id="end_date" type="date" name="end_date" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit" >{{ __('Exportation') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>

                    </div>
                    </form>
                </div>
            </div>

            <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-plus-square"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Total') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_order }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-paper-plane"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Annulé') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $cancelled }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-star"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Prêt à récupérer') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $read_pickup }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('Vendu') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $completed_order }}
                        </div>
                    </div>
                </div>
            </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="far fa-star"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Revenu récupéré') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $recover_revenue }} €
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-secondary">
                                <i class="far fa-star"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>{{ __('Revenu annulé') }}</h4>
                                </div>
                                <div class="card-body">
                                    {{ $cancel_revenue }} €
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <a href="{{route('admin.orders.export')}}"> <button class="btn btn-primary">Commande Exportation</button></a>
                    </div>
        </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped" id="maintable">
                                <thead>
                                <tr>
                                    <th>{{ __('Numéro') }}</th>
                                    <th>{{ __('Nom') }}</th>
                                    <th>{{ __('Commerçant') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $row)
                                    <tr>
                                        <td>{{$row->order_code}}</td>
                                        <td>{{$row->user->first_name}} {{$row->user->last_name}}</td>
                                        <td>{{$row->shop->user->first_name}} {{$row->shop->user->last_name}}</td>
                                        <td>{{\Carbon\Carbon::parse($row->created_at)->format('d M Y, H:i')}}</td>
                                        <td>
                                            @if ($row->status == 20)
                                            Vendu
                                            @elseif ($row->status == 10)
                                            Annuler
                                            @else
                                            Prêt à récupérer
                                            @endif
                                        </td>
                                        <td>{{$row->total.'€'}}</td>
                                        <td>
                                            <a href="{{route('admin.orders.show', $row->id)}}" class="btn btn-sm btn-icon btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>
                                            @if ($row->status != 20)
                                                <a href="{{route('admin.orders.edit', $row->id)}}" class="pl-2 btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script>
        "use strict";

        $(function() {
            var table = $('#maintable').DataTable({

            });

        });

        $('#maintable').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip();
        })

    </script>
@endsection
