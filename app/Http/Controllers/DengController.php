<?php

namespace App\Http\Controllers;

class DengController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function form(){
        return view('dengvaxiav2.form');
    }

}