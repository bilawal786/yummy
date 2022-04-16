@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <style type="text/css">
        input[name="unit_price"] {
            pointer-events: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/classic.css"
          integrity="sha512-vd5p9dyk1WVulhnr0xGEie0QVqDQfErKknlJ9k8UyK9ZZFGR95r3cfLr+NZAkex0FHAlfUG6A284s9ofTW4rTw=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/classic.time.css"
          integrity="sha512-Ye2PnTA5KFgQC9x/VoMRaJbiJpAPnc00zmVPar9/FNOBwdhIPYCUY2z6WUtduWp12ZE+lWlM53yQPQM2DlPxqQ=="
          crossorigin="anonymous"/>
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
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form">
                                    @if(auth()->user()->myrole != 3)
                                        <div class="form-group col">
                                            <label for="shop_id">Magasin</label> <span class="text-danger">*</span>
                                            <select required id="shop_id" name="shop_id"
                                                    class="form-control @error('shop_id') is-invalid @enderror">
                                                @foreach($shops_list as $shopss)
                                                    <option value="{{ $shopss->id }}">{{ $shopss->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    @endif
                                    <div class="form-group col">
                                        <label for="location">Localisation</label> <span
                                                class="text-danger">*</span>
                                        <select required onchange="categorychange(this)" name="location_id"
                                                id="location"
                                                class="select2 form-control @error('location_id') is-invalid red-border @enderror"
                                                data-url="{{ route('admin.shop.get-area') }}">
                                            <option value="">{{ __('Choisir une localisation') }}</option>
                                            @if(!blank($locations))
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}"
                                                    >
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
                                        <select id="categories" name="categories[]"
                                                class="category form-control select2 {{ $errors->has('categories') ? " is-invalid " : '' }}"
                                                required>

                                        </select>
                                        @if ($errors->has('categories'))
                                            <div class="invalid-feedback">
                                                <strong>{{ $errors->first('categories') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                <!--                                    <div class="form-group col">
                                        <label for="categories">{{ __('Sous-catégorie') }}</label> <span
                                                class="text-danger"></span>
                                        <select id="categories" name="subcategory"
                                                class="subcategory form-control select2">

                                        </select>
                                    </div>-->
                                    <div class="form-group col">
                                        <label for="name">Nom du panier</label> <span
                                                class="text-danger">*</span>
                                        <input id="name" type="text" name="name"
                                               class="form-control {{ $errors->has('name') ? " is-invalid " : '' }}"
                                               value="{{ old('name') }}" required>
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>


                                </div>
                                <div class="form">
                                    <div class="form-group col">
                                        <label for="discount_price">Prix initial</label> <span
                                                class="text-danger">*</span>
                                        <input required id="discount_price" type="text" name="discount_price"
                                               class="form-control {{ $errors->has('discount_price') ? " is-invalid " : '' }}"
                                               value="{{ old('discount_price') }}">
                                        @error('discount_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="inlineRadio1">Réduction Yummy</label> <span
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
                                        <input required id="unit_price" type="text" name="unit_price"
                                               class="form-control {{ $errors->has('unit_price') ? " is-invalid " : '' }}"
                                               value="{{ old('unit_price') }}">
                                        @error('unit_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group col">
                                        <label for="unit_price">Quantité disponible</label> <span
                                                class="text-danger">*</span>
                                        <input required id="unit_price" type="number" name="quantity"
                                               class="form-control {{ $errors->has('quantity') ? " is-invalid " : '' }}">
                                    </div>
                                    <div class="form-group col">
                                        <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                        <select id="status" name="status"
                                                class="form-control @error('status') is-invalid @enderror">
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
                                <div class="form-group col">
                                    <label for="unit_price">Publier sur</label> <span class="text-danger">*</span>
                                    <input required type="date" name="publish"
                                           class="form-control"
                                    >
                                </div>
                                <div class="form">
                                    <div class="form-group col">
                                        <label for="hdispoa">Heure début</label> <span class="text-danger">*</span>
                                        <input required id="hdispoa" type="time" name="hdispoa"
                                               class="timepicker form-control {{ $errors->has('hdispoa') ? " is-invalid " : '' }}">
                                    </div>
                                    <div class="form-group col">
                                        <label for="hdispob">Heure fin</label> <span class="text-danger">*</span>
                                        <input required id="hdispob" type="time" name="hdispob"
                                               class="timepicker form-control {{ $errors->has('hdispob') ? " is-invalid " : '' }}">
                                    </div>
                                </div>
                                <div class="form">
                                    <div class="form-group col">
                                        <label for="description">{{ __('levels.description') }}</label>
                                        <textarea name="description"
                                                  class="summernote-simple form-control height-textarea @error('description')
                                                          is-invalid @enderror"
                                                  id="description">
                                            {{ old('description') }}
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
                                        type="submit">{{ __('Enregistrer') }}</button>
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
    <script src="{{ asset('js/product/create.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.js"
            integrity="sha512-PC6BMUJfhXSSRw6fOnyfn21Yjc/6oRUnAGUboA+uzAUkKX5K2wzUvTHPCEjfwmmfrjCuiSnf23iX8JYVlJTXmA=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.time.js"
            integrity="sha512-wsTBGzc0ra42jNgXre39rdHpXqAkkaSN+bRrXZ3hpOvqxOtLNZns3OseDZRfGCWSs00N9HuXyKHZEzKAWCl3SA=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/translations/fr_FR.js"
            integrity="sha512-oppWtIxLpE9C9k/RJ/+z8pZXIh2PIuYDYsklCWMFsoTxK2bRMJ9Y86rvVZ20NkOBsjrywgEIi/tibOxJk7cXmg=="
            crossorigin="anonymous"></script>
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
    <script type="text/javascript">
        $('.timepicker').pickatime({
            format: 'HH:i',
            formatSubmit: 'HH:i',
            hiddenName: true,
        });
        var uploadedDocumentMap = {};
        Dropzone.options.documentDropzone = {
            url: '{{ route('admin.products.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 5,
            acceptedFiles: "image/jpeg, image/png, image/jpg",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                $('form').append('<input type="hidden" name="image" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function (file) {
                file.previewElement.remove();
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedDocumentMap[file.name]
                }
                $('form').find('input[name="document[]"][value="' + name + '"]').remove()
            },
            init: function () {
                @if(isset($product) && $product->products)
                var files =
                        {!! json_encode($product->products) !!}
                        for(
                var i
            in
                files
            )
                {
                    var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
                }
                @endif
            }
        }
    </script>

@endsection
