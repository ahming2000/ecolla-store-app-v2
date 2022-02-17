@extends('ch.layouts.app')

@section('title')
    Ecolla e口乐零食店官网
@endsection

@section('style')
    <style>
        body main {
            margin-top: 55px;
        }

        .welcome-text {
            background-image: url({{ asset('img/welcome.jpeg') }});
            background-position: top;
            background-repeat: no-repeat;
            background-size: cover;
            padding-top: 115px;
            color: white;
            font-size: 35px;
            height: 40vh;
            text-align: center;
        }

        .highlighted {
            color: #F02B73;
            display: inline;
        }

        .price-text-normal {
            color: brown;
        }
    </style>
@endsection

@section('content')
    <main>

        <div class="welcome-text mb-3">
            欢迎来到
            <span class="highlighted">Ecolla e口乐</span>
            零食店
        </div>

        <div class="container">

            @if(session()->has('message'))
                <div class="alert alert-info text-center" role="alert">
                    {!! session('message') !!}
                </div>
            @endif

            <div class="row mb-3">

                @if(App\Models\SystemConfig::where('name', '=', 'clt_o_shipping_discount')->value('value') == '1')
                    <div class="col-12">
                        <div class="card shadow bg-warning mb-3">
                            <div class="card-body">
                                <div class="h5 text-center">
                                    限时优惠！买上RM{{ App\Models\SystemConfig::where('name', '=', 'clt_o_shipping_discount_threshold')->value('value') }}免邮！
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Search -->
                <div class="col-sm-12 col-md-6 mb-2">
                    <form action="{{ url('/ch/item') }}" method="get">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1 me-2">
                                <input type="text" class="form-control shadow" maxlength="20" name="search"
                                       value="{{ $_GET["search"] ?? "" }}" placeholder="搜索名称、货号、规格、出产地、商品描述">
                            </div>
                            <div>
                                <button class="btn btn-primary shadow">
                                    <i class="icofont icofont-search"></i> 搜索
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Search -->

                <!-- Category Filter -->
                <div class="col-sm-12 col-md-6">
                    <select class="form-select shadow" name="category" id="categorySelector">
                        <option value="">
                            全部商品 ({{ \App\Models\Item::getListedCount() }})
                        </option>

                        @foreach($categories as $category)
                            @if(\App\Models\Category::getListedItemCount($category->id) != 0)
                                <option value="{{ $category->name }}"
                                    {{ @$_GET['category'] == $category->name || @$_GET['category'] == $category->name_en ? "selected" : "" }}>
                                    {{ $category->name }}
                                    ({{ \App\Models\Category::getListedItemCount($category->id) }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <!-- Category Filter -->
            </div>

            <div class="row mb-3">
                @foreach($items as $item)
                    <div class="col-6 col-md-4 col-lg-3 col-xxl-2 mb-3">
                        @include('ch.component.itemBox')
                    </div>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {{ $items->links() }}
                </div>
            </div>
            {{-- Pagination Links --}}

        </div>

    </main>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Category bar onchange bar
            $("#categorySelector").on("change", function () {
                if ($("#categorySelector option:selected").val() !== "") {
                    window.location.href = "/ch/item?<?= isset($_GET["search"]) ? "search=" . $_GET["search"] . "&" : ""; ?>category=" + $("#categorySelector option:selected").val();
                } else {
                    window.location.href = "/ch/item<?= isset($_GET["search"]) ? "?search=" . $_GET["search"] : ""; ?>";
                }
            });
        });
    </script>
@endsection
