@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Administrateurs de la boutique') }}</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <a href="{{route('admin.create.shopadmins')}}"><button class="btn btn-primary">Ajouter nouveau</button></a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="maintable">
                                <thead>
                                <tr>
                                    <th>{{ __('Id') }}</th>
                                    <th>{{ __('Nom') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Telephone') }}</th>
{{--                                    <th>{{ __('Actions') }}</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $row)
                                    <tr>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->first_name}} {{$row->last_name}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{$row->phone}}</td>
{{--                                        <td>{{$row->phone}}</td>--}}
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
