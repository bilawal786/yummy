@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Suggérer un commerce') }}</h1>
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
                                        <th>Nom</th>
                                        <th>Phone</th>
                                        <th>Type</th>
                                        <th>Address</th>
                                        <th>Postal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($suggestions as $row)
                                    <tr>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->phone}}</td>
                                        <td>{{$row->type}}</td>
                                        <td>{{$row->address}}</td>
                                        <td>{{$row->postal}}</td>
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


