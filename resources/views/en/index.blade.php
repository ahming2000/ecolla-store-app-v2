@extends('en.layouts.customer')

@section('title')
    Ecolla Official Snack Shop
@endsection

@section('extraStyle')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>

    <style>
        body main{
            margin-top: 55px;
        }

        .welcome-text{
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

        .highlighted{
            color: #F02B73;
            display: inline;
        }

        .slider-control-prev, .slider-control-next {
            position: absolute;
            background-color: rgba(153,153,153, 0.5);
            border: none;
            font-size: 20px;
            cursor: pointer;
            z-index: 2;
        }

        .slider-control-prev, .slider-control-next{
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

@section('extraScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>
    <script src="{{ asset('vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-mousewheel-master/jquery.mousewheel.min.js') }}"></script>
@endsection

@section('content')
    <main>
        <div class="welcome-text mb-3">
            Welcome to
            <div class="highlighted">Ecolla</div>
            Snack Shop
        </div>

        <div class="container">

            <div class="row mb-3">
                <div class="col-md-10 col-sm-12 offset-md-1 slider-control-main-container">
                    <div class="slider-control-prev rounded">
                        <img class="img-fluid" src="{{ asset('img/alt/prev-button-alt.png') }}" loading="lazy"/>
                    </div>
                    <div class="slider-control-next rounded">
                        <img class="img-fluid" src="{{ asset('img/alt/next-button-alt.png') }}" loading="lazy"/>
                    </div>
                    <div class="slider-container">

                        @foreach($adsImages as $image)
                            <img class="img-fluid" src="{{ asset($image) }}" loading="lazy"/>
                        @endforeach

                    </div>
                </div>
            </div>

            @foreach($itemsGroup as $group)
                <section class="row mb-3">
                    <div class="col-md-10 col-sm-12 offset-md-1">
                        @if(!empty($group['items']->toArray()))
                            <div class="h2">{{ $group['name_en'] }}</div>
                        @endif

                        <div class="owl-carousel mousescroll owl-theme">
                            @foreach($group['items'] as $item)
                                <div class="item">
                                    <div class="card">
                                        <a href="{{ url('/en/item/' . $item->name_en) }}">
                                            <img class="card-img-top"
                                                 loading="lazy"
                                                 src="{{ $item->getCoverImage() }}">

                                            <div class="card-body">
                                                <div class="card-title text-truncate"
                                                     style="color: black">{{ $item->name_en }}
                                                </div>
                                                <p class="card-text text-muted">
                                                    @if($item->getPriceRange()['min'] == $item->getPriceRange()['max'])
                                                        RM{{ $item->getPriceRange()['min'] }}
                                                    @else
                                                        RM{{ $item->getPriceRange()['min'] }} -
                                                        RM{{ $item->getPriceRange()['max'] }}
                                                    @endif
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
    </main>
@endsection

@section('extraScriptEnd')
    <script>

        var slider = tns({
            container: '.slider-container',

            controlsContainer: '.slider-control-main-container',
            prevButton: '.slider-control-prev',
            nextButton: '.slider-control-next',

            nav: false,
            mouseDrag: true,
            autoplay: true,
            autoplayHoverPause: true,
            autoplayButtonOutput: false,

            responsive: {
                992: {
                    items: 5,
                    slideBy: 1,
                },
                768: {
                    items: 4,
                    slideBy: 1,
                },
                576: {
                    items: 3,
                    slideBy: 1,
                },
                450: {
                    items: 3,
                    slideBy: 1,
                },
                200: {
                    items: 2,
                    slideBy: 1,
                },
            },
        });

        // Start autoplay
        slider.play();

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
@endsection
