<?php

namespace App\Http\Controllers\client;

use App\dengvaxia\Pending;
use App\Http\Controllers\ParameterCtrl;
use App\Profile;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\dengvaxia\Profile as DengProfile;

class DengvaxiaCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
    }

    public function index()
    {
        $profiles = array();
        return view('client.dengvaxia.pending',[
            'profiles' => $profiles
        ]);
    }

    public function add($id)
    {
        $profile = Profile::find($id);

        return view('client.dengvaxia.add',[
            'title' => 'Add Profile',
            'profile' => $profile
        ]);
    }

    public function save(Request $req)
    {
        $profile = Profile::find($req->tsekap_id);
        $dob = date('Ymd',strtotime($profile->dob));
        $unique_id = "$profile->fname$profile->mname$profile->lname$dob$profile->barangay_id";
        $data = array(
            'unique_id' => $unique_id,
            'tsekap_id' => $req->tsekap_id,
            'list_number' => $req->list_number,
            'facility_name' => $req->facility_name,
            'lname' => $profile->lname,
            'fname' => $profile->fname,
            'mname' => $profile->mname,
            'barangay' => $profile->barangay_id,
            'muncity' => $profile->muncity_id,
            'province' => $profile->province_id,
            'dob' => $profile->dob,
            'sex' => $profile->sex,
            'dose_screened' => $req->dose_screened,
            'dose_date_given' => $req->dose_date_given,
            'dose_age' => $req->dose_age,
            'validation' => $req->validation,
            'dose_lot_no' => $req->dose_lot_no,
            'dose_batch_no' => $req->dose_batch_no,
            'dose_expiration' => $req->dose_expiration,
            'dose_AEFI' => $req->dose_AEFI,
            'remarks' => $req->remarks,
            'status' => 'pending'
        );

        DengProfile::create($data);
        return redirect('user/population/info/'.$req->tsekap_id)->with('status','add_dengvaxia');
    }

    public function validateDoseDateGiven($start,$end)
    {
        $age = ParameterCtrl::getStaticAge($start,$end);
        return $age;
    }
}
