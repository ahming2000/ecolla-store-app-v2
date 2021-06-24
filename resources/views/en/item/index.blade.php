@extends('en.layouts.customer')

@section('title')
    Ecolla Official Snack Shop
@endsection

@section('extraStyle')
    <style>
        body main {
            margin-top: 55px;
        }

        .welcome-text {
            background-image: url({{ asset('img/home/welcome-background.jpeg') }});
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

        .slider-control-prev, .slider-control-next {
            position: absolute;
            background-color: rgba(153, 153, 153, 0.5);
            border: none;
            font-size: 20px;
            cursor: pointer;
            z-index: 2;
        }

        .slider-control-prev, .slider-control-next {
            top: 33%;
        }

        .slider-control-prev {
            right: 91%;
            margin-left: 17px;
        }

        .slider-control-next {
            left: 91%;
            margin-right: 17px;
        }
    </style>
@endsection

@section('content')
    <main>
        <div class="welcome-text mb-3">
            Welcome to
            <div class="highlighted">Ecolla</div>
            Snack Shop
        </div>

        <div class="container">
                @if(session()->has('message'))
                    <div class="alert alert-info text-center" role="alert">
                        {!! session('message') !!}
                    </div>
                @endif
            <div class="row mb-3">



            <!-- Item Searching -->
                <div class="col-sm-12 col-md-6">
                    <form action="{{ url('/en/item') }}" method="get">
                        <div class="form-row">
                            <div class="col-10">
                                <input type="text" class="form-control" maxlength="20" name="search"
                                       value="{{ $_GET["search"] ?? "" }}"/>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary p-2 mt-0">Search</button>
                            </div>
                        </div>
                    </form>
                </div><!-- Item Searching -->

                <!-- Category Filter -->
                <div class="col-sm-12 col-md-6">

                    <select name="category" id="categorySelector" class="custom-select w-100 mb-3">
                        <option value="">
                            All ({{ \App\Models\Item::getListedCount() }})
                        </option>

                        @foreach($categories as $category)
                            @if(\App\Models\Category::getListedItemCount($category->id) != 0)
                                <option
                                    value="{{ $category->name_en }}"{{ @$_GET['category'] == $category->name || @$_GET['category'] == $category->name_en ? " selected" : "" }}>
                                    {{ $category->name_en }}
                                    ({{ \App\Models\Category::getListedItemCount($category->id) }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div><!-- Category Filter -->
            </div>


            <div class="row mb-3">
                @foreach($items as $item)
                    <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                        <div class="card">
                            @if(!empty($item->images->toArray()))
                                <a href="{{ url('/en/item/' . $item->id) }}">
                                    <img src="{{ $item->getCoverImage() }}" class="card-img-top" alt="image"
                                         loading="lazy">
                                </a>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title text-truncate">
                                    <a href="{{ url('/en/item/' . $item->id) }}">
                                        <span style="color: black">{{ $item->name_en }}</span>
                                    </a>
                                </h5>

                                <span style="color: brown;">
                                @if($item->getPriceRange()['min'] == $item->getPriceRange()['max'])
                                        RM{{ $item->getPriceRange()['min'] }}
                                    @else
                                        RM{{ $item->getPriceRange()['min'] }} - RM{{ $item->getPriceRange()['max'] }}
                                    @endif
                            </span>

                                @if(!empty($item->discounts->toArray()))
                                    <span class="badge badge-info">Wholesale</span>
                                @endif

                                <div class="row">
                                    <div class="col text-left">
                                        <i class="icofont icofont-box"></i> {{ $item->getTotalStock() }}
                                    </div>
                                    <div class="col text-right">
                                        <i class="icofont icofont-eye"></i> {{ $item->util->view_count }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-center">
                    {{ $items->links() }}
                </div>
            </div>
        </div>
    </main>
@endsection

@section('extraScriptEnd')
    <script>
        $(document).ready(function () {
            // Category bar onchange bar
            $("#categorySelector").on("change", function () {
                if ($("#categorySelector option:selected").val() !== "") {
                    window.location.href = "/en/item?<?= isset($_GET["search"]) ? "search=" . $_GET["search"] . "&" : ""; ?>category=" + $("#categorySelector option:selected").val();
                } else {
                    window.location.href = "/en/item<?= isset($_GET["search"]) ? "?search=" . $_GET["search"] : ""; ?>";
                }
            });
        });
    </script>
@endsection
