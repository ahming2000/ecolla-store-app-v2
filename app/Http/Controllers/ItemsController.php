<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index(){
        return view('item.index');
    }


    public function view(){
        return view('item.view');
    }



}
