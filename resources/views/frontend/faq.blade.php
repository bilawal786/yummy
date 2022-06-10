@extends('frontend.layouts.mobile')
@push('extra-style')
    <style>
        .accordion {
            background-color: #ffffff;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active, .accordion:hover {
            background-color: #ffffff;
        }

        .accordion:after {
            content: '\002B';
            color: #777;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }
    </style>
@endpush
@section('main-content')
    <div class="page-content-wrapper py-3">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q1') }}</button>
                    <div class="panel">
                        <p> {{ __('message.a1') }}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q2') }}</button>
                    <div class="panel">
                        <p> {{ __('message.a2') }} </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q3') }}</button>
                    <div class="panel">
                        <p> {{ __('message.a3') }}
                            (<a href="{{route('suggest.business')}}">{{ __('message.a31') }}</a>)
                            {{ __('message.a32') }}
                            (<a href="https://www.facebook.com/YummyBox.fr/">{{ __('message.a33') }}</a> {{ __('message.a34') }} <a href="https://instagram.com/yummybox.fr?utm_medium=copy_link">{{ __('message.a35') }}</a>)</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q4') }}</button>
                    <div class="panel">
                        <p> {{ __('message.a4') }} </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q5') }}</button>
                    <div class="panel">
                        <p> {{ __('message.a5') }} </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q6') }}</button>
                    <div class="panel">
                        <p> {{ __('message.a6') }}
                            (<a href="{{route('yummycoin')}}">{{ __('message.a61') }}</a>)</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q7') }}</button>
                    <div class="panel">
                        <p> {{ __('message.a7') }} </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q8') }}</button>
                    <div class="panel">
                        <p> {{ __('message.a8') }} </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q9') }}</button>
                    <div class="panel">
                        <p>
                            {{ __('message.a9') }} </p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q10') }}</button>
                    <div class="panel">
                        <p>{{ __('message.a10') }}</p>
                    </div>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-body">
                    <button class="accordion">{{ __('message.q11') }}</button>
                    <div class="panel">
                        <p>{{ __('message.a11') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer-js')
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>
@endsection
