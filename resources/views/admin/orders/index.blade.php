@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Commandes') }}</h1>
        </div>

        <div class="section-body">
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
                @if( Auth::user()->hasRole('Admin') )
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
                            <h4>{{ __('Prêt à ramasser') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $read_pickup }}
                        </div>
                    </div>
                </div>
            </div>
                @endif
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
                @if(Auth::user()->hasRole('Admin'))
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
                    @endif
        </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-8 offset-sm-2">
                                    <div class="input-group input-daterange" id="date-picker">
                                        <select class="form-control" id="status" name="status" id="">
                                            <option value="20">Vendu</option>
                                                <option value="10">Annulé</option>
                                                <option value="17">Prêt à ramasser</option>
                                        </select>
                                        <input autocomplete="off" class="form-control" id="start_date" type="text" name="start_date" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}">
                                        <input autocomplete="off" class="form-control" id="end_date" type="text" name="end_date" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="refresh"> {{ __('Rafraichir') }}</button>
                                        </div>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="date-search">{{ __('Rechercher') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-striped" id="main-table" data-url="{{ route("admin.orders.get-orders") }}" data-status="{{ \App\Enums\OrderStatus::PENDING }}" data-hidecolumn="{{ auth()->user()->can('orders_show') || auth()->user()->can('orders_edit') || auth()->user()->can('orders_delete') }}">
                                    <thead>
                                    <tr>
                                        <th>{{ __('Numéro') }}</th>
                                        <th>{{ __('Nom') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Total') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                    </thead>
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
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/orders/index.js') }}"></script>
@endsection
