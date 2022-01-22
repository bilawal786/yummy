@extends('admin.layouts.master')

@section('main-content')

<section class="section">
    <div class="section-header">
        <h1>{{ __('Bannières') }}</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form action="{{ route('admin.banner.update', $banner) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            <div class="form">
                                <div class="form-group col">
                                    <label>Lien de la bannière</label>
                                    <input type="url" name="url" value="{{$banner->link}}" class="form-control" required>
                                </div>
                                <div class="form-group col">
                                    <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach(trans('statuses') as $key => $status)
                                        <option value="{{ $key }}"
                                            {{ (old('status', $banner->status) == $key) ? 'selected' : '' }}>
                                            {{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form">
                                <div class="form-group col">
                                    <label for="customFile">{{ __('levels.image') }}</label> <span class="text-danger">*</span>
                                    <div class="custom-file">
                                        <input name="image" type="file"
                                            class="custom-file-input @error('image') is-invalid @enderror"
                                            id="customFile" onchange="readURL(this);">
                                        <label class="custom-file-label"
                                            for="customFile">{{ __('Choisir une image') }}</label>
                                    </div>
                                    @if ($errors->has('image'))
                                    <div class="help-block text-danger">
                                        {{ $errors->first('image') }}
                                    </div>
                                    @endif
                                    @if($banner->getFirstMediaUrl('banners'))
                                    <img class="img-thumbnail mt-4 mb-3" id="previewImage"
                                        src="{{ asset($banner->getFirstMediaUrl('banners')) }}" alt="your image" />
                                    @else
                                    <img class="img-thumbnail mt-4 mb-3" id="previewImage"
                                        src="{{ asset('assets/img/default/category.png') }}"
                                        alt="{{ __('your image') }}" />
                                    @endif
                                </div>

                                <!--<div class="form-group col">
                                    <label>{{ __('levels.description') }}</label>
                                    <textarea name="description"
                                        class="summernote-simple form-control height-textarea @error('description') is-invalid @enderror"
                                        id="description" cols="30"
                                        rows="10">{{ old('description', $banner->short_description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>-->
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-primary btn-block mr-1" type="submit">{{ __('levels.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('js/banner/edit.js') }}"></script>
@endsection
