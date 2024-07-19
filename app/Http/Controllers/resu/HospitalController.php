<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ResuHospitalFacility;
use Illuminate\Support\Facades\Redirect;

class HospitalController extends Controller
{
    public function index(){

        $hospital = ResuHospitalFacility::paginate(6);

        return view('resu.hospital.hospital',[
            'hospital' => $hospital
        ]);
    }

    public function SaveHospital(Request $req){

        $hospital = new ResuHospitalFacility();

        $hospital->category_name = $req->name;

        $hospital->save();

        return Redirect::back();
    }
}
