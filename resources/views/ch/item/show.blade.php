@extends('ch.layouts.app')

@section('title')
    {{ $item->name }} | Ecolla e口乐
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>
@endsection

@section('content')

    <main class="container">

        {{-- Breadcrumb --}}
        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/ch/item') }}">商品列表</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $item->origin }}出产</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
            </ol>
        </nav>
        {{-- Breadcrumb --}}

        {{-- Message --}}
        @if(session()->has('message'))
            <div class="alert alert-info text-center" role="alert">
                {{ session('message') }}
            </div>
        @endif
        {{-- Message --}}

        <div class="row">

            <div class="col-12 col-lg-5 mb-4">

                <div class="row">

                    {{-- Image Slider --}}
                    <div class="col-12 mb-3 slider-main-container">
                        @if($item->getTotalImageCount() != 0)
                            <button class="slider-control-prev"><</button>@endif
                        <div class="slider-container">
                            @if($item->images != null)
                                @foreach($item->images as $img)
                                    <img class="img-fluid general-img"
                                         src="{{ asset($img->image) }}" loading="lazy" alt="">
                                @endforeach
                            @endif

                            @foreach($item->variations as $v)
                                @if($v->image != null)
                                    <img class="img-fluid variety-img" id="img-{{ $v->barcode }}"
                                         src="{{ asset($v->image) }}" loading="lazy" alt="">
                                @endif
                            @endforeach
                        </div>
                        @if($item->getTotalImageCount() != 0)
                            <button class="slider-control-next">></button>@endif
                    </div>
                    {{-- Image Slider --}}

                    {{-- Slider Navigator --}}
                    <div class="col-12 mb-3">
                        <ul class="slider-nav">
                            @foreach($item->images as $img)
                                <li class="me-1">
                                    <img class="img-fluid" style="max-height: 100px"
                                         src="{{ $img->image }}" loading="lazy" alt="">
                                </li>
                            @endforeach

                            @foreach($item->variations as $v)
                                @if($v->image != null)
                                    <li class="me-1">
                                        <img class="img-fluid" style="max-height: 100px"
                                             src="{{ $v->image }}" loading="lazy" alt="">
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    {{-- Slider Navigator --}}

                </div>
            </div>

            <div class="col-12 col-lg-7 p-4">
                <div class="row">

                    {{-- Item category badge --}}
                    <div class="col-12 mb-3">
                        @foreach($item->categories as $cat)
                            <a class="no-anchor-style" href="{{ url('/ch/item?category=' . $cat->name) }}">
                                <span class="badge rounded-pill mr-1 p-2"
                                      style="background-color: mediumpurple">
                                    {{ $cat->name }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                    {{-- Item category badge --}}

                    {{-- Item Name --}}
                    <div class="col-12">
                        <div class="h2 font-weight-bold">{{ $item->name }}</div>
                    </div>
                    {{-- Item Name --}}

                    {{-- Item Util Info --}}
                    <div class="col-12 mb-3">
                        <div class="h6 text-muted">
                            <span>已售出 {{ $item->util->sold }} 个</span> |
                            <span>{{ $item->util->view_count }} 次浏览</span>
                        </div>
                    </div>
                    {{-- Item Util Info --}}

                    <div class="col-12">

                        <form action="{{ url('/ch/item/' . $item->id) }}" method="post">
                            @csrf

                            @foreach($item->variations as $variation)

                                <div class="card variation mb-1">

                                    {{-- Variation Token --}}
                                    <input type="text" class="id" value="{{ $variation->id }}" hidden>
                                    <input type="text" class="stock" value="{{ $variation->stock }}" hidden>
                                    {{-- Variation Token --}}

                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">

                                            <div>

                                                <h5 class="card-title">

                                                    {{-- Item Name --}}
                                                    {{ $variation->name }}
                                                    {{-- Item Name --}}

                                                    {{-- TODO - Discount Percentage --}}

                                                    @if($variation->stock == 0)
                                                        <span class="badge rounded-pill bg-danger mx-1">已售完<span>
                                                    @endif

                                                </h5>

                                                {{-- Price --}}
                                                <div class="price">
                                                    <?php $first = true; ?>
                                                    @foreach($item->variations as $v)

                                                        @if($v->getDiscountMode() == 'variation')
                                                            <div class="h4 price-view discounted-price"
                                                                 id="variety-{{ $v->barcode }}" <?= $first ? "" : "hidden"; ?>>
                                                                <?php $first = false; ?>
                                                                <span class="mr-1" style="color: grey;font-size: 15px">
                                        <del>
                                            RM{{ number_format($v->price, 2, '.', '') }}
                                        </del>
                                    </span>
                                                                <span class="font-weight-bold mr-1" style="color: red">
                                        <strong>
                                            RM{{ number_format($v->price * $v->discount->rate, 2, '.', '') }}
                                        </strong>
                                    </span>
                                                                <span class="badge rounded-pill bg-danger mr-1">
                                        {{ number_format((1 - $v->discount->rate) * 100, 0, '.', '') }}% OFF
                                    </span>
                                                                <br>
                                                            </div>
                                                        @else

                                                            <div class="h4 price-view pl-3 font-weight-bold" style="color: blue"
                                                                 id="variety-{{ $v->barcode }}" <?= $first ? "" : "hidden"; ?>>
                                                                <?php $first = false; ?>

                                                                @if($v->getDiscountMode() == 'wholesale')

                                                                    <div
                                                                        class="price-view-normal" {{ $item->getSortedWholesales()[0]->min == 1 ? "hidden" : "" }}>
                                                                        <strong>RM{{ number_format($v->price, 2, '.', '') }}</strong>
                                                                    </div>

                                                                    @foreach($item->getSortedWholesales() as $w)
                                                                        <div
                                                                            class="price-view-wholesale wholesale-{{ $w->min }}"
                                                                            {{ $w->step == 1 && $w->min == 1 ? "" : "hidden" }}>
                                                <span class="mr-1" style="font-size: 15px;color: grey">
                                                    <del>RM{{ number_format($v->price, 2, '.', '') }}</del>
                                                </span>
                                                                            <span class="font-weight-bold" style="color: orange">
                                                    <strong>RM{{ number_format($v->price * $w->rate, 2, '.', '') }}</strong>
                                                </span>
                                                                            <span
                                                                                class="badge rounded-pill bg-warning mr-1">
                                                    {{ number_format((1 - $w->rate) * 100, 0, '.', '') }}% OFF
                                                </span>
                                                                            <span class="mr-1"
                                                                                  style="font-size: 10px;color: grey">
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
                                                            <div
                                                                class="h6 wholesale-view" <?= $first ? "" : "hidden"; ?>>
                                                                <?php $first = false; ?>

                                                                <input type="number" class="wholesale-min"
                                                                       value="{{ $w->min }}" hidden/>
                                                                <span class="grey-text">
                                        购买至{{ $w->min }}件可以以批发价 RM{{ number_format($item->getFirstVariation()->price * $w->rate, 2, '.', '') }} 购买
                                    </span>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                {{-- Price --}}

                                            </div>

                                            {{-- Quantity Control --}}
                                            <div class="d-flex justify-content-between align-content-center my-auto" style="max-height: 35px">
                                                <button type="button"
                                                        class="btn btn-primary btn-sm me-3 px-3 quantity-dec" disabled>
                                                    -
                                                </button>
                                                <input type="number" class="form-control form-control-sm quantity-input"
                                                       value="0" name="variation[{{ $variation->id }}][quantity]" style="width: 45px" disabled>
                                                <button type="button"
                                                        class="btn btn-primary btn-sm ms-3 px-3 quantity-inc" disabled>
                                                    +
                                                </button>
                                            </div>
                                            {{-- Quantity Control --}}

                                        </div>

                                    </div>
                                </div>

                            @endforeach

                            <div class="mt-3 text-center">
                                <button class="btn btn-primary" type="submit">
                                    <i class="icofont icofont-shopping-cart ml-1"></i> 加入购物车
                                </button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>

        {{-- Item Description --}}
        <div class="h2" style="font-weight: bold">商品描述</div>
        <div class="row mb-3">
            <div class="col-12">
                <textarea class="form-control" id="desc" readonly hidden>{{ $item->desc }}</textarea>
                <p id="desc-display"></p>
            </div>
        </div>
        {{-- Item Description --}}

        {{-- Recommendation (Random) --}}
        <div class="h2">你可能喜欢</div>
        <div class="row mb-3">
            <div class="owl-carousel mousescroll owl-theme">
                @foreach($randomItems as $randomItem)
                    <div class="item">
                        <a class="no-anchor-style" href="/ch/item/{{ $randomItem->id }}">
                            <div class="card">

                                <img class="card-img-top" src="{{ $randomItem->getCoverImage() }}" loading="lazy">

                                <div class="card-body">
                                    <div class="h5 card-title text-truncate">{{ $randomItem->name }}</div>
                                    <p class="card-text text-muted">
                                        @if($randomItem->getPriceRange()['min'] == $randomItem->getPriceRange()['max'])
                                            RM{{ $randomItem->getPriceRange()['min'] }}
                                        @else
                                            RM{{ $randomItem->getPriceRange()['min'] }} -
                                            RM{{ $randomItem->getPriceRange()['max'] }}
                                        @endif
                                    </p>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Recommendation (Random) --}}

        {{-- Similar (Same category) --}}
        <div class="h2">类似商品</div>
        <div class="row mb-3">
            <div class="owl-carousel mousescroll owl-theme">
                @foreach($mayLikeItems as $mayLikeItem)
                    <div class="item">
                        <a class="no-anchor-style" href="/ch/item/{{ $mayLikeItem->id }}">
                            <div class="card">

                                <img class="card-img-top" src="{{ $mayLikeItem->getCoverImage() }}" loading="lazy">

                                <div class="card-body">
                                    <div class="h5 card-title text-truncate">{{ $mayLikeItem->name }}</div>
                                    <p class="card-text text-muted">
                                        @if($mayLikeItem->getPriceRange()['min'] == $mayLikeItem->getPriceRange()['max'])
                                            RM{{ $mayLikeItem->getPriceRange()['min'] }}
                                        @else
                                            RM{{ $mayLikeItem->getPriceRange()['min'] }} -
                                            RM{{ $mayLikeItem->getPriceRange()['max'] }}
                                        @endif
                                    </p>
                                </div>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Similar (Same category) --}}

    </main>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <script src="{{ asset('vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-mousewheel-master/jquery.mousewheel.min.js') }}"></script>

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

    <script>
        let slider = tns({
            container: '.slider-container',
            items: 1,

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

        let sliderNav = tns({
            container: '.slider-nav',
            nav: false,
            loop: false,
            mouseDrag: true,
            controls: false,
            items: 5,
        });
    </script>


    <script>


        function quantityControl(variation) {
            let input = variation.find('.quantity-input');
            let decButton = variation.find('.quantity-dec');
            let incButton = variation.find('.quantity-inc');

            let current = parseInt(input.val());
            let min = 0;
            let max = parseInt(variation.find('.stock').val());

            if (max === 0) {
                decButton.prop('disabled', true);
                incButton.prop('disabled', true);
                input.prop('disabled', true);
            } else {
                input.prop('disabled', false);
                if (current <= min) {
                    decButton.prop('disabled', true)
                    incButton.prop('disabled', false);
                } else if (current >= max) {
                    decButton.prop('disabled', false)
                    incButton.prop('disabled', true);
                } else {
                    decButton.prop('disabled', false);
                    incButton.prop('disabled', false);
                }
            }
        }

        function quantityUpdate(variation, quantity) {
            let input = variation.find('.quantity-input');

            let min = 0;
            let max = parseInt(variation.find('.stock').val());

            if (quantity > max) {
                input.val(max);
            } else if (quantity < min) {
                input.val(min);
            } else {
                input.val(quantity);
            }

            quantityControl(variation);
        }


        $(document).ready(function () {

            // Loop all to check the status of the quantity control
            let variations = $('.variation');
            for (let i = 0; i < variations.length; i++) {
                quantityControl(variations.eq(i));
            }

            $('.quantity-input').on('change', function () {
                let current = parseInt($(this).val());
                quantityUpdate($(this).closest('.variation'), current);
            });

            $('.quantity-inc').on('click', function () {
                let input = $(this).closest('.variation').find('.quantity-input');
                let current = parseInt(input.val());
                quantityUpdate($(this).closest('.variation'), current + 1);
            });

            $('.quantity-dec').on('click', function () {
                let input = $(this).closest('.variation').find('.quantity-input');
                let current = parseInt(input.val());
                quantityUpdate($(this).closest('.variation'), current - 1);
            });


            // function quantityReset() {
            //     $("#quantity").val(1);
            //     $("#quantity").removeAttr("disabled");
            //     $(".quantity-decrease-button").attr("disabled", "disabled");
            //     $(".quantity-increase-button").removeAttr("disabled");
            // }
            //
            // function quantityControlDisable() {
            //     $("#quantity").val(0);
            //     $("#quantity").attr("disabled", "disabled");
            //     $(".quantity-decrease-button").attr("disabled", "disabled");
            //     $(".quantity-increase-button").attr("disabled", "disabled");
            // }
            //
            // function quantityToMaxInventory(inventoryQuantity) {
            //     $("#quantity").val(inventoryQuantity);
            //     $("#quantity").removeAttr("disabled");
            //     $(".quantity-decrease-button").removeAttr("disabled");
            //     $(".quantity-increase-button").attr("disabled", "disabled");
            // }
            //
            // function quantityUnlockControl() {
            //     $(".quantity-decrease-button").removeAttr("disabled");
            //     $(".quantity-increase-button").removeAttr("disabled");
            // }


            // Selected property controller
            // $(".variety-selector li").on("click", function () {
            //
            //     var quantity = parseInt($("#quantity").val());
            //     var selectedVarietyInventory = parseInt($(this).children(".variety-inventory").val());
            //     var selectedVarietyBarcode = $(this).children(".variety-barcode").val();
            //
            //     // List responsive
            //     $(".variety-selector li").removeClass("active");
            //     $(this).addClass("active");
            //
            //     // Change the variety barcode
            //     $("#barcode").val(selectedVarietyBarcode);
            //
            //     // Change the price viewing
            //     $(".price-view").attr("hidden", "hidden");
            //     $("#variety-" + selectedVarietyBarcode).removeAttr("hidden");
            //
            //     // Change the wholesale information view
            //     if ($("#variety-" + selectedVarietyBarcode).hasClass("discounted-price")) {
            //         $(".wholesale-view").hide();
            //     } else {
            //         $(".wholesale-view").show();
            //     }
            //
            //     // Change the variety total inventory quantity
            //     $("#inventory").val(selectedVarietyInventory);
            //
            //     // Disable add to cart button if the variety total quantity is 0 (sold out)
            //     if (selectedVarietyInventory == 0) {
            //         $("#add-to-cart-button").attr("disabled", "disabled");
            //     } else {
            //         $("#add-to-cart-button").removeAttr("disabled");
            //     }
            //
            //     // Adjust quantity input to inventory maximum if quantity exceed the max inventory
            //     if (selectedVarietyInventory == 0) {
            //         quantityControlDisable();
            //     } else {
            //         if (quantity == 0) { //Previously is 0
            //             quantityReset();
            //         } else {
            //             if (quantity != 1) {
            //                 if (quantity >= selectedVarietyInventory) { // Previous quantity is larger than the current variety max inventory
            //                     quantityToMaxInventory(selectedVarietyInventory);
            //                 } else {
            //                     quantityUnlockControl();
            //                 }
            //             }
            //         }
            //     }
            //
            //     // Navigate to selected variety image
            //     var totalGeneralImg = $(".slider-container").children(".general-img").length - 2; // Get the total number of images
            //     var selectedImageIndex = totalGeneralImg; // Initialize
            //     for (i = 0; i < $(".variety-selector li").length; i++) { // Get index of the image
            //         var v = $(".variety-selector li").eq(i).children(".variety-barcode").val();
            //         if ($("#img-" + v).val() != undefined) {
            //             selectedImageIndex++;
            //             if (v === selectedVarietyBarcode) {
            //                 break;
            //             }
            //         }
            //     }
            //     if ($("#img-" + selectedVarietyBarcode).val() != undefined) slider.goTo(selectedImageIndex); // Make sure image is existed before use goto function
            // });

            //Quantity input onchange detect logic with inventory
            // $("#quantity").on("change", function () {
            //     var selectedVarietyInventory = parseInt($(".variety-selector li.active").children(".variety-inventory").val());
            //     var quantity = parseInt($("#quantity").val());
            //
            //     if (quantity >= selectedVarietyInventory) { // Previous quantity is larger than the current variety max inventory
            //         quantityToMaxInventory(selectedVarietyInventory);
            //     } else if (quantity <= 0) {
            //         quantityReset();
            //     } else {
            //         quantityUnlockControl();
            //     }
            //
            //     // Update wholesale information
            //     var quantity = parseInt($("#quantity").val());
            //     // Get wholesale range index
            //     var currentWholesaleIndex = -1; //Default does not involve in any wholesale
            //     //if($(".wholesale-view").eq(0).find(".wholesale-min").val() == 1) currentWholesaleIndex = 0; // If the first wholesale min is 1, set index to 0
            //     for (var i = 0; i < $(".wholesale-view").length; i++) {
            //         if (i != $(".wholesale-view").length - 1) {
            //             if (quantity >= $(".wholesale-view").eq(i).find(".wholesale-min").val()) {
            //                 if (quantity < $(".wholesale-view").eq(i + 1).find(".wholesale-min").val()) {
            //                     currentWholesaleIndex = i;
            //                     break;
            //                 }
            //             } else {
            //                 break; // Current quantity didnt reach wholesale min
            //             }
            //         } else {
            //             currentWholesaleIndex = $(".wholesale-view").length - 1; // Last and to infinity
            //         }
            //     }
            //
            //     // Update price view and information
            //     if (currentWholesaleIndex >= 0) {
            //         $(".price-view-normal").attr("hidden", "hidden");
            //
            //         $(".price-view-wholesale").attr("hidden", "hidden");
            //         min = $(".wholesale-view").eq(currentWholesaleIndex).find(".wholesale-min").val();
            //         $(".wholesale-" + min).removeAttr("hidden");
            //
            //         $(".wholesale-view").attr("hidden", "hidden");
            //         $(".wholesale-view").eq(currentWholesaleIndex + 1).removeAttr("hidden");
            //     } else {
            //         $(".price-view-normal").removeAttr("hidden");
            //
            //         $(".price-view-wholesale").attr("hidden", "hidden");
            //
            //         $(".wholesale-view").attr("hidden", "hidden");
            //         $(".wholesale-view").eq(0).removeAttr("hidden");
            //     }
            // });

            // Quantity controller
            // $(".quantity-button-control button").on("click", function () {
            //
            //     // Inventory quantity (max)
            //     let INVENTORY = $("#inventory").val();
            //
            //     // Current quantity
            //     var quantity = $(this).parent().children('input').val();
            //
            //     // Increase button clicked
            //     if ($(this).hasClass("quantity-increase-button")) {
            //
            //         // Increase quantity
            //         $(this).parent().children('input').val(++quantity);
            //
            //         // Disable button when reach maximum
            //         if ($(this).parent().children('input').val() == INVENTORY) {
            //             $(this).attr('disabled', 'disabled');
            //             $(this).parent().children('.quantity-decrease-button').removeAttr('disabled');
            //         } else {
            //             $(this).removeAttr('disabled');
            //             $(this).parent().children('.quantity-decrease-button').removeAttr('disabled');
            //         }
            //     }
            //     // Decrease button clicked
            //     else if ($(this).hasClass("quantity-decrease-button")) {
            //
            //         // Decrease quantity
            //         $(this).parent().children('input').val(--quantity);
            //
            //         // Disable button when reach minimum
            //         if ($(this).parent().children('input').val() == 1) {
            //             $(this).parent().children('.quantity-increase-button').removeAttr('disabled');
            //             $(this).attr('disabled', 'disabled');
            //         } else {
            //             $(this).parent().children('.quantity-increase-button').removeAttr('disabled');
            //             $(this).removeAttr('disabled');
            //         }
            //     }
            //
            //     // Update wholesale information
            //     var quantity = parseInt($(this).parent().children('input').val());
            //     // Get wholesale range index
            //     var currentWholesaleIndex = -1; //Default does not involve in any wholesale
            //     //if($(".wholesale-view").eq(0).find(".wholesale-min").val() == 1) currentWholesaleIndex = 0; // If the first wholesale min is 1, set index to 0
            //     for (var i = 0; i < $(".wholesale-view").length; i++) {
            //         if (i != $(".wholesale-view").length - 1) {
            //             if (quantity >= $(".wholesale-view").eq(i).find(".wholesale-min").val()) {
            //                 if (quantity < $(".wholesale-view").eq(i + 1).find(".wholesale-min").val()) {
            //                     currentWholesaleIndex = i;
            //                     break;
            //                 }
            //             } else {
            //                 break; // Current quantity didnt reach wholesale min
            //             }
            //         } else {
            //             currentWholesaleIndex = $(".wholesale-view").length - 1; // Last and to infinity
            //         }
            //     }
            //
            //     // Update price view and information
            //     if (currentWholesaleIndex >= 0) {
            //         $(".price-view-normal").attr("hidden", "hidden");
            //
            //         $(".price-view-wholesale").attr("hidden", "hidden");
            //         min = $(".wholesale-view").eq(currentWholesaleIndex).find(".wholesale-min").val();
            //         $(".wholesale-" + min).removeAttr("hidden");
            //
            //         $(".wholesale-view").attr("hidden", "hidden");
            //         $(".wholesale-view").eq(currentWholesaleIndex + 1).removeAttr("hidden");
            //     } else {
            //         $(".price-view-normal").removeAttr("hidden");
            //
            //         $(".price-view-wholesale").attr("hidden", "hidden");
            //
            //         $(".wholesale-view").attr("hidden", "hidden");
            //         $(".wholesale-view").eq(0).removeAttr("hidden");
            //     }
            //
            // });

        });
    </script>

@endsection
