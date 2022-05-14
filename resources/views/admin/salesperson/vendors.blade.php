@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Marchands') }}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        @can('shop_create')
                            <div class="card-header">
                                <a href="{{ route('admin.shop.create') }}" class="btn btn-icon icon-left btn-primary"><i
                                            class="fas fa-plus"></i> {{ __('Ajouter un Marchand') }}</a>
                            </div>
                        @endcan

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable"
                                >
                                    <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.name') }}</th>
                                        <th>{{ __('Adresse') }}</th>
                                        <th>{{ __('levels.location') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($shops as $shop)
                                        <tr>
                                            <td>{{$shop->id}}</td>
                                            <td>{{$shop->name}}</td>
                                            <td>{{$shop->address}}</td>
                                            <td>{{$shop->location->name}}</td>
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
    </section>

@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script>
        "use strict";

        $(function () {
            var table = $('#maintable').DataTable({});

        });

        $('#maintable').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip();
        })

    </script>
@endsection
