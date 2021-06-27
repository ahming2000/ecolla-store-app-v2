@extends('en.layouts.app')

@section('title')
    下单成功 | Ecolla ε口乐
@endsection

@section('content')
    <main class="container">

        <div class="row">


            <div class="col-xs-12 col-sm-8 offset-sm-2">
                <div class="row mb-3 justify-content-center align-items-center">
                    <img class="img-fluid" src="{{ asset('img/order-successful.png') }}" style="height: 150px;" />
                </div>

                <div class="row mb-3">
                    <div class="col-12 text-center">
                        Order Successfully!<br>
                        <span class="text-muted">Thank you for your support!<br>We will process your order ASAP!</span><br>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-sm-12 col-md-6 lime lighten-3 text-center mx-auto p-3 mb-2">
                        <b>{{ session('orderCode') }}</b>
                    </div>
                    <div class="col-12 text-center">Order Tracking ID</div>
                </div>

                <div class="row justify-content-center align-items-center">
                    <div class="d-flex mx-1">
                        <button type="button" class="btn btn-primary btn-block" onclick="goToOrderTracking()">Track Your Order</button>
                        <button type="button" class="btn btn-primary btn-block" onclick="goToItemList()">Browse More Item</button>
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
