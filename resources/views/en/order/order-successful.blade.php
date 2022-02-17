@extends('en.layouts.app')

@section('title')
    下单成功 | Ecolla ε口乐
@endsection

@section('content')
    <main class="container">

        <div class="row">


            <div class="col-xs-12 col-sm-8 offset-sm-2">
                <div class="row mb-3">
                    <div class="col-6 col-md-4 offset-3 offset-md-4">
                        <img class="img-fluid w-100" src="{{ asset('img/order-successful.png') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center mb-3">
                        Order Successfully!<br>
                        <span class="text-muted">Thank you for your support!<br>We will process your order ASAP!<br><a href="https://wa.link/2e1z4h" target="_blank">Click to contact stuff to confirm the order!</a></span><br>
                    </div>

                    <div class="col-12 col-md-6 offset-md-3 text-center">
                        {{ session('orderCode') }}
                    </div>

                    <div class="col-12 text-center mb-4">Order Tracking ID</div>

                    <div class="col-12 d-flex justify-content-center">
                        <button type="button" class="btn btn-primary mx-1" onclick="goToOrderTracking()">Track Your Order</button>
                        <button type="button" class="btn btn-primary mx-1" onclick="goToItemList()">Browse More Item</button>
                    </div>
                </div>

            </div>

        </div>

    </main>

@endsection

@section('script')
    <script>
        function goToOrderTracking() {
            window.location.href = "/en/order-tracking?code={{ session('orderCode') }}";
        }

        function goToItemList() {
            window.location.href = "/en/item";
        }
    </script>
@endsection
