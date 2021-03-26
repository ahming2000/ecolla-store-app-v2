@extends('ch.layouts.customer')

@section('title')
    Payment Method | Ecolla ε口乐
@endsection

@section('cartCount')
    0
@endsection

@section('content')
    <main class="flex-fill"> <!--put content-->
        <div class="container">
            <h1 class="mt-4 mb-3">Payment Method</h1>
            <p>We accept these payment method</p>

            <div class="row shadow p-3 m-2 mx-auto">
                <div class="col-6 col-md-3 col-sm-6">
                    <img src="{{ asset('img/payment/tng.png') }}" alt="image" height="100" width="100">
                </div>
                <div class="col-6 col-md-9 col-sm-6 pt-4">
                    <h5>Touch 'n Go</h5>
                </div>
            </div>

            <div class="row shadow p-3 m-2 mx-auto">
                <div class="col-6 col-md-3 col-sm-6">
                    <img src="{{ asset('img/payment/boost.png') }}" alt="image" height="100" width="100">
                </div>
                <div class="col-6 col-md-9 col-sm-6 pt-4">
                    <h5>Boost</h5>
                </div>
            </div>

            <div class="row shadow p-3 m-2 mx-auto">
                <div class="col-6 col-md-3 col-sm-6">
                    <img src="{{ asset('img/payment/bank-transfer.png') }}" alt="image" height="100" width="100">
                </div>
                <div class="col-6 col-md-9 col-sm-6 pt-4">
                    <h5>Bank Transfer</h5>
                </div>
            </div>
        </div>
    </main>
@endsection
