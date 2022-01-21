@extends('admin.layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css') }}">
    <style type="text/css">
        input[name="unit_price"] {
            pointer-events: none;
        }
        .select2-container {
            box-sizing: border-box;
            display: inline-block;
            margin: 0;
            position: relative;
            vertical-align: middle;
            width: 100% !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/classic.css" integrity="sha512-vd5p9dyk1WVulhnr0xGEie0QVqDQfErKknlJ9k8UyK9ZZFGR95r3cfLr+NZAkex0FHAlfUG6A284s9ofTW4rTw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/themes/classic.time.css" integrity="sha512-Ye2PnTA5KFgQC9x/VoMRaJbiJpAPnc00zmVPar9/FNOBwdhIPYCUY2z6WUtduWp12ZE+lWlM53yQPQM2DlPxqQ==" crossorigin="anonymous" />
@endsection

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Notifications') }}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form action="{{ route('admin.notification.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form">
                                    <div class="col">
                                        <label>Region</label> <span class="text-danger">*</span>
                                        <select name="country_id" class="form-control" id="">
                                            @foreach($locations as $loc)
                                                <option value="{{$loc->id}}">{{$loc->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form">
                                    <div class="col">
                                        <label>Utilisateurs</label> <span class="text-danger">*</span>
                                        <select name="type" class="form-control getusertype" id="">
                                                <option value="3">Commerçant</option>
                                                <option value="2">Clients</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body trader">
                                <div class="form">
                                    <div class="col">
                                        <label>Commerçant</label> <span class="text-danger">*</span>
                                        <select name="user_id[]" multiple="" class="form-control select2" id="">
                                            <option value="send_to_all">Envoyer à tous</option>
                                            @foreach($traders as $trader)
                                                <option value="{{$trader->id}}">{{$trader->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="clients">
                                <div class="card-body">
                                    <div class="form">
                                        <div class="col">
                                            <label>Clients</label> <span class="text-danger">*</span>
                                            <select name="user_id[]" multiple="" class="form-control select2" id="">
                                                <option value="send_to_all">Envoyer à tous</option>
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form">
                                    <div class="col">
                                        <label>Notification</label> <span class="text-danger">*</span>
                                        <textarea name="message" class="form-control"  id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary btn-block mr-1" type="submit">{{ __('Enregistrer') }}</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.js" integrity="sha512-PC6BMUJfhXSSRw6fOnyfn21Yjc/6oRUnAGUboA+uzAUkKX5K2wzUvTHPCEjfwmmfrjCuiSnf23iX8JYVlJTXmA==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/compressed/picker.time.js" integrity="sha512-wsTBGzc0ra42jNgXre39rdHpXqAkkaSN+bRrXZ3hpOvqxOtLNZns3OseDZRfGCWSs00N9HuXyKHZEzKAWCl3SA==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pickadate.js/3.6.4/translations/fr_FR.js" integrity="sha512-oppWtIxLpE9C9k/RJ/+z8pZXIh2PIuYDYsklCWMFsoTxK2bRMJ9Y86rvVZ20NkOBsjrywgEIi/tibOxJk7cXmg==" crossorigin="anonymous"></script>
    <script>
        $(".clients").hide();
        $("input[type=radio]").click(function() {
            var total = 0;
            $("input[type=radio]:checked").each(function() {
                total += parseFloat($(this).val())*document.getElementById("discount_price").value;
            });
            let res = Math.round(total * 100) / 100
            console.log(res);
            $("#unit_price").val(res);
        });
        $(".getusertype").change(function() {
           var val = $(this).val();
           if(val == '2'){
               $(".clients").show();
               $(".trader").hide();
           }else {
               $(".clients").hide();
               $(".trader").show();
           }
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
            url: '{{ route('admin.products.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles:5,
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
                    for (var i in files) {
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
