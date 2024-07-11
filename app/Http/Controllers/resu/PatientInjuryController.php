<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facility;
use App\Barangay;
use App\Muncity;
use App\Province;


class PatientInjuryController extends Controller
{
    //
    public function PatientInjured(){
        $user = Auth::user();

        return view('resu.manage_patient_injury.list_patient', [
            'user_priv' => $user
        ]);
    }

    public function PatientForm(){

        $facility = Facility::all();
        $province = Province::all();
        $barangay = Barangay::all();
     
        return view('resu.manage_patient_injury.patient_form',[
            'facility' => $facility,
            'province' => $province,
            'muncity' => $muncity,
            'barangay' => $barangay
        ]);
    }

    public function getMunicipal($provinceid){

      $muncity = Muncity::where('province_id', $provinceid)->get();
      
      return response()->json($muncity);
    }

    public function getBarangay($muncity_id){
        $barangay = Barangay::where('muncity_id',$muncity_id)->get();
        return response()->json($barangay);
    }

    // public function submitPatientInjury(Request $request){
    //     $data = $request->json()->all();

    //     return response()->json([
    //         'message' => 'Form data received successfully',
    //         'data' => $data
    //     ]);
    // }
}
