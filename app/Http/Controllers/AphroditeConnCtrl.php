<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AphroditeConnCtrl extends Controller
{
    static function AphroditeConn(){
        return mysqli_connect("192.168.81.5","rtayong","rtayong","tsekap_main");
    }

}
