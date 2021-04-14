@extends('ch.layouts.customer')

@section('title')
    下单成功 | Ecolla ε口乐
@endsection

@section('content')
    <main class="container">

        <div class="row">


            <div class="col-xs-12 col-sm-8 offset-sm-2">
                <div class="row mb-3 justify-content-center align-items-center">
                    <img class="img-fluid" src="{{ asset('img/deco/order-successful-deco.png') }}" style="height: 150px;" />
                </div>

                <div class="row mb-3">
                    <div class="col-12 text-center">
                        下单成功<br>
                        <span class="text-muted">谢谢您的支持！<br>我们会尽快完成您的订单！</span><br>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-sm-12 col-md-6 lime lighten-3 text-center mx-auto p-3 mb-2">
                        <b>{{ session('orderCode') }}</b>
                    </div>
                    <div class="col-12 text-center">追踪ID</div>
                </div>

                <div class="row justify-content-center align-items-center">
                    <div class="d-flex mx-1">
                        <button type="button" class="btn btn-primary btn-block" onclick="goToOrderTracking()">追踪订单</button>
                        <button type="button" class="btn btn-primary btn-block" onclick="goToItemList()">再去逛逛</button>
                    </div>
                </div>
            </div>


        </div>

    </main>

@endsection

@section('extraScript')
    <script>
        function goToOrderTracking() {
            window.location.href = "/ch/order-tracking";
        }

        function goToItemList() {
            window.location.href = "/ch/item";
        }
    </script>
@endsection
