<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerPageController extends Controller
{

    public function redirect(){
        $path = $_SERVER['REQUEST_URI'];
        return redirect("ch" . $path);
    }

    public function index(){
        return view('ch.index');
    }

    public function about(){
        return view('ch.about');
    }

}
