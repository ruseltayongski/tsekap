<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SitioController extends Controller
{
    public function Sitio(){
        return view('sitio');
    }
}
