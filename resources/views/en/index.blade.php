@extends('en.layouts.customer')

@section('title')
    Ecolla Official Snack Shop
@endsection

@section('extraStyle')
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>

    <style>
        .navbar {
            background-color: transparent;
        }

        @media (min-width: 200px) {
            .navbar-collapse {
                background-color: #303136;
            }
        }

        @media (min-width: 1200px) {
            .navbar-collapse {
                background-color: transparent;
            }
        }

        .navbar-change {
            background-color: #3c3e44;
            transition: background-color 0.5s;
        }
    </style>
@endsection

@section('extraScript')
    <script src="{{ asset('vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-mousewheel-master/jquery.mousewheel.min.js') }}"></script>
@endsection

@section('content')
    <main class="container">

        <!-- Shop Picture -->
        <section class="row mb-3">
            <div class="col-md-10 col-sm-12 offset-md-1">
                <div id="{{ $carousel_desc['id'] }}" class="carousel slide m-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @for($i = 0; $i < sizeof($carousel_desc['images']); $i++)
                            <li data-target='#{{ $carousel_desc['id'] }}'
                                data-slide-to='{{ $i }}' {{ $i == 0 ? "class='active'" : "" }}></li>
                    @endfor
                    <!-- Original Pattern: <li data-target="#imgSlide" data-slide-to="{slide index}"></li> -->
                    </ol>

                    <div class="carousel-inner">
                        @for($i = 0; $i < sizeof($carousel_desc['images']); $i++)
                            <div class="carousel-item {{ $i == 0 ? "active" : "" }}">
                                <img class='d-block w-100' src='{{ $carousel_desc['images'][$i] }}'
                                     data-interval='{{ $carousel_desc['interval'] }}'>
                            </div>
                    @endfor

                    <!--
                        <div class="carousel-item">
                            <img class="d-block w-100" src={img directory} data-interval="10000">
                        </div>
                     -->
                    </div>

                    <a class="carousel-control-prev" href="#{{ $carousel_desc['id'] }}" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#{{ $carousel_desc['id'] }}" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </section>
        <!-- Shop Picture -->

        @foreach($itemsGroup as $group)
            <section class="row mb-3">
                @if(!empty($group['items']->toArray()))
                    <h3 class="pt-3 pl-5">{{ $group['name'] }}</h3>
                @endif
                <div class="owl-carousel mousescroll owl-theme">
                    @foreach($group['items'] as $item)
                        <div class="item">
                            <div class="card">
                                <a href="/en/item/{{ $item->name_en }}">
                                    <img class="card-img-top" src="{{ $item->getCoverImage() }}">

                                    <div class="card-body">
                                        <h5 class="card-title text-truncate"
                                            style="color: black">{{ $item->name_en }}</h5>
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
            </section>
        @endforeach
    </main>
@endsection

@section('welcome')
    <div class="headtext" style="background-image: url({{ asset('img/ads/index-shop-bg.jpg') }})">Welcome to
        <div class="headtext1"> Ecolla</div>
        Official Snack Shop
    </div>
@endsection

@section('extraScriptEnd')
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
@endsection
