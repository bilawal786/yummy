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
                            <button type="button"  class="btn btn-icon icon-left btn-primary " data-target="#rank" data-toggle="modal">{{ __('Ajouter un nouveau') }}</button>
                            <div class="modal" id="rank">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attribuer un rang</h5>
                                        </div>
                                        <form action="{{ route('admin.document.store') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">


                                                <div class="form-group">
                                                    <label>{{ __('Statut') }}</label> <span class="text-danger">*</span>
                                                    <select name="user_id" class="form-control select2">
                                                        <option >Sélectionnez le vendeurs</option>
                                                        <option value="all" >Tous  vendeurs</option>
                                                        @foreach($users as $key => $row)
                                                            <option value="{{$row->id}}" >{{ $row->first_name .' '. $row->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>{{ __('Document') }}</label> <span class="text-danger">*</span>
                                                   <input type="file"  class="form-control " name="file" >
                                                    @error('file')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>


                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" >Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>&nbsp;&nbsp;&nbsp;
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
