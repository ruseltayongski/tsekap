<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barangay;
use App\Muncity;
use App\Province;
use App\Http\Requests;

class LocationCtrl extends Controller
{
    static function getBarangay($id)
    {
        return Barangay::find($id)->description;
    }

    static function getMuncity($id)
    {
        return Muncity::find($id)->description;
    }

    static function getProvince($id)
    {
        return Province::find($id)->description;
    }

    public  function getMuncityByProvince($id)
    {
        return Muncity::where('province_id',$id)->orderBy('description','asc')->get();
    }

    public  function getBarangayByMuncity($id)
    {
        return Barangay::where('muncity_id',$id)->orderBy('description','asc')->get();
    }
}
