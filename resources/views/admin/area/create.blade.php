@extends('admin.layouts.master')

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>Ville</h1>
            {{ Breadcrumbs::render('area/add') }}
        </div>

        <div class="section-body">
        	<div class="row">
	   			<div class="col-md-12">
				    <div class="card">
				    	<form action="{{ route('admin.area.store') }}" method="POST">
				    		@csrf
						    <div class="card-body">
									<div class="form-group">
														<label>Code Postal</label> <span class="text-danger">*</span>
														<input type="text" name="cp" id="cp" class="form-control @error('cp') is-invalid @enderror" value="{{ old('cp') }}">
														@error('cp')
															<div class="invalid-feedback">
																	{{ $message }}
															</div>
													@enderror
												</div>
						        <div class="form-group">
			                        <label>{{ __('levels.name') }}</label> <span class="text-danger">*</span>
			                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" disabled>
			                        @error('name')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
			                    </div>

						        <div class="form-group">
						            <label>{{ __('levels.location') }}</label> <span class="text-danger">*</span>
						            <select name="location_id" class="form-control @error('location_id') is-invalid @enderror">
						            	<option value="">{{ __('Choisir une région') }}</option>
						            	@if(!blank($locations))
							            	@foreach($locations as $location)
							                	<option value="{{ $location->id }}" {{ (old('location_id') == $location->id) ? 'selected' : '' }}>{{ $location->name }}</option>
							                @endforeach
							            @endif
						            </select>
						            @error('location_id')
				                        <div class="invalid-feedback">
				                          	{{ $message }}
				                        </div>
				                    @enderror
						        </div>

						        <div class="form-group">
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

					        <div class="card-footer">
		                    	<button class="btn btn-primary mr-1 btn-block" type="submit">{{ __('Enregistrer') }}</button>
		                  	</div>
		                </form>
					</div>
				</div>
			</div>
        </div>
    </section>

@endsection
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-ui-bootstrap@1.0.0/jquery.ui.theme.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-ui-bootstrap@1.0.0/jquery.ui.theme.font-awesome.css">
@endsection
@section('scripts')
<script
			  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
			  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
			  crossorigin="anonymous"></script>
<script>
$("#cp").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "https://geo.api.gouv.fr/communes?codePostal="+$("input[name='cp']").val()+"&fields=nom,code,codesPostaux,codeDepartement,codeRegion,population&format=geojson&geometry=centre",
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
                var postcodes = [];
                response($.map(data.features, function (item) {
                    // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
										$('#name').val(item.properties.nom);
									/*	return { label: item.properties.nom,
														 value: $('#cp').value
										};*/
										// On remplit aussi la ville
										/*select: function(event, ui) {
												$('#name').val(ui.item.nom);
										};*/
                    /*if ($.inArray(item.properties.codesPostaux, postcodes) == -1) {
                        postcodes.push(item.properties.codesPostaux);
												console.log(postcodes);
                        return { label: item.properties.codesPostaux + " - " + item.properties.nom,
                                 city: item.properties.nom,
                                 value: item.properties.codesPostaux
                        };
                    }*/
                }));
            }
        });
    },

});
</script>
@endsection
