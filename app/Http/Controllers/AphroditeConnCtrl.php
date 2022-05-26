<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AphroditeConnCtrl extends Controller
{
    static function AphroditeConn(){
        return mysqli_connect("localhost","root","adm1n","tsekap_main");
    }

}
