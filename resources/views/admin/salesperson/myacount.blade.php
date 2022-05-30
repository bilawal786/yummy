@extends('admin.layouts.master')
<style>

    #footer h5 {
        display: inline-block;
    }
    #footer i {
        margin: 10px;
        font-size: 20px;

    }

</style>
@section('main-content')

    <section class="section">
        <div class="section-header">
            <h5>{{ __('Statue:') }}</h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @foreach($rank as $row)
            <div id="footer"><i class="fa fa-star  " style="color: {{$row->color}}" aria-hidden="true"></i><h5>{{$row->name }}</h5></div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @endforeach
        </div>
        <div class="section-header">
            <h5>{{ __('Bareme:') }}</h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @foreach($scale as $row)
                @if($row->rank_id===$user->rank_id)
            <h3 class="btn btn-primary">{{$row->title}}</h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                @endif
                    @endforeach
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="maintable"
                                >
                                    <thead>
                                    <tr>
                                        <th>{{ __('levels.id') }}</th>
                                        <th>{{ __('levels.name') }}</th>
                                        <th>{{ __('Adresse') }}</th>
                                        <th>{{ __('levels.location') }}</th>
                                        <th>{{ __('Date debute et fin') }}</th>
                                        <th>{{ __('Paniers') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($shops as $key=>$shop)

                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$shop->name}}</td>
                                        <td>{{$shop->address}}</td>
                                        <td>{{$shop->location->name}}</td>
                                        <td>{{$shop->location->name}}</td>
                                        <?php $total_basket = \App\Models\ShopProduct::where('shop_id','=',$shop->id)->count();?>
                                        <th style="color: red">{{$total_basket}}</th>
                                        <td><a href="{{route('admin.salesperson.basket', ['shop_id' => $shop->id])}}"
                                               class="btn btn-sm btn-icon float-left btn-primary ml-2"
                                               data-toggle="tooltip" data-placement="top" title="View"><i
                                                        class="far fa-eye"></i></a></td>
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
