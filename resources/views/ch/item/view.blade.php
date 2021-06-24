@extends('ch.layouts.customer')

@section('title')
    {{ $item->name }} | Ecolla ε口乐
@endsection

@section('extraStyle')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>

    <style>
        .slider-nav li {
            display: inline;
        }
    </style>
@endsection

@section('extraScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <script src="{{ asset('vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-mousewheel-master/jquery.mousewheel.min.js') }}"></script>
@endsection

@section('content')

    <main class="container">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/ch/item') }}">商品列表</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $item->origin }}出产</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
            </ol>
        </nav>
        <!-- Breadcrumb -->

        @if(session()->has('message'))
            <div class="alert alert-info text-center" role="alert">
                {{ session('message') }}
            </div>
    @endif

    <!-- Item Information -->
        <div class="row">
            <!-- Item Images Slider -->
            <div class="col-md-5 mb-4">
                <div class="row">
                    @if($item->getTotalImageCount() == 1 && !empty($item->images->toArray()))
                        <div class="col-12 mb-3">
                            <img class="img-fluid general-img" src="{{ asset($item->images[0]->image) }}"
                                 loading="lazy"/>
                        </div>
                    @elseif($item->getTotalImageCount() != 0)
                        <div class="col-12 slider-control-main-container mb-3">
                            <div class="slider-control-prev rounded">
                                <img class="img-fluid" src="{{ asset('img/alt/prev-button-alt.png') }}" loading="lazy"/>
                            </div>
                            <div class="slider-control-next rounded">
                                <img class="img-fluid" src="{{ asset('img/alt/next-button-alt.png') }}" loading="lazy"/>
                            </div>
                            <div class="slider-container">

                                @foreach($item->images as $img)
                                    <img class="img-fluid general-img" src="{{ asset($img->image) }}" loading="lazy"/>
                                @endforeach

                                @foreach($item->variations as $v)
                                    @if($v->image != null)
                                        <img class="img-fluid variety-img" id="img-{{ $v->barcode }}"
                                             src="{{ asset($v->image) }}" loading="lazy"/>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                        <div class="col-12 slider-control-nav-container mb-3">
                            <div class="slider-nav-control-prev rounded">
                                <img class="img-fluid" src="{{ asset('img/alt/prev-button-alt.png') }}" loading="lazy"/>
                            </div>
                            <div class="slider-nav-control-next rounded">
                                <img class="img-fluid" src="{{ asset('img/alt/next-button-alt.png') }}" loading="lazy"/>
                            </div>
                            <div class="slider-nav-container">
                                <ul class="slider-nav">

                                    @foreach($item->images as $img)
                                        <li><img class="img-fluid" style="max-height: 100px" src="{{ $img->image }}"
                                                 loading="lazy"/></li>
                                    @endforeach


                                    @foreach($item->variations as $v)
                                        @if($v->image != null)
                                            <li><img class="img-fluid" style="max-height: 100px" src="{{ $v->image }}"
                                                     loading="lazy"/></li>
                                        @endif
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Item Images Slider -->

            <!-- Item Purchasing Option -->
            <div class="col-md-7 mb-4 p-4">
                <div class="row">
                    <!-- Item category badge -->
                    <div class="col-12 mb-3">
                        <div class="row">
                            @foreach($item->categories as $cat)
                                <a href="{{ url('/ch/item?category=' . $cat->name) }}">
                                    <span class="badge badge-pill secondary-color mr-1 p-2">{{ $cat->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <!-- Item category badge -->

                    <!-- Item information -->
                    <div class="col-12">
                        <div class="h2 font-weight-bold">{{ $item->name }}</div>
                    </div>

                    <div class="col-12">
                        <div class="h6 text-muted">
                            <span>已售出 {{ $item->util->sold }} 个</span> |
                            <span>{{ $item->util->view_count }} 次浏览</span>
                        </div>
                    </div>

                    <div class="col-12 mb-3">

                        <?php $first = true; ?>
                        @foreach($item->variations as $v)

                            @if($v->getDiscountMode() == 'variation')
                                <div class="h4 price-view discounted-price"
                                     id="variety-{{ $v->barcode }}" <?= $first ? "" : "hidden"; ?>>
                                    <?php $first = false; ?>
                                    <span class="grey-text mr-1" style="font-size: 15px">
                                        <del>
                                            RM{{ number_format($v->price, 2, '.', '') }}
                                        </del>
                                    </span>
                                    <span class="red-text font-weight-bold mr-1">
                                        <strong>
                                            RM{{ number_format($v->price * $v->discount->rate, 2, '.', '') }}
                                        </strong>
                                    </span>
                                    <span class="badge badge-danger mr-1">
                                        {{ number_format((1 - $v->discount->rate) * 100, 0, '.', '') }}% OFF
                                    </span>
                                    <br>
                                </div>
                            @else

                                <div class="h4 price-view pl-3 font-weight-bold blue-text"
                                     id="variety-{{ $v->barcode }}" <?= $first ? "" : "hidden"; ?>>
                                    <?php $first = false; ?>

                                    @if($v->getDiscountMode() == 'wholesale')

                                        <div
                                            class="price-view-normal" {{ $item->getSortedWholesales()[0]->min == 1 ? "hidden" : "" }}>
                                            <strong>RM{{ number_format($v->price, 2, '.', '') }}</strong>
                                        </div>

                                        @foreach($item->getSortedWholesales() as $w)
                                            <div class="price-view-wholesale wholesale-{{ $w->min }}"
                                                {{ $w->step == 1 && $w->min == 1 ? "" : "hidden" }}>
                                                <span class="grey-text mr-1" style="font-size: 15px">
                                                    <del>RM{{ number_format($v->price, 2, '.', '') }}</del>
                                                </span>
                                                <span class="orange-text font-weight-bold">
                                                    <strong>RM{{ number_format($v->price * $w->rate, 2, '.', '') }}</strong>
                                                </span>
                                                <span class="badge badge-warning mr-1">
                                                    {{ number_format((1 - $w->rate) * 100, 0, '.', '') }}% OFF
                                                </span>
                                                <span class="grey-text mr-1" style="font-size: 10px">
                                                    （批发价）
                                                </span>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="price-view-normal">
                                            <strong>RM{{ number_format($v->price, 2, '.', '') }}</strong>
                                        </div>
                                    @endif
                                </div>

                            @endif
                        @endforeach

                        @if(!empty($item->discounts))
                            <?php $first = true; ?>
                            @foreach($item->getSortedWholesales() as $w)
                                <div class="h6 wholesale-view" <?= $first ? "" : "hidden"; ?>>
                                    <?php $first = false; ?>

                                    <input type="number" class="wholesale-min" value="{{ $w->min }}" hidden/>
                                    <span class="grey-text">
                                        购买至{{ $w->min }}件可以以批发价 RM{{ number_format($item->getFirstVariation()->price * $w->rate, 2, '.', '') }} 购买
                                    </span>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <!-- Item information -->

                    <div class="col-12">
                        <form action="{{ url('/ch/item/' . $item->name) }}" method="post">

                            @csrf

                            <div class="row mb-3">

                                <!-- Property selector -->
                                <div class="col-xs-12 col-sm-4">
                                    <div class="h5">规格：</div>
                                </div>

                                <input id="barcode" type="text" name="barcode"
                                       value="{{ $item->getFirstVariation()->barcode }}" hidden/>
                                <input id="inventory" type="text"
                                       value="{{ $item->getFirstVariation()->stock }}" hidden/>

                                <div class="col-xs-12 col-sm-8">
                                    <ol class="list-group variety-selector">
                                        <?php $first = true; ?>
                                        @foreach($item->variations as $v)
                                            <li class="list-group-item <?= $first ? "active" : "" ?>"> <?php $first = false; ?>
                                                <input type="text" class="variety-barcode"
                                                       value="{{ $v->barcode }}"
                                                       hidden/>
                                                <input type="text" class="variety-inventory"
                                                       value="{{ $v->stock }}" hidden/>
                                                {{ $v->name }}
                                                @if($v->stock == 0)
                                                    <span class="badge badge-danger mx-1">已售完<span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                                <!-- Property selector -->
                            </div>

                            <div class="row mb-3 text-center">
                                <!-- Quantity control interface -->
                                <div class="col-xs-12 col-sm-7 col-lg-6 quantity-button-control mt-2">
                                    <button type="button"
                                            class="btn btn-primary btn-sm quantity-decrease-button"
                                            disabled>-
                                    </button>
                                    <input type="number" class="mx-2" id="quantity" name="quantity"
                                           value="{{ $item->getFirstVariation()->stock == 0 ? "0" : "1" }}"
                                           style="width: 45px;" {{ $item->getFirstVariation()->stock == 0 ? "disabled" : "" }}>
                                    <button type="button"
                                            class="btn btn-primary btn-sm quantity-increase-button" {{ $item->getFirstVariation()->stock <= 1 ? "disabled" : "" }}>
                                        +
                                    </button>
                                </div>
                                <!-- Quantity control interface -->

                                <!-- Submit button -->
                                <div class="col-xs-12 col-sm-5 col-lg-6">
                                    <button class="btn secondary-color" type="submit"
                                            id="add-to-cart-button" {{ $item->getFirstVariation()->stock == 0 ? "disabled" : "" }}>
                                        加入购物车<i class="icofont icofont-shopping-cart ml-1"></i>
                                    </button>
                                </div>
                                <!-- Submit button -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Item Purchasing Option -->
        </div>
        <!-- Item Information -->

        <!-- Item Description -->
        <div class="h2" style="font-weight: bold">商品描述</div>
        <div class="row mb-3">
            <div class="col-12">
                <textarea class="form-control" id="desc" readonly hidden>{{ $item->desc }}</textarea>
                <p id="desc-display"></p>
            </div>
        </div>
        <!-- Item Description -->

        <!-- Recommendation (Random) -->
        <div class="h2">你可能喜欢</div>
        <div class="row mb-3">
            <div class="owl-carousel mousescroll owl-theme">
                @foreach($randomItems as $randomItem)
                    <div class="item">
                        <div class="card">
                            <a href="/ch/item/{{ $randomItem->id }}">
                                <img class="card-img-top" src="{{ $randomItem->getCoverImage() }}" loading="lazy">

                                <div class="card-body">
                                    <h5 class="card-title text-truncate"
                                        style="color: black">{{ $randomItem->name }}</h5>
                                    <p class="card-text text-muted">
                                        @if($randomItem->getPriceRange()['min'] == $randomItem->getPriceRange()['max'])
                                            RM{{ $randomItem->getPriceRange()['min'] }}
                                        @else
                                            RM{{ $randomItem->getPriceRange()['min'] }} -
                                            RM{{ $randomItem->getPriceRange()['max'] }}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Recommendation (Random) -->

        <!-- Similar (Same category) -->
        <div class="h2">类似商品</div>
        <div class="row mb-3">
            <div class="owl-carousel mousescroll owl-theme">
                @foreach($mayLikeItems as $mayLikeItem)
                    <div class="item">
                        <div class="card">
                            <a href="/ch/item/{{ $mayLikeItem->id }}">
                                <img class="card-img-top" src="{{ $mayLikeItem->getCoverImage() }}" loading="lazy">

                                <div class="card-body">
                                    <h5 class="card-title text-truncate"
                                        style="color: black">{{ $mayLikeItem->name }}</h5>
                                    <p class="card-text text-muted">
                                        @if($mayLikeItem->getPriceRange()['min'] == $mayLikeItem->getPriceRange()['max'])
                                            RM{{ $mayLikeItem->getPriceRange()['min'] }}
                                        @else
                                            RM{{ $mayLikeItem->getPriceRange()['min'] }} -
                                            RM{{ $mayLikeItem->getPriceRange()['max'] }}
                                        @endif
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Similar (Same category) -->

    </main>
@endsection

@section('extraScriptEnd')

    <script>
        // Convert textarea format to paragraph
        document.getElementById('desc-display').innerHTML = document.getElementById('desc').value.split('\n').join('<br>');
    </script>

    <script>
        $('.owl-carousel').owlCarousel({
            margin: 10,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        });
        var owl = $('.mousescroll1');
        owl.on('mousewheel', '.owl-stage', function (e) {
            if (e.deltaY > 0) {
                owl.trigger('next.owl');
            } else {
                owl.trigger('prev.owl');
            }
            e.preventDefault();
        });
        var owl1 = $('.mousescroll');
        owl1.on('mousewheel', '.owl-stage', function (e) {
            if (e.deltaY > 0) {
                owl1.trigger('next.owl');
            } else {
                owl1.trigger('prev.owl');
            }
            e.preventDefault();
        });
    </script>

    @if($item->getTotalImageCount() > 1)
        <script>
            var slider = tns({
                container: '.slider-container',
                items: 1,

                controlsContainer: '.slider-control-main-container',
                prevButton: '.slider-control-prev',
                nextButton: '.slider-control-next',

                navContainer: '.slider-nav',
                navAsThumbnails: true,

                autoplay: true,
                autoplayHoverPause: true,
                autoplayButtonOutput: false,
            });

            // Start autoplay
            slider.play();

            var sliderNav = tns({
                container: '.slider-nav',

                controlsContainer: '.slider-control-nav-container',
                prevButton: '.slider-nav-control-prev',
                nextButton: '.slider-nav-control-next',

                nav: false,
                loop: false,
                mouseDrag: true,

                responsive: {
                    992: {
                        items: {{ $item->getTotalImageCount() <= 5 ? strval($item->getTotalImageCount() - 1) : '5' }},
                        slideBy: 4,
                    },
                    768: {
                        items: {{ $item->getTotalImageCount() <= 3 ? strval($item->getTotalImageCount() - 1) : '3' }},
                        slideBy: 4,
                    },
                    576: {
                        items: {{ $item->getTotalImageCount() <= 4 ? strval($item->getTotalImageCount() - 1) : '4' }},
                        slideBy: 1,
                    },
                    288: {
                        items: {{ $item->getTotalImageCount() <= 3 ? strval($item->getTotalImageCount() - 1) : '3' }},
                        slideBy: 1,
                    },
                    100: {
                        items: {{ $item->getTotalImageCount() <= 2 ? strval($item->getTotalImageCount() - 1) : '2' }},
                        slideBy: 1,
                    }
                },
            });
        </script>
    @endif


    <script>

        $(document).ready(function () {

            function quantityReset() {
                $("#quantity").val(1);
                $("#quantity").removeAttr("disabled");
                $(".quantity-decrease-button").attr("disabled", "disabled");
                $(".quantity-increase-button").removeAttr("disabled");
            }

            function quantityControlDisable() {
                $("#quantity").val(0);
                $("#quantity").attr("disabled", "disabled");
                $(".quantity-decrease-button").attr("disabled", "disabled");
                $(".quantity-increase-button").attr("disabled", "disabled");
            }

            function quantityToMaxInventory(inventoryQuantity) {
                $("#quantity").val(inventoryQuantity);
                $("#quantity").removeAttr("disabled");
                $(".quantity-decrease-button").removeAttr("disabled");
                $(".quantity-increase-button").attr("disabled", "disabled");
            }

            function quantityUnlockControl() {
                $(".quantity-decrease-button").removeAttr("disabled");
                $(".quantity-increase-button").removeAttr("disabled");
            }


            // Selected property controller
            $(".variety-selector li").on("click", function () {

                var quantity = parseInt($("#quantity").val());
                var selectedVarietyInventory = parseInt($(this).children(".variety-inventory").val());
                var selectedVarietyBarcode = $(this).children(".variety-barcode").val();

                // List responsive
                $(".variety-selector li").removeClass("active");
                $(this).addClass("active");

                // Change the variety barcode
                $("#barcode").val(selectedVarietyBarcode);

                // Change the price viewing
                $(".price-view").attr("hidden", "hidden");
                $("#variety-" + selectedVarietyBarcode).removeAttr("hidden");

                // Change the wholesale information view
                if ($("#variety-" + selectedVarietyBarcode).hasClass("discounted-price")) {
                    $(".wholesale-view").hide();
                } else {
                    $(".wholesale-view").show();
                }

                // Change the variety total inventory quantity
                $("#inventory").val(selectedVarietyInventory);

                // Disable add to cart button if the variety total quantity is 0 (sold out)
                if (selectedVarietyInventory == 0) {
                    $("#add-to-cart-button").attr("disabled", "disabled");
                } else {
                    $("#add-to-cart-button").removeAttr("disabled");
                }

                // Adjust quantity input to inventory maximum if quantity exceed the max inventory
                if (selectedVarietyInventory == 0) {
                    quantityControlDisable();
                } else {
                    if (quantity == 0) { //Previously is 0
                        quantityReset();
                    } else {
                        if (quantity != 1) {
                            if (quantity >= selectedVarietyInventory) { // Previous quantity is larger than the current variety max inventory
                                quantityToMaxInventory(selectedVarietyInventory);
                            } else {
                                quantityUnlockControl();
                            }
                        }
                    }
                }

                // Navigate to selected variety image
                var totalGeneralImg = $(".slider-container").children(".general-img").length - 2; // Get the total number of images
                var selectedImageIndex = totalGeneralImg; // Initialize
                for (i = 0; i < $(".variety-selector li").length; i++) { // Get index of the image
                    var v = $(".variety-selector li").eq(i).children(".variety-barcode").val();
                    if ($("#img-" + v).val() != undefined) {
                        selectedImageIndex++;
                        if (v === selectedVarietyBarcode) {
                            break;
                        }
                    }
                }
                if ($("#img-" + selectedVarietyBarcode).val() != undefined) slider.goTo(selectedImageIndex); // Make sure image is existed before use goto function
            });

            //Quantity input onchange detect logic with inventory
            $("#quantity").on("change", function () {
                var selectedVarietyInventory = parseInt($(".variety-selector li.active").children(".variety-inventory").val());
                var quantity = parseInt($("#quantity").val());

                if (quantity >= selectedVarietyInventory) { // Previous quantity is larger than the current variety max inventory
                    quantityToMaxInventory(selectedVarietyInventory);
                } else if (quantity <= 0) {
                    quantityReset();
                } else {
                    quantityUnlockControl();
                }

                // Update wholesale information
                var quantity = parseInt($("#quantity").val());
                // Get wholesale range index
                var currentWholesaleIndex = -1; //Default does not involve in any wholesale
                //if($(".wholesale-view").eq(0).find(".wholesale-min").val() == 1) currentWholesaleIndex = 0; // If the first wholesale min is 1, set index to 0
                for (var i = 0; i < $(".wholesale-view").length; i++) {
                    if (i != $(".wholesale-view").length - 1) {
                        if (quantity >= $(".wholesale-view").eq(i).find(".wholesale-min").val()) {
                            if (quantity < $(".wholesale-view").eq(i + 1).find(".wholesale-min").val()) {
                                currentWholesaleIndex = i;
                                break;
                            }
                        } else {
                            break; // Current quantity didnt reach wholesale min
                        }
                    } else {
                        currentWholesaleIndex = $(".wholesale-view").length - 1; // Last and to infinity
                    }
                }

                // Update price view and information
                if (currentWholesaleIndex >= 0) {
                    $(".price-view-normal").attr("hidden", "hidden");

                    $(".price-view-wholesale").attr("hidden", "hidden");
                    min = $(".wholesale-view").eq(currentWholesaleIndex).find(".wholesale-min").val();
                    $(".wholesale-" + min).removeAttr("hidden");

                    $(".wholesale-view").attr("hidden", "hidden");
                    $(".wholesale-view").eq(currentWholesaleIndex + 1).removeAttr("hidden");
                } else {
                    $(".price-view-normal").removeAttr("hidden");

                    $(".price-view-wholesale").attr("hidden", "hidden");

                    $(".wholesale-view").attr("hidden", "hidden");
                    $(".wholesale-view").eq(0).removeAttr("hidden");
                }
            });

            // Quantity controller
            $(".quantity-button-control button").on("click", function () {

                // Inventory quantity (max)
                let INVENTORY = $("#inventory").val();

                // Current quantity
                var quantity = $(this).parent().children('input').val();

                // Increase button clicked
                if ($(this).hasClass("quantity-increase-button")) {

                    // Increase quantity
                    $(this).parent().children('input').val(++quantity);

                    // Disable button when reach maximum
                    if ($(this).parent().children('input').val() == INVENTORY) {
                        $(this).attr('disabled', 'disabled');
                        $(this).parent().children('.quantity-decrease-button').removeAttr('disabled');
                    } else {
                        $(this).removeAttr('disabled');
                        $(this).parent().children('.quantity-decrease-button').removeAttr('disabled');
                    }
                }
                // Decrease button clicked
                else if ($(this).hasClass("quantity-decrease-button")) {

                    // Decrease quantity
                    $(this).parent().children('input').val(--quantity);

                    // Disable button when reach minimum
                    if ($(this).parent().children('input').val() == 1) {
                        $(this).parent().children('.quantity-increase-button').removeAttr('disabled');
                        $(this).attr('disabled', 'disabled');
                    } else {
                        $(this).parent().children('.quantity-increase-button').removeAttr('disabled');
                        $(this).removeAttr('disabled');
                    }
                }

                // Update wholesale information
                var quantity = parseInt($(this).parent().children('input').val());
                // Get wholesale range index
                var currentWholesaleIndex = -1; //Default does not involve in any wholesale
                //if($(".wholesale-view").eq(0).find(".wholesale-min").val() == 1) currentWholesaleIndex = 0; // If the first wholesale min is 1, set index to 0
                for (var i = 0; i < $(".wholesale-view").length; i++) {
                    if (i != $(".wholesale-view").length - 1) {
                        if (quantity >= $(".wholesale-view").eq(i).find(".wholesale-min").val()) {
                            if (quantity < $(".wholesale-view").eq(i + 1).find(".wholesale-min").val()) {
                                currentWholesaleIndex = i;
                                break;
                            }
                        } else {
                            break; // Current quantity didnt reach wholesale min
                        }
                    } else {
                        currentWholesaleIndex = $(".wholesale-view").length - 1; // Last and to infinity
                    }
                }

                // Update price view and information
                if (currentWholesaleIndex >= 0) {
                    $(".price-view-normal").attr("hidden", "hidden");

                    $(".price-view-wholesale").attr("hidden", "hidden");
                    min = $(".wholesale-view").eq(currentWholesaleIndex).find(".wholesale-min").val();
                    $(".wholesale-" + min).removeAttr("hidden");

                    $(".wholesale-view").attr("hidden", "hidden");
                    $(".wholesale-view").eq(currentWholesaleIndex + 1).removeAttr("hidden");
                } else {
                    $(".price-view-normal").removeAttr("hidden");

                    $(".price-view-wholesale").attr("hidden", "hidden");

                    $(".wholesale-view").attr("hidden", "hidden");
                    $(".wholesale-view").eq(0).removeAttr("hidden");
                }

            });

        });
    </script>

@endsection
