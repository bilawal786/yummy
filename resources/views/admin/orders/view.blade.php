@extends('admin.layouts.master')

@section('main-content')
    <section class="section">
        <div class="section-header">
                <div class="col-md-4">
                    <h1>{{ __('Commandes') }}</h1>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4" style="text-align: right">
                    @if($order->deliverytime)
                        <b>La commande sera livrée dans:</b> <h1>{{$order->deliverytime}}</h1>
                    @else
                    <form action="{{route('admin.deliverytime.update')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$order->id}}">
                        <b>Mettre à jour le délai de livraison:</b> <input name="deliverytime" type="time"> <input type="submit" value="Mettre à jour">
                    </form>
                        @endif
                </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print" id="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>{{ __('Facture') }}</h2>
                                    <div class="invoice-number">{{ __('Commande') }} #{{ $order->order_code }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        {{ $order->shop->name }}<br>
                                        {{ $order->shop->location->name ?? null }},
                                        {{ $order->shop->area->name ?? null }}<br>
                                        {{ $order->shop->address ?? null }}<br>
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>{{ __('Facturé à') }}:</strong><br>
                                        {{ $order->user->name ?? null }}<br>
                                        {{ __('Tel : '). $order->user->phone ?? null }}<br>
                                        {{ $order->address }}
                                    </address>

                                    <address>
                                        <strong>{{ __('Date de la commande') }}:</strong><br>
                                        {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y à H:i') }}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">{{ __('Récapitulatif') }}</div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">{{ __('#') }}</th>
                                        <th>{{ __('Produit') }}</th>
                                        <th class="text-center">{{ __('Prix') }}</th>
                                        <th class="text-center">{{ __('Quantité') }}</th>
                                        <th class="text-right">{{ __('Total') }}</th>
                                    </tr>
                                    @foreach($items as $itemKey => $item)
                                        <tr>
                                            <td>{{ $itemKey+1 }}</td>
                                            <td>{{ $item->product->name }}
                                                @php $options = $item->options ? json_decode($item->options) : []; @endphp
                                                @if(isset($options->variation) && !blank($options->variation))
                                                    <br>
                                                    <small><b>-- &nbsp;{{ $options->variation->name }}</b></small>
                                                @endif
                                                @if(isset($options->options) && !blank($options->options))
                                                    @foreach ($options->options as $option)
                                                        <br>
                                                        <small><span>--  &nbsp; &nbsp;{{ $option->name }}</span></small>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->unit_price }}€</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-right">{{ $item->item_total }}€</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="section-title">{{ __('État') }} : {{ trans('order_status.'.$order->status) }}</div>
                                    <div class="section-title">{{ __('Statut du paiement') }} : Payé</div>
                                    <div class="section-title">{{ __('Méthode de Paiement') }} : @if($order->payment_method == 20) Yummy Coin @else Paiement en ligne par carte @endif</div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">{{ __('Sous total') }}</div>
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
                <hr>
                <div class="text-md-right">
                    @if($order->attachment)
                        <a class="btn btn-info m-2" href="{{ route('admin.orders.order-file', $order->id) }}"><i class="fa fa-arrow-circle-down"></i> {{ __('Télécharger') }}</a>
                    @endif

                    <button onclick="printDiv('invoice-print')" class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> {{ __('Imprimer') }}</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/print.js') }}"></script>
@endsection
