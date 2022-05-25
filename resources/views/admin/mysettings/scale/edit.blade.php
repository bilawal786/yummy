@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Localisation') }}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">

                        <form action="{{ route('admin.sales.person.scale.update',['id'=>$scale->id]) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{ __('Échelle titre') }}</label> <span class="text-danger">*</span>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{$scale->title}}">
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>{{ __('Statut') }}</label> <span class="text-danger">*</span>
                                    <select name="rank_id" class="form-control @error('rank_id') is-invalid @enderror">
                                        <option >Sélectionnez le statut</option>
                                        @foreach($rank as $key => $row)
                                            <option value="{{$row->id}}" @if($scale->rank_id== $row->id) selected='selected' @endif>{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary mr-1" type="submit">{{ __('Submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
