@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header" style="">
            <h1>{{ __('Documents') }}</h1>
            {{ Breadcrumbs::render('customers') }}
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button"  class="btn btn-icon icon-left btn-primary " data-target="#rank" data-toggle="modal">{{ __('Ajouter un nouveau') }}</button>
                            <div class="modal" id="rank">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="


                                        art/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <?php ?>

                                                @if( Auth::user()->hasRole('Admin') )
                                                <div class="form-group">
                                                    <label>{{ __('Statut') }}</label> <span class="text-danger">*</span>
                                                    <select name="user_id" class="form-control select2">
                                                        <option >Sélectionnez le vendeurs</option>
                                                        <option value="all" >Tous  vendeurs</option>
                                                        @foreach($users as $key => $row)
                                                            <option value="{{$row->id}}" >{{ $row->first_name .' '. $row->last_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                @endif
                                                    @if( Auth::user()->hasRole('Sales Person') )
                                                <input type="hidden" name="admin" value="admin">
                                                    @endif
                                                <div class="form-group">
                                                    <label>{{ __('Document') }}</label> <span class="text-danger">*</span>
                                                   <input type="file"  class="form-control " name="file" >
                                                    @error('file')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>


                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary" >Submit</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable">
                                    <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>Identifiant de l'expéditeur</th>
                                        <th>{{ __('Document') }}</th>
                                        <th>{{ __('Créé à') }}</th>
                                        <th>{{ __('Action') }}</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($doc as $key => $row)
                                         <tr>
                                             <td>{{$key+1}}</td>
                                             <td>{{$row->sender->first_name .' ' . $row->sender->last_name  }}</td>
                                             <th><a href="{{ asset($row->file ?? ' ')  }}" class="btn btn-primary">Document</a></th>
                                             <?php
                                             \Carbon\Carbon::setLocale('fr');
                                             $date = \Carbon\Carbon::parse($row->created_at);
                                             ?>

                                             <td>{{$date->diffForHumans()}}</td>
                                             <td>      <a href="{{route('admin.delete.document', ['id' => $row->id])}}"
                                                          class="btn btn-sm btn-icon float-left btn-danger ml-2"
                                                          data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                             class="fa fa-trash"></i></a></td>
                                         </tr>
                                     @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection



@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script>
        "use strict";

        $(function () {
            var table = $('#maintable').DataTable({});

        });

        $('#maintable').on('draw.dt', function () {
            $('[data-toggle="tooltip"]').tooltip();
        })

    </script>
@endsection
