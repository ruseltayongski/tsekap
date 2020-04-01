<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;

class DengController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function form(){
        return view('dengvaxiav2.form');
    }

    public function pdf(){
        $size = 'a4';
        $orientation = 'portrait';
        $display = "<h1>Hello World!</h1>";
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($display);
        return $pdf->setPaper($size, $orientation)->stream();
    }
}