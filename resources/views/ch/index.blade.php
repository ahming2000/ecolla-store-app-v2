@extends('ch.layouts.customer')

@section('title')
    Ecolla ε口乐零食店官网
@endsection

@section('extraStyle')
    <style>/*overwrite deco.css*/
        .navbar{
            background-color:transparent;
            transition: background-color 0.5s;
        }
        .navbar-change{
            background-color: #3c3e44;
            transition: background-color 0.5s;
        }
        .navbar-custom .navbar-brand{
            color: white;
        }
        .navbar-custom .navbar-nav .nav-link, .navbar-custom .fa-bars{
            color: white;
        }
    </style>
@endsection

@section('content')
    Test

@endsection

@section('welcome')
    <div class="headtext">欢迎来到
        <div class="headtext1">Ecolla ε口乐</div>
        零食店官网
    </div>
@endsection
