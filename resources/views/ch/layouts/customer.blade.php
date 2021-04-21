<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<?php
$cart = new \App\Session\Cart();
$cart->start();
?>

<head>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/5fd2003a920fc91564cf5d7e/default';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <style>
        body {
            font-family: "Roboto", sans-serif;
        }
    </style>

    @yield('extraStyle')

</head>

<body>

@yield('extraScript')

<header>

    @yield('welcome')

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/ch') }}">
                <img src="{{asset('img/icon/ecolla_icon.png')}}" width="30" height="30" class="d-inline-block align-top"
                     alt="" loading="lazy">
                ε口乐
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fa fa-bars"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/ch') }}">主页</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/ch/item') }}">所有商品列表</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/ch/payment-method') }}">付款方式</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/ch/about') }}">关于我们</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/ch/order-tracking') }}">订单追踪</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/ch/cart') }}"><i
                                class="icofont icofont-shopping-cart mx-1"></i><span><?= $cart->getCartCount() ?></span></a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            华文
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/en' . substr($_SERVER['REQUEST_URI'], 3)) }}">English</a></li>
                        </ul>
                    </li>
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
                <img src="{{ asset('img/icon/ecolla_icon.png') }}" width="20" height="20" alt="logo" loading="lazy">
                <span class="font-color">ε口乐 Ecolla</span>
            </div>
        </div>
    </div>
</footer>

<script>
    $(document).ready(function () {

        function getCurrentFileName() {
            const pagePathName = $(location).attr('href');
            return pagePathName.substring(pagePathName.lastIndexOf("/") + 1);
        }

        if (getCurrentFileName() === "ch") {
            $(".navbar-nav li:nth-child(1)").addClass("active");
        } else if (getCurrentFileName() === "item") {
            $(".navbar-nav li:nth-child(2)").addClass("active");
        } else if (getCurrentFileName() === "payment-method") {
            $(".navbar-nav li:nth-child(3)").addClass("active");
        } else if (getCurrentFileName() === "about") {
            $(".navbar-nav li:nth-child(4)").addClass("active");
        } else if (getCurrentFileName() === "order-tracking") {
            $(".navbar-nav li:nth-child(5)").addClass("active");
        } else if (getCurrentFileName() === "cart") {
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

@yield('extraScriptEnd')

</body>
</html>
