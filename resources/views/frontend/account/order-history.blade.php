@extends('frontend.layouts.mobile')
@section('main-content')
<div class="page-content-wrapper py-3">
  @if (session('status'))
      <div class="alert alert-success" role="alert">
          {{ session('status')}}
      </div>
  @endif
      <div class="container">
          <small><b>{{ __('message.noter') }} </b></small>
        <div class="cart-wrapper-area py-3">
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
              <table class="table mb-0">
                <tbody>
                  @foreach($orders as $order)
                     <?php
                     $time = $order->created_at->diffInHours(Carbon\Carbon::now(), false);
                      ?>
                  <tr>
                    <td>
                      <a href="{{route('account.order.show', $order->id)}}"><img src="{{ $order->shop->images??"" }}"></a>
                    </td>
                    <td><a href="{{route('account.order.show', $order->id)}}">{{ $order->shop->name??"" }}<span>{{ count($order->items) }} x article(s) - {{$order->total}}€ </span>
                      @php
                      \Carbon\Carbon::setlocale('fr');
                      @endphp
                        </a>
                      <span>{{ \Carbon\Carbon::parse($order->created_at)->translatedformat('d M')}}
                          <p class="badge @if($order->status == 20) bg-success @elseif($order->status == 10) bg-danger @else bg-warning @endif ms-1">{{trans('order_status.' . $order->status)}}</p></span>
                       @if($order->status == 10)
                        @else
                            <br>
                        @if($order->deliverytime)
                           <small>{{ __('message.sera') }}  <b>{{$order->deliverytime}}</b> </small>
                            @endif
                       @if($time<2)
                        <a href="{{route('front.order.cancel', ['id' => $order->id])}}"><span style="color: white!important;" class="badge bg-danger float-right">{{ __('message.annuler') }}</span></a>
                        @endif
                        @endif
                    </td>

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
@endsection
