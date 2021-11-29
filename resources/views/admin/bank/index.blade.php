@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Coordonnées bancaires') }}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable" >
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Company Name</th>
                                        <th>Siret</th>
                                        <th>Iban</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bankdetails as $row)
                                    <tr>
                                        <td>{{$row->id}}</td>
                                        <td>{{$row->name}}</td>
                                        <td>{{$row->email}}</td>
                                        <td>{{$row->phone}}</td>
                                        <td>{{$row->company_name}}</td>
                                        <td>{{$row->siret}}</td>
                                        <td>{{$row->iban}}</td>
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

