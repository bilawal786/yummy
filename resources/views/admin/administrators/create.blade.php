@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('Administrateurs') }}</h1>
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-12 col-md-12 col-lg-12">
			    	<form action="{{ route('admin.administrators.store') }}" method="POST" enctype="multipart/form-data">
			    		@csrf
				    	<div class="card">
					    	<div class="card-body">
					    		<div class="form-row">
							        <div class="form-group col">
				                        <label>{{ __('levels.first_name') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
				                        @error('first_name')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
							        <div class="form-group col">
				                        <label>{{ __('levels.last_name') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
				                        @error('last_name')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

				                <div class="form-row">
							        <div class="form-group col">
				                        <label>{{ __('levels.email') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
				                        @error('email')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
							        <div class="form-group col">
				                        <label>{{ __('levels.phone') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
				                        @error('phone')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

								<div class="form-row">
							        <div class="form-group col">
				                        <label>{{ __('levels.username') }}</label>
				                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
				                        @error('username')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
							        <div class="form-group col">
				                        <label>{{ __('levels.password') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
				                        @error('password')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

				                <div class="form-row" style="Display:none;">
				                	<div class="form-group col">
	                                    <label for="customFile">{{ __('levels.image') }}</label>
	                                    <div class="custom-file">
	                                        <input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);">
	                                        <label  class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
	                                    </div>
										@if ($errors->has('image'))
											<div class="help-block text-danger">
												{{ $errors->first('image') }}
											</div>
										@endif
	                                    <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset('assets/img/default/user.png') }}" alt="your image"/>
	                                </div>
							        <div class="form-group col">
				                        <label>{{ __('levels.address') }}</label>
				                        <textarea name="address" class="form-control small-textarea-height" id="address" cols="30" rows="10">{{ old('address') }}</textarea>
				                        @error('address')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

				                <div class="form-row">
				                	<div class="form-group col-md-6">
							            <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
							            <select name="status" class="form-control @error('status') is-invalid @enderror">
							            	@foreach(trans('user_statuses') as $key => $status)
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
				                <div class="form-row">
				                	<div class="col-md-3">
										<label for="">Localisation</label><br>
										<input type="checkbox" name="p1" value="1">
									</div>
				                	<div class="col-md-3">
										<label for="">Catégorie</label><br>
										<input type="checkbox" name="p2" value="1">
									</div>
				                	<div class="col-md-3">
										<label for="">Paniers</label><br>
										<input type="checkbox" name="p3" value="1">
									</div>
				                	<div class="col-md-3">
										<label for="">Boutique</label><br>
										<input type="checkbox" name="p4" value="1">
									</div>
				                	<div class="col-md-3">
										<label for="">Commandes</label><br>
										<input type="checkbox" name="p5" value="1">
									</div>
				                	<div class="col-md-3">
										<label for="">Utilisateurs</label><br>
										<input type="checkbox" name="p6" value="1">
									</div>
				                	<div class="col-md-3">
										<label for="">Bannières</label><br>
										<input type="checkbox" name="p7" value="1">
									</div>
				                	<div class="col-md-3">
										<label for="">Yummy Coin</label><br>
										<input type="checkbox" name="p8" value="1">
									</div>
				                	<div class="col-md-3">
										<label for="">Coordonnées bancaires</label><br>
										<input type="checkbox" name="p9" value="1">
									</div>
				                	<div class="col-md-3">
										<label for="">Notifications</label><br>
										<input type="checkbox" name="p10" value="1">
									</div>
				                </div>

							</div>
					        <div class="card-footer">
		                    	<button class="btn btn-block btn-primary mr-1" type="submit">{{ __('Enregistrer') }}</button>
		                  	</div>
						</div>
		            </form>
				</div>
        	</div>
        </div>
    </section>

@endsection

@section('scripts')
	<script src="{{ asset('js/administrators/create.js') }}"></script>
@endsection
