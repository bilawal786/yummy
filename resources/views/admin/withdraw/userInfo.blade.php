@if(!blank($user))
    <div class="card profile-widget margin-hidden">
        <div class="profile-widget-header">
            <img alt="image" src="{{ $user->images }}" class="rounded-circle profile-picture center ">
        </div>
        <div class="profile-widget-description">
            <dl class="row">
                <dt class="col-sm-5">{{ __('Name') }} <strong class="float-right">:</strong></dt>
                <dd class="col-sm-7">{{ $user->name }}</dd>
                <dt class="col-sm-5">{{ __('Phone') }} <strong class="float-right">:</strong></dt>
                <dd class="col-sm-7">{{ $user->phone }}</dd>
                <dt class="col-sm-5">{{ __('Email') }} <strong class="float-right">:</strong></dt>
                <dd class="col-sm-7">{{ $user->email }}</dd>
                @if($user->myrole == \App\Enums\UserRole::DELIVERYBOY)
                    <dt class="col-sm-5">{{ __('Order Balance') }} <strong class="float-right">:</strong></dt>
                    <dd class="col-sm-7">{{ currencyFormat($user->deliveryBoyAccount->balance) }}</dd>
                @endif
                <dt class="col-sm-5">{{ __('Credit') }} <strong class="float-right">:</strong></dt>
                <dd class="col-sm-7">{{ currencyFormat($user->balance->balance > 0 ? $user->balance->balance : 0 ) }}</dd>
                <dt class="col-sm-5">{{ __('Address') }} <strong class="float-right">:</strong></dt>
                <dd class="col-sm-7">{{ $user->address }}</dd>
                <dt class="col-sm-5">{{ __('Status') }} <strong class="float-right">:</strong></dt>
                <dd class="col-sm-7">{{ $user->mystatus }}</dd>
            </dl>
        </div>
    </div>
@endif
