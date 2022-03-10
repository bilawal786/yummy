@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Paniers') }}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom de la boutique (nom du panier)</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $row)
                                        <tr>
                                            <td>{{$row->id   }}</td>
                                            <td>{{$row->shop->name}} ({{$row->product->name}})</td>
                                            <td>{{$row->quantity}}</td>
                                            <td>
                                                <a href="{{route('admin.products.edit', $row->product_id)}}" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>
                                                <a href="{{route('admin.product.my.delete', $row->product_id)}}" class="btn btn-sm btn-icon float-left btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="far fa-cross"></i></a>
                                                <a href="{{route('admin.product.duplicate', $row->product_id)}}" class="btn btn-sm btn-icon float-left btn-success" data-toggle="tooltip" data-placement="top" title="Dupliquer"> <i class="far fa-copy"></i></a>
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

        $(function() {
            var table = $('#maintable').DataTable({

            });

        });

        $('#maintable').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip();
        })

    </script>
@endsection
