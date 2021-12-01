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
                                {{ $totalOrders->count() }}
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
                                {{ $totalCompleteOrders->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
						@endif
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
										 <div id="earningGraph"></div>
									 </div>
							 </div>
					 </div>
				</div>

    </section>

@endsection

@section('scripts')
	<script src="{{ asset('assets/modules/highcharts/highcharts.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/highcharts-more.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/data.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/drilldown.js') }}"></script>
	<script src="{{ asset('assets/modules/highcharts/exporting.js') }}"></script>
	@include('vendor.installer.update.OrderIncomeGraph')
@endsection
