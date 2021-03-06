@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/classic.css"
          integrity="sha512-vd5p9dyk1WVulhnr0xGEie0QVqDQfErKknlJ9k8UyK9ZZFGR95r3cfLr+NZAkex0FHAlfUG6A284s9ofTW4rTw=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/classic.time.css"
          integrity="sha512-Ye2PnTA5KFgQC9x/VoMRaJbiJpAPnc00zmVPar9/FNOBwdhIPYCUY2z6WUtduWp12ZE+lWlM53yQPQM2DlPxqQ=="
          crossorigin="anonymous"/>
    <style type="text/css">
        input[name="unit_price"] {
            pointer-events: none;
        }
    </style>
@endsection

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Panier') }}</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.products.update', $product) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input name="shop_id" value="{{$shopproduct->shop_id}}" hidden>
                            <div class="card-body">
                                <div class="form">
                                    <div class="form-group col" style="display:none;">
                                        <label for="name">{{ __('levels.name') }}</label> <span
                                                class="text-danger">*</span>
                                        <input id="name" type="text" name="name"
                                               class="form-control {{ $errors->has('name') ? " is-invalid " : '' }}"
                                               value="{{ old('name', $shopproduct->shop->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col">
                                    <label for="location">Localisation</label> <span
                                            class="text-danger">*</span>
                                    <select onchange="categorychange(this)" name="location_id" id="location"
                                            class="select2 form-control @error('location_id') is-invalid red-border @enderror"
                                            data-url="{{ route('admin.shop.get-area') }}">
                                        <option value="">{{ __('Choisir une localisation') }}</option>
                                        @if(!blank($locations))
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}"
                                                        {{ $shopproduct->shop->location_id == $location->id? 'selected' : '' }}>
                                                    {{ $location->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('location_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col {{ $errors->has('categories') ? " has-error " : '' }}">
                                    <label for="categories">{{ __('levels.categories') }}</label> <span
                                            class="text-danger">*</span>
                                    <select onchange="subcategorychange(this)" id="categories" name="categories[]"
                                            class="category form-control select2 {{ $errors->has('categories') ? " is-invalid " : '' }}"
                                            required>
                                        <option value="{{ $shopproduct->shop->categories[0]->id }}">
                                            {{ $shopproduct->shop->categories[0]->name }}</option>
                                    </select>
                                    @if ($errors->has('categories'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('categories') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group col">
                                    <label for="categories">{{ __('Sous-cat??gorie') }}</label> <span
                                            class="text-danger"></span>
                                    <select id="categories" name="subcategory" class="subcategory form-control select2">
                                        <option value="{{ $product->subcategory->id??'' }}">
                                            {{ $product->subcategory->name??'' }}</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="name">Nom du panier</label> <span
                                            class="text-danger">*</span>
                                    <input id="name" type="text" name="name"
                                           class="form-control "
                                           value="{{ $product->name }}" required>
                                </div>
                                <div class="form">
                                    <div class="form-group col">
                                        <label for="discount_price">Prix initial</label> <span
                                                class="text-danger">*</span>
                                        <input id="discount_price" type="text" name="discount_price"
                                               class="form-control {{ $errors->has('discount_price') ? " is-invalid " : '' }}"
                                               value="{{ old('discount_price', $shopproduct->discount_price) }}">
                                        @error('discount_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="inlineRadio1">R??duction Yummy</label> <span
                                                class="text-danger">*</span>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="0.80" name="reduction"
                                                   id="inlineRadio1">
                                            <label class="form-check-label" for="inlineRadio1">20%</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="0.70" name="reduction"
                                                   id="inlineRadio1">
                                            <label class="form-check-label" for="inlineRadio1">30%</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="0.60" name="reduction"
                                                   id="inlineRadio2">
                                            <label class="form-check-label" for="inlineRadio2">40%</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="0.50" name="reduction"
                                                   id="inlineRadio3">
                                            <label class="form-check-label" for="inlineRadio3">50%</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="0.40" name="reduction"
                                                   id="inlineRadio4">
                                            <label class="form-check-label" for="inlineRadio4">60%</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="0.30" name="reduction"
                                                   id="inlineRadio5">
                                            <label class="form-check-label" for="inlineRadio5">70%</label>
                                        </div>
                                    </div>
                                    <div class="form-group col">
                                        <label for="unit_price">Prix Yummy</label> <span class="text-danger">*</span>
                                        <input id="unit_price" type="text" name="unit_price"
                                               class="form-control {{ $errors->has('unit_price') ? " is-invalid " : '' }}"
                                               value="{{ old('unit_price', $product->unit_price) }}">
                                        @error('unit_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="unit_price">Quantit?? disponible</label> <span
                                                class="text-danger">*</span>
                                        <input id="unit_price" type="number" name="quantity"
                                               class="form-control {{ $errors->has('unit_price') ? " is-invalid " : '' }}"
                                               value="{{ old('quantity', $shopproduct->quantity) }}">
                                    </div>
{{--                                    <div class="form-group col" style="display:none">--}}
{{--                                        <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>--}}
{{--                                        <select id="status" name="status"--}}
{{--                                                class="form-control @error('status') is-invalid @enderror">--}}

{{--                                            @foreach(trans('statuses') as $key => $status)--}}
{{--                                                {{dd($key)}}--}}
{{--                                                <option value="{{ $key }}"--}}
{{--                                                        {{ (old('status', $product->status) == $key) ? 'selected' : '' }}>--}}
{{--                                                    {{ $status }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @error('status')--}}
{{--                                        <div class="invalid-feedback">--}}
{{--                                            {{ $message }}--}}
{{--                                        </div>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
                                </div>
                                <div class="form-group col">
                                    <label for="unit_price">Publier sur</label> <span class="text-danger">*</span>
                                    <input type="date" value="{{$product->publish}}" name="publish"
                                           class="form-control"
                                    >
                                </div>
                                <div class="form">
                                    <div class="form-group col">
                                        <label for="hdispoa">Heure d??but</label> <span class="text-danger">*</span>
                                        <input id="hdispoa" type="text" name="hdispoa"
                                               value="{{ old('hdispoa', $shopproduct->hdispoa) }}"
                                               class="timepicker form-control {{ $errors->has('hdispoa') ? " is-invalid " : '' }}">
                                    </div>
                                    <div class="form-group col">
                                        <label for="hdispob">Heure fin</label> <span class="text-danger">*</span>
                                        <input id="hdispob" type="text" name="hdispob"
                                               value="{{ old('hdispob', $shopproduct->hdispob) }}"
                                               class="timepicker form-control {{ $errors->has('hdispob') ? " is-invalid " : '' }}">
                                    </div>
                                </div>
                                <div class="form">
                                    <div class="form-group col">
                                        <label for="description">Ce que votre client peut avoir</label>
                                        <textarea name="description"
                                                  class="summernote-simple form-control height-textarea @error('description')
                                                          is-invalid @enderror" id="description">
                                            {{ old('description', $product->description) }}
                                        </textarea>
                                        @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col {{ $errors->has('document') ? 'has-error' : '' }}">
                                        <label for="document"> {{ __('Image') }} (525 * 329)
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="file" name="image" class="form-control"> @error('document')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer ">
                                <button class="btn btn-primary btn-block mr-1"
                                        type="submit">{{ __('Mettre ?? jour') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/summernote/summernote-bs4.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.js"
            integrity="sha512-PC6BMUJfhXSSRw6fOnyfn21Yjc/6oRUnAGUboA+uzAUkKX5K2wzUvTHPCEjfwmmfrjCuiSnf23iX8JYVlJTXmA=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.time.js"
            integrity="sha512-wsTBGzc0ra42jNgXre39rdHpXqAkkaSN+bRrXZ3hpOvqxOtLNZns3OseDZRfGCWSs00N9HuXyKHZEzKAWCl3SA=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/translations/fr_FR.js"
            integrity="sha512-oppWtIxLpE9C9k/RJ/+z8pZXIh2PIuYDYsklCWMFsoTxK2bRMJ9Y86rvVZ20NkOBsjrywgEIi/tibOxJk7cXmg=="
            crossorigin="anonymous"></script>
    <script src="{{ asset('js/product/edit.js') }}"></script>
    <script>
        $("input[type=radio]").click(function () {
            var total = 0;
            $("input[type=radio]:checked").each(function () {
                total += parseFloat($(this).val()) * document.getElementById("discount_price").value;
            });
            let res = Math.round(total * 100) / 100
            console.log(res);
            $("#unit_price").val(res);
        });
    </script>
    <script type="text/javascript">
        $('.timepicker').pickatime({
            format: 'HH:i',
            formatSubmit: 'HH:i',
            hiddenName: true,
        });
        var uploadedDocumentMap = {};
        Dropzone.options.documentDropzone = {
            url: '{{ route('admin.products.updateMedia', $product) }}',
            maxFilesize: 2, // MB
            maxFiles: 5,
            acceptedFiles: "image/jpeg, image/png, image/jpg",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="document[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.products.removeMedia') }}',
                    data: {"id": {{ $product->id }}, '_token': "{{ csrf_token() }}", "media": file.name},
                    success: function (data) {
                        $('#document-dropzone').children().remove();
                        var dataArr = JSON.parse(data);
                        $.each(dataArr, function (key, value) {
                            var mockFile = {name: value.name, size: value.size};
                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.url);
                            $('form').append('<input type="hidden" data-browse="' + value.id + '" name="document[]" value="' + value.name + '">');
                        });
                    }
                });
            },
            init: function () {
                thisDropzone = this;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.products.getMedia') }}',
                    data: {"id": {{ $product->id }}, '_token': "{{ csrf_token() }}"},
                    success: function (data) {
                        var dataArr = JSON.parse(data);
                        $.each(dataArr, function (key, value) {
                            var mockFile = {name: value.name, size: value.size};
                            thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                            thisDropzone.options.thumbnail.call(thisDropzone, mockFile, value.url);
                            $('form').append('<input type="hidden" data-browse="' + value.id + '" name="document[]" value="' + value.name + '">');
                        });
                    }
                });
            }
        }
    </script>
    <script>
        function categorychange(elem) {
            $('.category').html('<option></option>');
            event.preventDefault();
            let id = elem.value;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{route('fetchmaincategory')}}",
                type: "POST",
                data: {
                    id: id,
                    _token: _token
                },
                success: function (response) {
                    $.each(response, function (i, item) {
                        $('.category').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                },
            });
        }

        function subcategorychange(elem) {
            $('.subcategory').html('<option></option>');
            event.preventDefault();
            let id = elem.value;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{route('fetchsubcategory')}}",
                type: "POST",
                data: {
                    id: id,
                    _token: _token
                },
                success: function (response) {
                    $.each(response, function (i, item) {
                        $('.subcategory').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });
                },
            });
        }
    </script>
@endsection
