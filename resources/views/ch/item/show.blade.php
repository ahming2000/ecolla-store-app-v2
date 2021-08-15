@extends('ch.layouts.app')

@section('title')
    {{ $item->name }} | Ecolla e口乐
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>
    <style>
        .variation-discount .original-price, .wholesale-discount .original-price {
            color: grey;
            font-size: 15px;
        }

        .variation-discount .discounted-price, .wholesale-discount .discounted-price {
            color: red;
            font-weight: bold;
        }

        .no-discount .original-price{
            color: black;
        }
    </style>
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
                            <button class="slider-control-prev">
                                <
                            </button>
                        @endif

                        <div class="slider-container">
                            @if($item->images != null)
                                @foreach($item->images as $img)
                                    <img class="img-fluid general-img"
                                         src="{{ $img->image }}" loading="lazy" alt="">
                                @endforeach
                            @endif

                            @foreach($item->variations as $v)
                                @if($v->image != null)
                                    <img class="img-fluid variety-img" id="img-{{ $v->barcode }}"
                                         src="{{ $v->image }}" loading="lazy" alt="">
                                @endif
                            @endforeach
                        </div>

                        @if($item->getTotalImageCount() != 0)
                            <button class="slider-control-next">
                                >
                            </button>
                        @endif
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

                                                    {{-- Discount Percentage --}}
                                                    @if($variation->getDiscountMode() == "variation")
                                                        <span class="badge rounded-pill bg-danger me-1">
                                                            {{ $variation->getDiscountPercentage() }}% OFF
                                                        </span>
                                                    @endif

                                                    @if($variation->getDiscountMode() == "wholesale")
                                                        {{-- TODO - Wholesale Discount Percentage --}}
                                                    @endif
                                                    {{-- Discount Percentage --}}

                                                    {{-- Sold Out --}}
                                                    @if($variation->stock == 0)
                                                        <span class="badge rounded-pill bg-info mx-1">已售完<span>
                                                    @endif
                                                    {{-- Sold Out --}}

                                                </h5>

                                                {{-- Price --}}
                                                <div class="price">
                                                    @if($variation->getDiscountMode() == 'variation')
                                                        <div class="h4 price-view variation-discount">
                                                            <span class="original-price me-1">
                                                                <del>
                                                                    RM{{ number_format($variation->price, 2, '.', '') }}
                                                                </del>
                                                            </span>
                                                            <span class="discounted-price">
                                                                <strong>
                                                                    RM{{ $variation->getPrice() }}
                                                                </strong>
                                                            </span>
                                                        </div>
                                                    @else
                                                        @if($variation->getDiscountMode() == "wholesale")
                                                            {{-- TODO - Wholesale Discount Price --}}
                                                        @else
                                                            <div class="h4 price-view no-discount">
                                                                <span class="original-price">
                                                                    <strong>
                                                                        RM{{ $variation->getPrice() }}
                                                                    </strong>
                                                                </span>
                                                            </div>
                                                        @endif
                                                    @endif

{{--                                                    <span class="grey-text">--}}
{{--                                                        购买至 0 件可以以批发价 RM0.00 购买--}}
{{--                                                    </span>--}}
                                                </div>
                                                {{-- Price --}}

                                            </div>

                                            {{-- Quantity Control --}}
                                            <div class="d-flex justify-content-between align-content-center my-auto"
                                                 style="max-height: 35px">
                                                <button type="button"
                                                        class="btn btn-primary btn-sm me-3 px-3 quantity-dec" disabled>
                                                    -
                                                </button>
                                                <input type="number" class="form-control form-control-sm quantity-input"
                                                       value="0" name="variation[{{ $variation->id }}][quantity]"
                                                       style="width: 45px" disabled>
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
                @foreach($randomItems as $item)
                    <div class="item">
                        @include('ch.component.itemBox')
                    </div>
                @endforeach
            </div>
        </div>
        {{-- Recommendation (Random) --}}

        {{-- Similar (Same category) --}}
        <div class="h2">类似商品</div>
        <div class="row mb-3">
            <div class="owl-carousel mousescroll owl-theme">
                @foreach($mayLikeItems as $item)
                    <div class="item">
                        @include('ch.component.itemBox')
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
