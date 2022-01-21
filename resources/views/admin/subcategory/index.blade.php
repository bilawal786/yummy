@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Sous Catégories') }}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('category_create')
                            <div class="card-header">
                                <a href="{{ route('admin.souscategorie.create') }}" class="btn btn-icon icon-left btn-primary"><i class="fas fa-plus"></i> {{ __('Ajouter une sous catégorie') }}</a>
                            </div>
                        @endcan
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable" >
                                    <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.image') }}</th>
                                        <th>{{ __('levels.name') }}</th>
                                        <th>{{ __('Catégorie') }}</th>
                                        <th>{{ __('Région') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subcateg as $cat)
                                    <tr>
                                        <td>{{$cat->id}}</td>
                                        <td><img src="{{asset($cat->image)}}" style="height: 30px" alt=""></td>
                                        <td>{{$cat->name}}</td>
                                        <td>{{$cat->category->name}}</td>
                                        <td>{{$cat->category->country->name}}</td>
<!--                                        <td>
                                            <form method="POST" action="{{route('admin.souscategorie.destroy', $cat->id)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Suprême</button>
                                            </form></td>-->
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
