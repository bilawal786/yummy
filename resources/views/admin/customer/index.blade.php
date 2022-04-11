@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Clients') }}</h1>
            {{ Breadcrumbs::render('customers') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <a href="{{route('admin.users.export')}}">
                                        <button class="btn btn-success btn-sm">Clients d'exportation</button>
                                    </a>

                                </div>
                                <div class="col-4">
                                    <select onchange="location = this.value;" name="" class="form-control" id="">
                                        <option value="">Choisissez le pays</option>
                                        @foreach($location as $loc)
                                            <option value="{{route('admin.get-country-users', ['id' => $loc->id])}}">{{$loc->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable">
                                    <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Nom') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Téléphone') }}</th>
                                        <th>{{ __('Coins') }}</th>
                                        <th>{{ __('Parrainage') }}</th>
                                        <th>Pays</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>
                                                <figure class="avatar mr-2"><img src="{{asset($user->images)}}" alt="">
                                                </figure>
                                            </td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->phone}}</td>
                                            <td>{{$user->balance->balance}}</td>
                                            <td>
                                                @php
                                                    $refferal = \App\Refferal::where('refferal_user', $user->id)->count();
                                                @endphp
                                                {{$refferal}}</td>
                                            <td>{{$user->country->name}}</td>
                                            <td><a href="{{route('admin.customers.edit', $user)}}"
                                                   class="btn btn-sm btn-icon float-left btn-primary ml-2"
                                                   data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="far fa-edit"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    {{$users->links()}}
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
