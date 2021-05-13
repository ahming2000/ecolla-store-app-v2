@extends('en.layouts.customer')

@section('title')
    Payment Method | Ecolla ε口乐
@endsection

@section('content')
    <main class="container">
        <div class="row">
            <div class="col-sm-12 col-md-8 offset-md-2">
                <h1 class="mt-4 mb-3">Payment Method</h1>
                <p>We accept these payment method</p>

                @foreach($payments as $payment)
                    <div class="row shadow payment-method p-3 m-2 mx-auto">
                        <input type="hidden" value="{{ $payment['code'] }}" class="code">
                        <div class="col-6 col-md-3 col-sm-6">
                            <img src="{{ asset('img/payment/icon/' . $payment['code'] . '.png') }}"
                                 alt="image"
                                 height="100"
                                 width="100">
                        </div>
                        <div class="col-6 col-md-9 col-sm-6 pt-4">
                            <h5>{{ $payment['name'] }}</h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection

@section('extraScriptEnd')
    <script>
        $(document).ready(function () {
            $(".payment-method").on("click", function () {
                let code = jQuery(this).find('.code').val();
                let url = "{{ asset('img/payment')}}/qr/" + code + ".jpeg";
                window.open(url, 'Image', 'width=400px, height=400px, resizable=1');
            });
        });
    </script>
@endsection
