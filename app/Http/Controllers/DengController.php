<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class DengController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function form(){
        return view('dengvaxiav2.form.form',[
            'profile' => Session::get('profile')
        ]);
    }

    public function pdf(){
        $size = 'a4';
        $orientation = 'landscape';
        $display = view('dengvaxiav2.pdf.pdf');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($display);
        return $pdf->setPaper($size, $orientation)->stream();
    }

    public function save(Request $request){
        return $request->all();
    }
}