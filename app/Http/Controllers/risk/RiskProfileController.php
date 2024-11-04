<?php

namespace App\Http\Controllers\risk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facility;
use App\Barangay;
use App\Muncity;
use App\Province;
use App\Profile;

class RiskProfileController extends Controller     
{
    //
    
    public function getMunicipal($provinceid){

      $muncity = Muncity::where('province_id', $provinceid)
        ->select('id','province_id','description')
        ->whereNotIn('id',['63','76','80'])
        ->get(); 
        //63 is Cebu City Capital, 76 is Lapu-Lapu City, Mandaue City
      
      return response()->json($muncity);
    }

    public function getBarangay($muncity_id){
        $barangay = Barangay::where('muncity_id',$muncity_id)
            ->select('id','muncity_id','description')
            ->get();
        return response()->json($barangay);
    }
}
