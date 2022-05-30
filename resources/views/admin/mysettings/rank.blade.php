@extends('admin.layouts.master')
<style>
    .active {
        background-color: white!important;
    }
</style>
@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Vendeurs Statut') }}</h1>
            {{ Breadcrumbs::render('customers') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
{{--                        <div class="card-header">--}}
{{--                            <a href="{{route('admin.salesPerson.status.create')}}"><button class="btn btn-primary">Ajouter un nouveau statut</button></a>&nbsp;&nbsp;&nbsp;&nbsp;--}}
{{--                        </div>--}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable">
                                    <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Nom') }}</th>
                                        <th>{{ __('Couleur') }}</th>
                                        <th>{{ __('Action') }}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rank as $row)
                                        <tr>
                                            <td>{{$row->id}}</td>

                                            <td>{{$row->name}}</td>
                                            <td><input type="color" value="{{$row->color}}" disabled></td>

                                            <td><a href="{{route('admin.salesperson.scale.status', ['id' => $row->id])}}"
                                                   class="btn btn-sm btn-icon float-left btn-primary ml-2"
                                                   data-toggle="tooltip" data-placement="top" title="View"><i
                                                            class="far fa-eye"></i></a>
                                                <a href="{{route('admin.salesperson.status.edit', ['id' => $row->id])}}"
                                                   class="btn btn-sm btn-icon float-left btn-success ml-2"
                                                   data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fa fa-pen"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{$rank->links()}}
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
