@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/classic.css" integrity="sha512-vd5p9dyk1WVulhnr0xGEie0QVqDQfErKknlJ9k8UyK9ZZFGR95r3cfLr+NZAkex0FHAlfUG6A284s9ofTW4rTw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/classic.time.css" integrity="sha512-Ye2PnTA5KFgQC9x/VoMRaJbiJpAPnc00zmVPar9/FNOBwdhIPYCUY2z6WUtduWp12ZE+lWlM53yQPQM2DlPxqQ==" crossorigin="anonymous" />
@endsection

@section('main-content')

	<section class="section">
        <div class="section-header">
            <h1>{{ __('Marchand') }}</h1>
        </div>

        <div class="section-body">
			<form action="{{ route('admin.shop.update', $shop) }}" method="POST" enctype="multipart/form-data">
			    @csrf
			    @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="article-header">
                                    <h5>{{ __('General') }}</h5>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <label for="location">{{ __('levels.location') }}</label> <span class="text-danger">*</span>
                                        <select name="location_id" id="location" class="select2 form-control @error('location_id') is-invalid red-border @enderror" data-url="{{ route('admin.shop.get-area') }}">
                                            <option value="">{{ __('Select Location') }}</option>
                                            @if(!blank($locations))
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}" {{ (old('location_id', $shop->location_id) == $location->id) ? 'selected' : '' }}>{{ $location->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('location_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="vip">VIP</label> <span class="text-danger">*</span>
                                        <select name="vip" id="vip" class="select2 form-control">
                                            <option value="0">Non</option>
                                            <option value="1" {{ ($shop->vip == 1) ? 'selected' : '' }}>Oui</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                                        <input id="name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $shop->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col {{ $errors->has('categories') ? " has-error " : '' }}">
                                        <label for="categories">{{ __('levels.categories') }}</label> <span class="text-danger">*</span>
                                        <select id="categories" name="categories[]" class="form-control select2 {{ $errors->has('categories') ? " is-invalid " : '' }}" multiple="multiple" required>
                                          @if(!blank($categories))
                                              @foreach($categories as $category)
                                                  @if(in_array($category->id, $shop_categories))
                                                      <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                                  @else
                                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                  @endif
                                              @endforeach
                                          @endif
                                        </select>
                                        @if ($errors->has('categories'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('categories') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group col" style="display:none;">
                                        <label>{{ __('levels.delivery_charge') }}</label>
                                        <input type="text" name="delivery_charge" class="form-control @error('delivery_charge') is-invalid @enderror" value="{{ old('delivery_charge', $shop->delivery_charge) }}">
                                        @error('delivery_charge')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row" style="display:none">
                                    <div class="form-group col">
                                        <label for="lat">{{ __('levels.latitude') }}</label>
                                        <input type="text" name="lat" id="lat" class="form-control @error('lat') is-invalid @enderror" value="{{ old('lat', $shop->lat) }}">
                                        @error('lat')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="long">{{ __('levels.longitude') }}</label>
                                        <input type="text" id="long" name="long" class="form-control @error('long') is-invalid @enderror" value="{{ old('long', $shop->long) }}">
                                        @error('long')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row" style="display:none">
                                    <div class="form-group col">
                                        <label>{{ __('levels.current_status') }}</label> <span class="text-danger">*</span>
                                        <select name="current_status" class="form-control @error('current_status') is-invalid @enderror">
                                            @foreach(trans('current_statuses') as $current_statusKey => $current_status)
                                                <option value="{{ $current_statusKey }}" {{ (old('current_status', $shop->current_status) == $current_statusKey) ? 'selected' : '' }}>{{ $current_status }}</option>
                                            @endforeach
                                        </select>
                                        @error('current_status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            @foreach(trans('statuses') as $statusKey => $status)
                                                <option value="{{ $statusKey }}" {{ (old('status', $shop->status) == $statusKey) ? 'selected' : '' }}>{{ $status }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ __('levels.shop_address') }}</label> <span class="text-danger">*</span>
                                    <input name="shopaddress" class="form-control @error('shopaddress') is-invalid @enderror" id="shopaddress" value="{{ old('shopaddress', $shop->address) }}">
                                    @error('shopaddress')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">{{ __('levels.description') }}</label>
                                    <textarea  name="description" class="form-control small-textarea-height @error('description') is-invalid @enderror" id="description">{{ old('description', $shop->description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="customLogo">Logo</label>
                                    <div class="custom-file">
                                        <input name="logo" type="file"
                                            class="custom-file-input @error('logo') is-invalid @enderror" id="customLogo"
                                            onchange="readURL(this);">
                                        <label class="custom-file-label" for="customLogo">Choisir un fichier</label>
                                    </div>
                                    @if ($errors->has('logo'))
                                    <div class="help-block text-danger">
                                        {{ $errors->first('logo') }}
                                    </div>
                                    @endif
                                    <img class="img-thumbnail image-width mt-4 mb-3" id="previewImage"
                                        src="{{ $shop->logo }}" alt="your image" />
                                </div>
                                <div class="form-group">
                                    <label for="customFile">{{ __('levels.shop_image') }}</label>
                                    <div class="custom-file">
                                        <input name="image" type="file" class="custom-file-input custom-file-in @error('image') is-invalid @enderror" id="customFile" onchange="readURLe(this);">
                                        <label  class="custom-file-label custom-file-lab" for="customFile">Choisir un fichier</label>
                                    </div>
                                    @if ($errors->has('image'))
                                        <div class="help-block text-danger">
                                            {{ $errors->first('image') }}
                                        </div>
                                    @endif
                                    <img class="img-thumbnail image-width mt-4 mb-3" id="previewImages" src="{{ $shop->images }}" alt="{{ __('your image') }}"/>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="article-header">
                                    <h5>{{ __('Horaire') }}</h5>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="opening_time">{{ __('levels.opening_time') }}</label>
                                        <input id="opening_time" type="text" name="opening_time" class="form-control timepicker @error('opening_time') is-invalid @enderror" value="{{ old('opening_time', $shop->opening_time) }}">
                                        @error('opening_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col">
                                        <label for="closing_time">{{ __('levels.closing_time') }}</label>
                                        <input id="closing_time" type="text" name="closing_time" class="form-control timepicker @error('closing_time') is-invalid @enderror" value="{{ old('closing_time', $shop->closing_time) }}">
                                        @error('closing_time')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="article- header">
                                    <h5>{{ __('Collaborateur') }}</h5>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="first_name">{{ __('levels.first_name') }}</label> <span class="text-danger">*</span>
                                        <input id="first_name" type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $shop->user->first_name ?? null) }}">
                                        @error('first_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col">
                                        <label for="last_name">{{ __('levels.last_name') }}</label> <span class="text-danger">*</span>
                                        <input id="last_name" type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $shop->user->last_name ?? null) }}">
                                        @error('last_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="email">{{ __('levels.email') }}</label> <span class="text-danger">*</span>
                                        <input id="email" type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $shop->user->email ?? null) }}">
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group col" style="display:none">
                                        <label for="username">{{ __('levels.username') }}</label>
                                        <input id="username" type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('last_name', $shop->user->username ?? null) }}">
                                        @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col">
                                        <label for="password">{{ __('levels.password') }}</label><span class="text-danger">*</span>
                                        <input id="password" type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            value="{{ old('password') }}">
                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="phone">{{ __('levels.phone') }}</label> <span class="text-danger">*</span>
                                        <input id="phone" type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $shop->user->phone ?? null) }}">
                                        @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="address">Choisissez une région</label><span class="text-danger">*</span>
                                    <select name="address"
                                            class="select2 form-control @error('address') is-invalid red-border @enderror"
                                            data-url="{{ route('admin.shop.get-area') }}">
                                        @if(!blank($locations))
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}"
                                                    {{ (old('address') == $location->id) ? 'selected' : '' }}>
                                                    {{ $location->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-row">
                                    <div class="form-group col" style="display:none">
                                        <label>{{ __('levels.deposit_amount') }}</label>
                                        <input type="number" name="deposit_amount" class="form-control @error('deposit_amount') is-invalid @enderror" value="{{ old('deposit_amount', $shop->user->deposit->deposit_amount ?? '') }}">
                                        @error('deposit_amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col" style="display:none">
                                        <label>{{ __('levels.limit_amount') }}</label>
                                        <input type="number" name="limit_amount" class="form-control @error('limit_amount') is-invalid @enderror" value="{{ old('limit_amount', $shop->user->deposit->limit_amount ?? '') }}">
                                        @error('limit_amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col" style="display:none">
                                        <label>{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                        <select name="userstatus" class="form-control @error('userstatus') is-invalid @enderror">
                                            @foreach(trans('user_statuses') as $key => $userstatus)
                                                <option value="{{ $key }}" {{ (old('userstatus', $shop->user->status) == $key) ? 'selected' : '' }}>{{ $userstatus }}</option>
                                            @endforeach
                                        </select>
                                        @error('userstatus')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-block btn-primary mr-1" type="submit">{{ __('Enregistrer') }}</button>
                    </div>
                </div>
			</form>
        </div>
    </section>

@endsection

@section('scripts')
<script src="https://maps.google.com/maps/api/js?key=AIzaSyAeKxMwTMJzHH2AR1xt7OLWIWFMIzm-JLM&libraries=places" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.js" integrity="sha512-PC6BMUJfhXSSRw6fOnyfn21Yjc/6oRUnAGUboA+uzAUkKX5K2wzUvTHPCEjfwmmfrjCuiSnf23iX8JYVlJTXmA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.time.js" integrity="sha512-wsTBGzc0ra42jNgXre39rdHpXqAkkaSN+bRrXZ3hpOvqxOtLNZns3OseDZRfGCWSs00N9HuXyKHZEzKAWCl3SA==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/translations/fr_FR.js" integrity="sha512-oppWtIxLpE9C9k/RJ/+z8pZXIh2PIuYDYsklCWMFsoTxK2bRMJ9Y86rvVZ20NkOBsjrywgEIi/tibOxJk7cXmg==" crossorigin="anonymous"></script>
<script src="{{ asset('js/product/edit.js') }}"></script>
<script type="text/javascript">
$('.timepicker').pickatime({
  format: 'HH:i',
  formatSubmit: 'HH:i',
  hiddenName: true,
});
    google.maps.event.addDomListener(window, 'load', initialize);
    function initialize() {
        var input = document.getElementById('shopaddress');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            $('#lat').val(place.geometry['location'].lat());
            $('#long').val(place.geometry['location'].lng());
          });
        }
   </script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('js/shop/edit.js') }}"></script>
@endsection
