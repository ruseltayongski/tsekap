<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    public function forbidden(){
        return view('resu.403forbidden');
    }

    public function index(){
        
       return view('resu.index');
    }
}
