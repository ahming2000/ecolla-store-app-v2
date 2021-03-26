<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css">

    <!-- Icofont -->
    <link rel="stylesheet" href="{{ asset('vendor/icofont/icofont.min.css')}}">

    <!-- Tiny Slider 2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.3/tiny-slider.css">

    <!-- Others -->
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css')}}"/>

    <!-- Website Icon -->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <!-- Global CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    @yield('extraStyle')

</head>

<body>

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>

<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

<!-- File upload tool -->
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>

<!-- Tiny Slider 2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"></script>

<!-- Font awesome -->
<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<!-- Other script -->
<script src="{{asset('vendor/OwlCarousel2-2.3.4/dist/owl.carousel.min.js')}}"></script>
<script src="{{asset('vendor/jquery-mousewheel-master/jquery.mousewheel.min.js')}}"></script>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/5fd2003a920fc91564cf5d7e/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<!--End of Tawk.to Script-->

<header>

    @yield('welcome')

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="{{asset('img/favicon.ico')}}" width="30" height="30" class="d-inline-block align-top"
                     alt="" loading="lazy">
                ε口乐
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="/">主页</a></li>
                    <li class="nav-item"><a class="nav-link" href="/item">所有商品列表</a></li>
                    <li class="nav-item"><a class="nav-link" href="/payment-method">付款方式</a></li>
                    <li class="nav-item"><a class="nav-link" href="/about">关于我们</a></li>
                    <li class="nav-item"><a class="nav-link" href="/order-tracking">订单追踪</a></li>
                    <li class="nav-item"><a class="nav-link" href="/cart"><i
                                class="icofont-shopping-cart mx-1"></i><span>@yield('cartCount')</span></a></li>
                </ul>
            </div>
        </div>
    </nav>


</header>

@yield('content')

<footer>
    <div class="p-4 mt-5" style="background-color:#3c3e44;">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-mb-6 col-sm-6">
                    <div class="container-fluid m-0">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.610069720882!2d101.14378741460057!3d4.328107998352038!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cae2bc71984c77%3A0x85e97a678280a2b!2s2365%2C%20Jalan%20Hala%20Timah%203%2C%20Taman%20Kolej%20Perdana%2C%2031900%20Kampar%2C%20Negeri%20Perak!5e0!3m2!1sen!2smy!4v1603436959003!5m2!1sen!2smy"
                                width="100%" height="200" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>

                <div class="col-lg-3 col-mb-3 col-sm-3">
                    <h4 class="font-color font-weight-bold">我们的位置</h4>
                    <hr class="footer-hr">
                    <p class="text-uppercase font-color">2365, Jalan Hala Timah 3 <br>Taman Kolej Perdana
                        <br>31900 Kampar Negeri Perak</p>
                </div>

                <div class="col-lg-3 col-mb-3 col-sm-3">
                    <h4 class='font-color font-weight-bold'>联系我们</h4>
                    <hr class="footer-hr">
                    <p class="font-color"><i class="fas fa-phone pr-2"></i>012-3456789</p>
                    <p class="font-color"><i class="fab fa-facebook-square pr-2"></i><a href="https://www.facebook.com/Ecolla-e%E5%8F%A3%E4%B9%90-2347940035424278">Ecolla e口乐</a></p>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="row m-0 pt-3 pb-3 logo-bt">
        <div class="col">
            <div class="text-center">
                <img src="{{ asset('img/favicon.ico') }}" width="20" height="20" alt="logo" loading="lazy">
                <span class="font-color">ε口乐</span>
            </div>
        </div>
    </div>
</footer>

<script>
    $(document).ready(function () {

        function getCurrentFileName() {
            var pagePathName = $(location).attr('href');
            var fileName = pagePathName.substring(pagePathName.lastIndexOf("/") + 1);
            return fileName;
        }

        if (getCurrentFileName() === "") {
            $(".navbar-nav li:nth-child(1)").addClass("active");
        } else if (getCurrentFileName() === "Item") {
            $(".navbar-nav li:nth-child(2)").addClass("active");
        } else if (getCurrentFileName() === "PaymentMethod") {
            $(".navbar-nav li:nth-child(3)").addClass("active");
        } else if (getCurrentFileName() === "About") {
            $(".navbar-nav li:nth-child(4)").addClass("active");
        } else if (getCurrentFileName() === "OrderTracking") {
            $(".navbar-nav li:nth-child(5)").addClass("active");
        } else if (getCurrentFileName() === "Cart") {
            $(".navbar-nav li:nth-child(6)").addClass("active");
        }

    });

    $(document).ready(function () {
        $('.navbar').addClass('navbar-custom');
        // Transition effect for navbar
        $(window).scroll(function () {
            if ($(this).scrollTop() > 5) {
                $('.navbar').addClass('navbar-change');
                $('.navbar').removeClass('navbar-custom');
            } else {
                $('.navbar').addClass('navbar-custom');
                $('.navbar').removeClass('navbar-change');
            }
        });
    });
</script>

</body>
</html>
