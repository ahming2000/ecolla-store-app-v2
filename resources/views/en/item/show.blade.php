@extends('en.layouts.app')

@section('title')
    {{ $item->name_en }} | Ecolla e口乐
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
                <li class="breadcrumb-item"><a href="{{ url('/en/item') }}">Item List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Made In {{ $item->origin_en }}</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $item->name_en }}</li>
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
                        @if($item->getTotalImageCount() != 0)<button class="slider-control-prev"><</button>@endif
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
                        @if($item->getTotalImageCount() != 0)<button class="slider-control-next">></button>@endif
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

            <div class="col-12 col-lg-7 mb-4 p-4">
                <div class="row">

                    {{-- Item category badge --}}
                    <div class="col-12 mb-3">
                        @foreach($item->categories as $cat)
                            <a class="no-anchor-style" href="{{ url('/en/item?category=' . $cat->name_en) }}">
                                <span class="badge rounded-pill mr-1 p-2"
                                      style="background-color: mediumpurple">
                                    {{ $cat->name_en }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                    {{-- Item category badge --}}

                    {{-- Item Name --}}
                    <div class="col-12">
                        <div class="h2 font-weight-bold">{{ $item->name_en }}</div>
                    </div>
                    {{-- Item Name --}}

                    {{-- Item Util Info --}}
                    <div class="col-12 mb-3">
                        <div class="h6 text-muted">
                            <span>{{ $item->util->sold }} sold out</span> |
                            <span>{{ $item->util->view_count }} views</span>
                        </div>
                    </div>
                    {{-- Item Util Info --}}

                    <div class="col-12">

                        <form action="{{ url('/en/item/' . $item->id) }}" method="post">
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
                                                    {{ $variation->name_en }}
                                                    {{-- Item Name --}}

                                                    {{-- TODO - Discount Percentage --}}

                                                    @if($variation->stock == 0)
                                                        <span class="badge rounded-pill bg-danger mx-1">sold<span>
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
                                                                        <strong>RM{{ number_format($variation->price, 2, '.', '') }}</strong>
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
                                        Buy util{{ $w->min }}to buy it as wholesale price RM{{ number_format($item->getFirstVariation()->price * $w->rate, 2, '.', '') }}
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
                                    <i class="icofont icofont-shopping-cart ml-1"></i> Add to Cart
                                </button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>

        </div>

        {{-- Item Description --}}
        <div class="h2" style="font-weight: bold">Item Description</div>
        <div class="row mb-3">
            <div class="col-12">
                <textarea class="form-control" id="desc" readonly hidden>{{ $item->desc }}</textarea>
                <p id="desc-display"></p>
            </div>
        </div>
        {{-- Item Description --}}

        {{-- Recommendation (Random) --}}
        <div class="h2">You may like</div>
        <div class="row mb-3">
            <div class="owl-carousel mousescroll owl-theme">
                @foreach($randomItems as $randomItem)
                    <div class="item">
                        <a class="no-anchor-style" href="/en/item/{{ $randomItem->id }}">
                            <div class="card">

                                <img class="card-img-top" src="{{ $randomItem->getCoverImage() }}" loading="lazy">

                                <div class="card-body">
                                    <div class="h5 card-title text-truncate">{{ $randomItem->name_en }}</div>
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
        <div class="h2">Similar</div>
        <div class="row mb-3">
            <div class="owl-carousel mousescroll owl-theme">
                @foreach($mayLikeItems as $mayLikeItem)
                    <div class="item">
                        <a class="no-anchor-style" href="/en/item/{{ $mayLikeItem->id }}">
                            <div class="card">

                                <img class="card-img-top" src="{{ $mayLikeItem->getCoverImage() }}" loading="lazy">

                                <div class="card-body">
                                    <div class="h5 card-title text-truncate">{{ $mayLikeItem->name_en }}</div>
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
        });
    </script>

@endsection








