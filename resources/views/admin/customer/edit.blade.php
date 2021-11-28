@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('Clients') }}</h1>
            {{ Breadcrumbs::render('customers/edit') }}
        </div>

        <div class="section-body">
            <?php
            $invites = \App\Refferal::where('refferal_user', $user->id)->get();
            $ref = \App\Refferal::where('user_id', $user->id)->first();
            $ref_by = \App\User::where('id', $ref->refferal_user)->first();
            ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Parrainer des utilisateurs</b>
                                </div>
                                <div class="col-md-4">
                                   {{$invites->count()}}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <b>Utilisateur de référence</b>
                                </div>
                                <div class="col-md-4">
                                    @if($ref)
                                        OUI
                                    @else
                                        NON
                                    @endif
                                </div>
                            </div>
                            <hr>
                            @if($ref)
                                <div class="row">
                                <div class="col-md-4">
                                    <b>Référencé par</b>
                                </div>
                                <div class="col-md-4">
                                        {{$ref_by->first_name}} {{$ref_by->last_name}}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        	<div class="row">
	   			<div class="col-12 col-md-12 col-lg-12">
			    	<form action="{{ route('admin.customers.update', $user) }}" method="POST" enctype="multipart/form-data">
			    		@csrf
			    		@method('PUT')
				    	<div class="card">
					    	<div class="card-body">
					    		<div class="form-row">
							        <div class="form-group col">
				                        <label>{{ __('Prénom') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $user->first_name) }}">
				                        @error('first_name')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
							        <div class="form-group col">
				                        <label>{{ __('Nom') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $user->last_name) }}">
				                        @error('last_name')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

				                <div class="form-row">
							        <div class="form-group col">
				                        <label>{{ __('Email') }}</label> <span class="text-danger">*</span>
				                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
				                        @error('email')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
							        <div class="form-group col">
				                        <label>{{ __('Téléphone') }}</label>
				                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
				                        @error('phone')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

								<div class="form-row" style="Display:none;">
							        <div class="form-group col">
				                        <label>{{ __('Username') }}</label>
				                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}">
				                        @error('username')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
							        <div class="form-group col">
				                        <label>{{ __('Password') }}</label>
				                        <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
				                        @error('password')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
				                    </div>
				                </div>

				                <div class="form-row" >
							        <div class="form-group col">
	                                    <label for="customFile">{{ __('Image') }}</label>
	                                    <div class="custom-file">
	                                        <input name="image" type="file" class="custom-file-input @error('image') is-invalid @enderror" id="customFile" onchange="readURL(this);">
	                                        <label  class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
	                                    </div>
										@if ($errors->has('image'))
											<div class="help-block text-danger">
												{{ $errors->first('image') }}
											</div>
										@endif
										@if($user->getFirstMediaUrl('user'))
											<img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset($user->getFirstMediaUrl('user')) }}" alt="your image"/>
										@else
											<img class="img-thumbnail image-width mt-4 mb-3" id="previewImage" src="{{ asset('assets/img/default/user.png') }}" alt="your image"/>
										@endif
	                                </div>
                                    <div class="form-group col">
                                        <label>Address</label>
                                        <select name="address" class="form-control">
                                            @foreach($location as $loc)
                                                <option  {{ $user->address == $loc->id ? 'selected' : '' }} value="{{ $loc->id }}">{{$loc->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
				                </div>

				                <div class="form-row">
				                	<div class="form-group col-md-6">
							            <label>{{ __('YummyCoin') }}</label> <span class="text-danger">*</span>
													<input type="text" name="credit" class="form-control @error('credit') is-invalid @enderror" value="{{ old('credit', $user->balance->balance) }}">
							            @error('credit')
					                        <div class="invalid-feedback">
					                          	{{ $message }}
					                        </div>
					                    @enderror
							        </div>
											<div class="form-group col-md-6">
											<label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
											<select name="status" class="form-control @error('status') is-invalid @enderror">
												@foreach(trans('user_statuses') as $key => $status)
														<option value="{{ $key }}" {{ (old('status', $user->status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
													@endforeach
											</select>
											@error('status')
															<div class="invalid-feedback">
																	{{ $message }}
															</div>
													@enderror
									</div>
				                </div>

							</div>
					        <div class="card-footer">
		                    	<button class="btn btn-primary btn-block mr-1" type="submit">{{ __('Enregistrer') }}</button>
		                  	</div>
						</div>
		            </form>
				</div>
        	</div>
        </div>
    </section>

@endsection


@section('scripts')
	<script src="{{ asset('js/customer/edit.js') }}"></script>
@endsection
