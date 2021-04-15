@extends('en.layouts.customer')

@section('title')
    Item List | Ecolla ε口乐
@endsection

@section('content')
    <main class="container">

        <div class="row mb-3">

            <!-- Item Searching -->
            <div class="col-sm-12 col-md-6">
                <form action="{{ url('/en/item') }}" method="get">
                    <div class="form-row">
                        <div class="col-10">
                            <input type="text" class="form-control" maxlength="20" name="search"
                                   value="{{ isset($_GET["search"]) ? $_GET["search"] : "" }}"/>
                        </div>
                        <div class="col-2">
                            <input type="submit" class="btn btn-primary p-2 mt-0" value="搜索"/>
                        </div>
                    </div>
                </form>
            </div><!-- Item Searching -->

            <!-- Category Filter -->
            <div class="col-sm-12 col-md-6">

                <select name="category" id="categorySelector" class="custom-select w-100 mb-3">
                    <option value=""<?= isset($_GET["category"]) ? "" : " "; ?>>All
                        (<?= \App\Models\Item::getListedCount() ?>)
                    </option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->name_en }}"{{ @$_GET['category'] == $category->name || @$_GET['category'] == $category->name_en ? " selected" : "" }}>
                            {{ $category->name_en }} ({{ \App\Models\Category::getListedItemCount($category->id) }})
                        </option>
                    @endforeach

                </select>
            </div><!-- Category Filter -->
        </div>


        <div class="row mb-3">
            @foreach($items as $item)
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 mb-3">
                    <div class="card">
                        <a href="{{ url('/en/item' . $item->name_en) }}">
                            <img src="{{ $item->getCoverImage() }}" class="card-img-top" alt="image">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title text-truncate">
                                {{ $item->name_en }}
                            </h5>

                            <span style="color: brown;">
                                @if($item->getPriceRange()['min'] == $item->getPriceRange()['max'])
                                    RM{{ $item->getPriceRange()['min'] }}
                                @else
                                    RM{{ $item->getPriceRange()['min'] }} - RM{{ $item->getPriceRange()['max'] }}
                                @endif
                            </span>

                            @if(!$item->hasNoWholesale())
                                <span class="badge badge-info">Wholesale</span>
                            @endif

                            <div class="row">
                                <div class="col text-left">
                                    <i class="icofont icofont-cart-alt"></i> {{ $item->util->sold }} sold
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

    </main>

@endsection

@section('extraScript')
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
