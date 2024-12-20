<?php

namespace App\Http\Controllers\TsekapV2\Misc;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Muncity;
use App\Barangay;
use App\Province;

class MiscDataController extends Controller
{
    // # ---------- AUXILIARY FUNCTIONS ----------- # //
    
    // get province
    public function getProvince(){
        $province = Province::select('id', 'description')->get();
        return response()->json($province);
    } 
    // get municipality/city
    public function getMuncity(Request $request){
        $provinceId = $request->query('province_id');

        $muncity = Muncity::where('province_id', '=', $provinceId)
            ->select('id','province_id','description')
            ->get();

        return response()->json($muncity);
    }

    // get barangay
    public function getBarangay(Request $request){
        $muncityId = $request->query('muncity_id');

        $barangay = Barangay::where('muncity_id', '=',$muncityId)
            ->select('id','muncity_id','description')
            ->get();
        return response()->json($barangay);
    }
    // get patient risk form list
}
