@extends('en.layouts.customer')

@section('extraStyle')
    <style>/*overwrite deco.css*/
        .navbar {
            background-color: transparent;
            transition: background-color 0.5s;
        }

        .navbar-change {
            background-color: #3c3e44;
            transition: background-color 0.5s;
        }

        .navbar-custom .navbar-brand {
            color: white;
        }

        .navbar-custom .navbar-nav .nav-link, .navbar-custom .fa-bars {
            color: white;
        }
    </style>
@endsection

@section('content')
    English Page Testing

@endsection

@section('welcome')
    <div class="headtext">Welcome to
        <div class="headtext1"> Ecolla</div>
        Official Snack Shop
    </div>
@endsection
