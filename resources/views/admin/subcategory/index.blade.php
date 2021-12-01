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
                                        <th>{{ __('levels.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subcateg as $cat)
                                    <tr>
                                        <td>{{$cat->id}}</td>
                                        <td><img src="{{asset($cat->image)}}" style="height: 30px" alt=""></td>
                                        <td>{{$cat->name}}</td>
                                        <td>{{$cat->category->name}}</td>
                                        <td>
                                            <form method="POST" action="{{route('admin.souscategorie.destroy', $cat->id)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Suprême</button>
                                            </form></td>
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

