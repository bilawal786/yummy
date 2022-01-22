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
				    	<form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
				    		@csrf
						    <div class="card-body">
                         		<!--<div class="form-row">
                                    <div class="form-group col">
										<label>{{ __('levels.title') }}</label>
										<input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
										@error('name')
										<div class="invalid-feedback">
											{{ $message }}
										</div>
										@enderror
									</div>
								</div>-->
								<div class="form">
									<div class="form-group col">
										<label>Lien de la bannière <small>ajouter (#) si aucun lien n'est disponible</small></label>
										<input type="url" name="url" class="form-control" required>
									</div>
									<div class="form-group col">
										<label>Sélectionnez l'emplacement</label>
										<select name="location" class="form-control">
										<option value="#">Sélectionnez l'emplacement</option>
										@foreach($location as $loc)
										<option value="{{ $loc->id }}">{{$loc->name}}</option>
										@endforeach
										</select>
									</div>
									<div class="form-group col">
										<label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
										<select name="status" class="form-control @error('status') is-invalid @enderror">
											@foreach(trans('statuses') as $key => $status)
												<option value="{{ $key }}" {{ (old('status') == $key) ? 'selected' : '' }}>{{ $status }}</option>
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
											<input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);">
											<label  class="custom-file-label" for="customFile">{{ __('Choisir une image') }}</label>
										</div>
										@if ($errors->has('image'))
											<div class="help-block text-danger">
												{{ $errors->first('image') }}
											</div>
										@endif
										<img class="img-thumbnail mt-4 mb-3" id="previewImage" src="{{ asset('assets/img/default/banner.jpg') }}" alt="your image"/>
									</div>

									<!--<div class="form-group col">
										<label>{{ __('levels.description') }}</label>
										<textarea name="description" class="summernote-simple form-control height-textarea @error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
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
    <script src="{{ asset('js/banner/create.js') }}"></script>
@endsection
