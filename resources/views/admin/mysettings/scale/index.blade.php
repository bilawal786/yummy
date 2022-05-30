@extends('admin.layouts.master')

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
                        <div class="card-header">
{{--                            <a href="{{route('admin.salesPerson.scale.create')}}"><button class="btn btn-primary">Ajouter un nouveau Bareme</button></a>&nbsp;&nbsp;&nbsp;&nbsp;--}}
                            {{--                            <a href="{{route('admin.salesPerson.scale.create')}}"><button class="btn btn-primary">Ajouter un nouveau Bareme</button></a>--}}
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable">
                                    <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Statut') }}</th>
                                        <th>{{ __('Titre') }}</th>
                                        <th>{{ __('Action') }}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($scale as $row)
                                        <tr>
                                            <td>{{$row->id}}</td>
                                            <td>{{$row->rank->name}}</td>
                                            <td>{{$row->title}}</td>


                                            <td>
                                                <a href="{{route('admin.salesperson.scale.edit', ['id' => $row->id])}}"
                                                   class="btn btn-sm btn-icon float-left btn-primary ml-2"
                                                   data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fa fa-pen"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{$scale->links()}}
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
