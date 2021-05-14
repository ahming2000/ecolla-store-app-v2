@extends('en.layouts.customer')

@section('title')
    Ecolla Official Snack Shop
@endsection

@section('extraStyle')
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>

    <style>
        @media (max-width: 500px) {
            .welcome-text{
                background-image: url({{ asset('img/home/welcome-background-mobile.jpg') }});
            }
        }

        @media (min-width: 500px) {
            .welcome-text{
                background-image: url({{ asset('img/home/welcome-background.jpg') }});
            }
        }

        .welcome-text{
            background-position: top;
            background-repeat: no-repeat;
            background-size: cover;
            padding-top: 150px;
            color: white;
            font-size: 35px;
            height: 45vh;
            text-align: center;
        }
        .highlighted{
            color: #F02B73;
            display: inline;
        }
    </style>
@endsection

@section('extraScript')
    <script src="{{ asset('vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-mousewheel-master/jquery.mousewheel.min.js') }}"></script>
@endsection

@section('welcome')
    <div class="welcome-text">
        Welcome to
        <div class="highlighted">Ecolla</div>
        Snack Shop
    </div>
@endsection

@section('content')
    <main class="container">

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
                                        <img class="card-img-top" src="{{ $item->getCoverImage() }}">

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
    </main>
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
