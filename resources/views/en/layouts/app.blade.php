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

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendor/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <style>
        body {
            font-family: "Roboto", sans-serif;
        }

        /* Header */
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
            border-top: 2px solid #F02B73;
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

    @yield('style')

    @yield('extraStyle') {{-- TODO - Plan to remove later on --}}

</head>

<body>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<header>

    <a href="https://wa.link/2e1z4h" title="Contact Us with WhatsApp!" target="_blank" class="whatsapp-button">
        <i class="icofont icofont-brand-whatsapp"></i>
    </a>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow">
        <div class="container" id="nav-container">
            <a class="navbar-brand" href="{{ url('/en') }}">
                <img src="{{asset('img/icon/ecolla_icon.png')}}"
                     width="30" height="30"
                     class="d-inline-block align-top"
                     alt="" loading="lazy">
                Ecolla
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/en/item') }}">Home Page</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/en/payment-method') }}">Payment Method</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/en/order-tracking') }}">Order Tracking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/en/cart') }}">
                            <i class="icofont icofont-shopping-cart mx-1"></i><?= $cart->getCartCount() ?>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            English
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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
            $(".navbar-nav li:nth-child(1)").attr("aria-current", "page");
        } else if (getCurrentFileName() === "item") {
            $(".navbar-nav li:nth-child(1)").addClass("active");
            $(".navbar-nav li:nth-child(1)").attr("aria-current", "page");
        } else if (getCurrentFileName() === "payment-method") {
            $(".navbar-nav li:nth-child(2)").addClass("active");
            $(".navbar-nav li:nth-child(2)").attr("aria-current", "page");
        }else if (getCurrentFileName() === "order-tracking") {
            $(".navbar-nav li:nth-child(3)").addClass("active");
            $(".navbar-nav li:nth-child(3)").attr("aria-current", "page");
        } else if (getCurrentFileName() === "cart") {
            $(".navbar-nav li:nth-child(4)").addClass("active");
            $(".navbar-nav li:nth-child(4)").attr("aria-current", "page");
        }
    });
</script>

@yield('script')

@yield('extraScript') {{-- TODO - Plan to remove later on --}}

@yield('extraScriptEnd') {{-- TODO - Plan to remove later on --}}

</body>
</html>
