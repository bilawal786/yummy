@extends('admin.layouts.master')

@section('main-content')
	<section class="section">
        <div class="section-header">
            <h1>{{ __('Tableau de bord') }}</h1>
        </div>

        @if(auth()->user()->myrole == \App\Enums\UserRole::ADMIN)
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-paper-plane"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Nombre de commandes') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalOrders->count() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Nombre d\'utilisateurs') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUsers->count() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-university"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Nombre de boutique') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalShops->count() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Total des revenus') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ number_format($totalIncome, 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(auth()->user()->myrole == \App\Enums\UserRole::SHOPOWNER)
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-plus-square"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Nombre de Commandes') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $vendororders }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-star"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Revenu total') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $vendorincome }} €
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ __('Commande Récupéré') }}</h4>
                            </div>
                            <div class="card-body">
                                {{ $vendor_orders_complete }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        @endif

        @if(auth()->user()->myrole == \App\Enums\UserRole::ADMIN || auth()->user()->myrole == \App\Enums\UserRole::SHOPOWNER)
		<div class="row">
							<div class="col-md-6">
									<div class="card">
											<div class="card-header">
													<h4>{{ __('Commandes récente') }} <span class="badge badge-primary">{{ $recentOrders->count() }}</span></h4>
													<div class="card-header-action">
															<a href="{{ route('admin.orders.index') }}" class="btn btn-primary">{{ __('Voir Plus') }} <i class="fas fa-chevron-right"></i></a>
													</div>
											</div>
											<div class="card-body p-0">
													<div class="table-responsive table-invoice">
															<table class="table table-striped">
																	<tr>
																			<th>{{ __('Nom') }}</th>
																			<th>{{ __('Statut') }}</th>
																			<th>{{ __('Total') }}</th>
																			<th>{{ __('Action') }}</th>
																	</tr>
																	@if(!blank($recentOrders))
																		@foreach($recentOrders as $order)
																				@if($loop->index > 4) {
																					@break
																				@endif
																			<tr>
																					<td>{{ $order->user->name }}</td>
																					<td>{{ trans('order_status.' . $order->status) }}</td>
																					<td>{{ number_format($order->total, 2) }}</td>
																					<td>
																							<a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-icon btn-primary"><i class="far fa-eye"></i></a>
																					</td>
																			</tr>
																	@endforeach
															@endif
															</table>
													</div>
											</div>
									</div>
							</div>
							<div class="col-md-6">
								 <div class="card">
									 <div class="card-body">
                                         <p><b>Graphique des revenus</b></p>

                                         <canvas id="myChart" style="width:100%;max-width:100%"></canvas>

                                     </div>
							 </div>
					 </div>
				</div>
        @endif
    </section>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

    <script src="{{ asset('assets/modules/highcharts/highcharts.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/highcharts-more.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/data.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/drilldown.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/exporting.js') }}"></script>
	@include('vendor.installer.update.OrderIncomeGraph')
    <?php
    $year = date("Y");


    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '1')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $jan = 0;
    }else{
        $jan =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '2')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $feb = 0;
    }else{
        $feb =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '3')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $mar = 0;
    }else{
        $mar =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '4')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $apr = 0;
    }else{
        $apr =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '5')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $may = 0;
    }else{
        $may =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '6')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $jun = 0;
    }else{
        $jun =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '7')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $jul = 0;
    }else{
        $jul =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '8')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $aug = 0;
    }else{
        $aug =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '9')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $sep = 0;
    }else{
        $sep =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '10')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $oct = 0;
    }else{
        $oct =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '11')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $nov = 0;
    }else{
        $nov =  $cat->sum('total');
    }

    $cat = App\Models\Order::orderOwner()->whereMonth('created_at', '12')->whereYear('created_at', $year)->where('status', 20)->get();
    if ($cat == null){
        $dec = 0;
    }else{
        $dec =  $cat->sum('total');
    }
    ?>
    <script>
        var xValues = ['jan','feb','mar','avr','mai','jui','juil','août','sep','oct', 'nov', 'déc'];

        new Chart("myChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    data: [{{$jan}}, {{$feb}}, {{$mar}}, {{$apr}}, {{$may}}, {{$jun}}, {{$jul}}, {{$aug}}, {{$sep}}, {{$oct}}, {{$nov}}, {{$dec}}],
                    borderColor: "red",
                    fill: false
                }]
            },
            options: {
                legend: {display: false}
            }
        });
    </script>
@endsection
