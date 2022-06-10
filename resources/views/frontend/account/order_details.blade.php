@extends('frontend.layouts.default')
@section('frontend.content')

<div id="invoice-print">
<article class="card">
    <header class="card-header"> {{ __('message.tracking') }} </header>
    <div class="card-body">
        <h6>{{ __('message.orderr') }}  #{{ $order->order_code }}  <span class="float-right"><strong > {{ __('message.date') }} </strong>{{ $order->created_at->format('d M Y, h:i A') }}</span></h6>
        <article class="card">
            <div class="card-body row no-gutters">
                <div class="col">
                    <strong>{{ __('message.billing') }}:</strong>
                    <br> {{ __('message.name') }}:  {{ $order->user->name ?? '' }}
                    <br>{{ __('message.phone') }} :  {{ $order->user->phone ?? '' }}
                    <br>{{ __('message.address') }}   {{ $order->user->address ?? '' }}<br>
                </div>
                <div class="col">
                    <strong>{{ __('message.shipping') }}</strong>
                    <br> {{ __('message.phone') }}  :{{ $order->mobile ?? '' }}
                    <br>{{ __('message.address') }}  {{ $order->address ?? '' }}
                </div>
                <div class="col">
                    <strong>{{ __('message.status') }}</strong>
                    <br>{{ __('message.save') }} {{__('Payment Status')}}:  {{ trans('payment_status.' . $order->payment_status) ?? null }}
                    <br> {{ __('message.save') }}{{__('Payment Method')}}:  {{  trans('payment_method.' . $order->payment_method) ?? null }}<br>
                </div>
            </div>
        </article>

        <div class="tracking-wrap">
            @if($order->status == \App\Enums\OrderStatus::CANCEL)
                <div class="step active">
                    <span class="icon"> <i class="fa fa-times"></i> </span>
                    <span class="text">{{ __('message.cancel') }}</span>
                </div>
            @else
                <div class="step {{ $order->status >= \App\Enums\OrderStatus::PENDING ? 'active' : ''}}">
                    <span class="icon"> <i class="fa fa-circle-notch"></i> </span>
                    <span class="text">{{ __('message.pending') }}</span>
                </div>
            @endif

            @if($order->status == \App\Enums\OrderStatus::REJECT)
                <div class="step active">
                    <span class="icon"> <i class="fa fa-times"></i> </span>
                    <span class="text">{{ __('message.reject') }}</span>
                </div>
            @else
                <div class="step {{ $order->status >= \App\Enums\OrderStatus::ACCEPT ? 'active' : ''}}">
                    <span class="icon"> <i class="fa fa-check"></i> </span>
                    <span class="text">{{ __('message.accept') }}</span>
                </div>
            @endif


            <div class="step {{  $order->status >= \App\Enums\OrderStatus::PROCESS ? 'active' : ''}}">
                <span class="icon"> <i class="fa fa-shopping-bag"></i> </span>
                <span class="text">{{ __('message.process') }}</span>
            </div> <!-- step.// -->
            <div class="step {{  $order->status >= \App\Enums\OrderStatus::ON_THE_WAY ? 'active' : ''}}">
                <span class="icon"> <i class="fa fa-truck"></i> </span>
                <span class="text"> {{ __('message.on') }}</span>
            </div> <!-- step.// -->
            <div class="step {{  $order->status == \App\Enums\OrderStatus::COMPLETED ? 'active' : ''}}">
                <span class="icon"> <i class="fa fa-box"></i> </span>
                <span class="text">{{ __('message.complete') }} </span>
            </div> <!-- step.// -->
        </div>

        <hr>
        <ul class="row">
            @foreach($order->items as $item)
            <li class="col-md-4">
                <figure class="itemside  mb-3">
                    <div class="aside"><img src="{{ $item->product->images }}" class="img-sm border"></div>
                    <figcaption class="info align-self-center">
                        <p class="title">{{$item->product->name}}</p>
                        <span class="text-muted">{{ currencyFormat($item->unit_price) }} </span>
                    </figcaption>
                </figure>
            </li>
            @endforeach
        </ul>
    </div> <!-- card-body.// -->
</article>
<article class="card mt-3">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                </div>
            @endif

            <div class="tab-content" id="v-pills-tabContent">
                <table class="table">
                    <thead style="background-color:#3167eb">
                    <tr style="color:white">
                        <th>{{ __('message.item') }}</th>
                        <th class="text-center">{{ __('message.price') }}</th>
                        <th class="text-center">{{ __('message.quantity') }}</th>
                        <th class="text-right">{{ __('message.totals') }}</th>
                    </tr>
                    </thead>
                    @foreach($order->items as $item)
                        <tbody>
                        <tr>
                            <th scope="row">{{ $item->product->name }}</th>
                            <td class="text-center">{{ currencyFormat($item->unit_price) }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">{{ currencyFormat($item->item_total) }}</td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>

                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th class="text-right"></th>
                        <th class="text-right">{{ __('message.subtotal') }}</th>
                    </tr>
                    <tr>
                        <th scope="col">{{ __('message.order_status') }}  : {{ trans('order_status.'.$order->status) }}</th>
                        <th scope="col"></th>
                        <th class="text-right"></th>
                        <td class="text-right">{{ currencyFormat($order->sub_total) }}</td>
                    </tr>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th class="text-right"></th>
                        <th class="text-right">{{ __('message.delivery') }}</th>
                    </tr>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th class="text-right"></th>
                        <td class="text-right">{{ currencyFormat($order->delivery_charge) }}</td>
                    </tr>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th class="text-right"></th>
                        <th class="text-right">{{ __('message.total') }}</th>
                    </tr>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th class="text-right"></th>
                        <td class="text-right">{{ currencyFormat($order->total) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div> <!-- card-body .// -->
    </article> <!-- card.// -->
<!-- container .//  -->
</div>
<div class="container">
    <div class="row">
        @if($order->status == \App\Enums\OrderStatus::PENDING)
            <div class="col">
                <a href="{{ route('account.order.cancel', $order) }}" class="btn btn-danger m-2"
                   onclick="return confirm({{ __('message.sure') }})"><i
                        class="fa fa-times"></i> {{ __('message.cancel') }}</a>
            </div>
        @endif

        @if($order->attachment)
            <div class="text-right">
                <a class="btn btn-info m-2" href="{{ route('account.order.file', $order->id) }}"><i
                        class="fa fa-arrow-circle-down"></i> {{ __('message.download') }}</a>
            </div>
        @endif
        <div class="@if(!$order->attachment) col @endif text-right">
            <button onclick="printDiv('invoice-print')" class="btn btn-warning m-2"><i
                    class="fa fa-print"></i>{{ __('message.print') }}</button>
        </div>
    </div>
</div>
@endsection
