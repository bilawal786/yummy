@extends('admin.layouts.master')

@section('main-content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Profile') }}</h1>
            {{ Breadcrumbs::render('profile') }}
        </div>
        <div class="section-body">
            <div class="row mt-sm-12">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card profile-widget">

                            <div class="row">
                                <div class="ol-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <form action="{{ route('admin.bank.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-body">
                                            <div class="form">
                                                <div class="form-group col">
                                                    <label for="location">Nom de la compagnie</label> <span
                                                        class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="company_name" value="{{$user->company_name}}">
                                                </div>
                                                <div class="form-group col">
                                                    <label for="location">Iban</label> <span
                                                        class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="iban" value="{{$user->iban}}">
                                                </div>
                                                <div class="form-group col">
                                                    <label for="location">Siret</label> <span
                                                        class="text-danger">*</span>
                                                    <input type="text" class="form-control" name="siret" value="{{$user->siret}}">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card-footer ">
                                            <button class="btn btn-primary btn-block mr-1" type="submit">{{ __('Enregistrer') }}</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/profile/index.js') }}"></script>
@endsection

