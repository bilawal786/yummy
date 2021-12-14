@extends('admin.layouts.master')
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
                                        <select name="type" class="form-control" id="">
                                                <option value="3">Commerçant</option>
                                                <option value="2">Clients</option>
                                        </select>
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
