<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<?php
$cart = new \App\Session\Cart();
$cart->start();
?>

<head>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-xs-kit.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <style>
        body {
            font-family: "Roboto", sans-serif;
        }

        /* Header */
        .navbar{
            transition: background-color 0.5s;
        }

        #nav-container *{
            font-weight: bolder;
            color: #F02B73;
        }

        /* Footer */
        .font-color{
            color: white;
        }
        .footer-hr{
            border: 0;
            border-top: 2px solid hotpink;
            width: 90px;
            margin: 0 0 20px;
        }
        .logo-bt{
            background-color:#303136;
        }

        /* WhatsApp Button */
        .whatsapp-button{
            width: 60px;
            height: 60px;
            background: #2fe577;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            border-radius: 50%;
            color: white;
            font-size: 30px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.25);
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 100;
            transition: background 0.25s;
            outline: blue;
            border: none;
            cursor: pointer;
        }
        .whatsapp-button:active{
            background: grey;
        }
    </style>

    @yield('extraStyle')

</head>

<body>

@yield('extraScript')

<header>

    <a href="https://wa.link/2e1z4h" title="Contact Us with WhatsApp!" target="_blank" class="whatsapp-button"><i class="icofont icofont-brand-whatsapp"></i></a>

    @yield('welcome')

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow">
        <div class="container" id="nav-container">
            <a class="navbar-brand" href="{{ url('/en') }}">
                <img src="{{asset('img/icon/ecolla_icon.png')}}" width="30" height="30" class="d-inline-block align-top"
                     alt="" loading="lazy">
                Ecolla
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="icofont icofont-navigation-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/en/item') }}">Home Page</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/en/payment-method') }}">Payment Method</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/en/order-tracking') }}">Order Tracking</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/en/cart') }}">
                            <i class="icofont icofont-shopping-cart mx-1"></i><?= $cart->getCartCount() ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            English
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/ch' . substr($_SERVER['REQUEST_URI'], 3)) }}">华文</a></li>
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
                    <h4 class="font-color font-weight-bold">Our Location</h4>
                    <hr class="footer-hr">
                    <p class="text-uppercase font-color">
                        2365, Jalan Hala Timah 3<br>
                        Taman Bandar Baru<br>
                        31900 Kampar, Perak
                    </p>
                </div>

                <div class="col-lg-3 col-mb-3 col-sm-3">
                    <h4 class='font-color font-weight-bold'>Contact Us</h4>
                    <hr class="footer-hr">
                    <span class="font-color">
                        <i class="icofont icofont-facebook pr-2"></i><a href="https://www.facebook.com/Ecolla-e%E5%8F%A3%E4%B9%90-2347940035424278" target="_blank">Ecolla Official Facebook</a>
                    </span><br>
                    <span class="font-color">
                        <i class="icofont icofont-whatsapp pr-2"></i><a href="https://wa.link/2e1z4h" target="_blank">WhatsApp Customer Services</a>
                    </span>
                </div>
            </div>

        </div>
    </div>
    </div>

    <div class="row m-0 pt-3 pb-3 logo-bt">
        <div class="col">
            <div class="text-center">
                <img src="{{asset('img/icon/ecolla_icon.png')}}" width="20" height="20" alt="logo" loading="lazy">
                <span class="font-color">e口乐 Ecolla</span>
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

        if (getCurrentFileName() === "en") {
            $(".navbar-nav li:nth-child(1)").addClass("active");
        } else if (getCurrentFileName() === "item") {
            $(".navbar-nav li:nth-child(1)").addClass("active");
        } else if (getCurrentFileName() === "payment-method") {
            $(".navbar-nav li:nth-child(2)").addClass("active");
        }else if (getCurrentFileName() === "order-tracking") {
            $(".navbar-nav li:nth-child(3)").addClass("active");
        } else if (getCurrentFileName() === "cart") {
            $(".navbar-nav li:nth-child(4)").addClass("active");
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
