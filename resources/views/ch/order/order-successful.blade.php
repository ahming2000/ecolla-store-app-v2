@extends('ch.layouts.app')

@section('title')
    下单成功 | Ecolla ε口乐
@endsection

@section('content')
    <main class="container">

        <div class="row">

            <div class="col-12 col-sm-8 offset-sm-2">
                <div class="row mb-3">
                    <div class="col-6 col-md-4 offset-3 offset-md-4">
                        <img class="img-fluid w-100" src="{{ asset('img/order-successful.png') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center mb-3">
                        下单成功<br>
                        <span class="text-muted">谢谢您的支持！<br>我们会尽快完成您的订单！<br><a href="https://wa.link/fcfum1" target="_blank">点击联系客服以确认订单详情</a></span><br>
                    </div>

                    <div class="col-12 col-md-6 offset-md-3 text-center">
                        {{ session('orderCode') }}
                    </div>

                    <div class="col-12 text-center mb-4">追踪ID</div>

                    <div class="col-12 d-flex justify-content-center">
                        <button type="button" class="btn btn-primary mx-2" onclick="goToOrderTracking()">追踪订单</button>
                        <button type="button" class="btn btn-primary mx-2" onclick="goToItemList()">再去逛逛</button>
                    </div>
                </div>

            </div>


        </div>

    </main>

@endsection

@section('script')
    <script>
        function goToOrderTracking() {
            window.location.href = "/ch/order-tracking?code={{ session('orderCode') }}";
        }

        function goToItemList() {
            window.location.href = "/ch/item";
        }
    </script>
@endsection
