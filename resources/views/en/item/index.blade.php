@extends('en.layouts.customer')

@section('title')
    Item List | Ecolla ε口乐
@endsection

@section('content')
    <main class="container">

        <div class="row mb-3">
            <div class="col-sm-12 col-md-6">
                <form action="/item-list.php" method="get">

                    <div class="form-row">
                        <div class="col-10">
                            <!-- Item searching -->
                            <input type="text" class="form-control" maxlength="20" name="search"
                                   value="<?= isset($_GET["search"]) ? $_GET["search"] : ""; ?>"/>
                        </div>
                        <div class="col-2">
                            <input type="submit" class="btn btn-primary p-2 mt-0" value="搜索"/>
                        </div>
                    </div>

                </form>
            </div>

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
                @include('en.item.layouts.item-block', ['item', $item])
            @endforeach
        </div>

        {{--        <div class="row mb-3">--}}
        {{--            <div class="col-12">--}}
        {{--                <nav>--}}
        {{--                    <ul class="pagination justify-content-center">--}}
        {{--                        <li class="page-item <?= $page == 1 ? "disabled" : ""; ?>">--}}
        {{--                            <a class="page-link" id="previous-page-button" <?= $page == 1 ? "tabindex='1' aria-disabled='true'" : ""; ?>>上一页</a>--}}
        {{--                        </li>--}}

        {{--                        <?php for($i = 1; $i <= $totalPage; $i++) : ?>--}}
        {{--                        <li class="page-item <?= $page == $i ? "active" : ""; ?>" value="<?= $i; ?>"><a class="page-link page-number-link"><?= $i; ?></a></li>--}}
        {{--                        <?php endfor; ?>--}}

        {{--                        <li class="page-item<?= $page == $totalPage ? " disabled" : ""; ?>">--}}
        {{--                            <a class="page-link" id="next-page-button" <?= $page == $totalPage ? "tabindex='1' aria-disabled='true'" : ""; ?>>下一页</a>--}}
        {{--                        </li>--}}
        {{--                    </ul>--}}
        {{--                </nav>--}}
        {{--            </div>--}}
        {{--        </div>--}}

    </main>

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
