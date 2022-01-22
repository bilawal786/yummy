@extends('admin.layouts.master')

@section('main-content')

    <section class="section">
        <div class="section-header">
            <h1>{{ __('Commandes') }}</h1>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print" id="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>{{ __('Facture') }}</h2>
                                <div class="invoice-number">#{{ $order->order_code }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>{{ __('Facturé à') }}:</strong><br>
                                        {{ $order->user->name ?? null }}<br>
                                        {{ __('Mobile : '). $order->user->phone ?? null }}<br>
                                        {{ $order->address }}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>{{ __('Date de la commande') }}:</strong><br>
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">{{ __('Résumé de la commande') }}</div>
                            <p class="section-lead">{{ __('Les éléments ici ne peuvent pas être supprimés.') }}</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">{{ __('#') }}</th>
                                        <th>{{ __('Item') }}</th>
                                        <th class="text-center">{{ __('Prix') }}</th>
                                        <th class="text-center">{{ __('Quantité') }}</th>
                                        <th class="text-right">{{ __('Total') }}</th>
                                    </tr>
                                    @foreach($items as $itemKey => $item)
                                        <tr>
                                            <td>{{ $itemKey+1 }}</td>
                                            <td>{{ $item->product->name ?? null }}</td>
                                            <td class="text-center">{{ $item->unit_price }}€</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-right">{{ $item->item_total }}€</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-4">
                                    @if($showStatus)
                                        <div class="section-title">{{ __('Modifier le statut') }}</div>
                                        <div class="order card">
                                            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="status">{{ __('Statut') }}</label> <span class="text-danger">*</span>
                                                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                                            <option value="0">{{ __('Sélectionnez le statut de la commande') }}</option>
                                                            @if(!blank($orderStatusArray))
                                                                @foreach($orderStatusArray as $key => $status)
                                                                    <option value="{{ $key }}" {{ (old('status', $order->status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('status')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="card-footer text-left">
                                                    <button class="btn btn-primary mr-1" type="submit">{{ __('Envoyer') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif

                                    @if($showReceive)
                                        <div class="section-title">{{ __('État de la commande') }}</div>
                                        <div class="order card">
                                            <form action="{{ route('admin.orders.product-receive', $order) }}" method="POST">
                                                @csrf
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label for="product_received">{{ __('La commade a été récupéré ?') }}</label> <span class="text-danger">*</span>
                                                        <select id="product_received" name="product_received" class="form-control @error('product_received') is-invalid @enderror">
                                                            <option value="10">{{ __('Récupéré') }}</option>
                                                            <option value="5">{{ __('Non Récupéré') }}</option>
                                                        </select>
                                                        @error('product_received')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="card-footer text-left">
                                                    <button class="btn btn-primary mr-1" type="submit">{{ __('Enregistrer') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-4 offset-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{ __('Sous Total') }}</div>
                                        <div class="invoice-detail-value">{{ $order->sub_total }}€</div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name"> {{ __('Total') }}</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">{{ $order->total }}€</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
