<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Barangay;
use App\Profile;
use App\FamilyProfile;
use App\ServiceOption;
use App\ProfileServices;
use App\ProfileCases;
use App\FemaleStatus;
use App\Weight;
use App\Height;

class DownloadCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('auth');
    }
    public function index(Request $req){
        $province_id = $req->province_id;
        $muncity_id = $req->muncity_id;
        $data = Barangay::where('province_id',$province_id)
                ->where('muncity_id',$muncity_id)
                ->get();
        return view('report.download',[
            'province_id' => $province_id,
            'muncity_id' => $muncity_id,
            'data' => $data,
        ]);
    }

    public function generateDownload($id){
        $year = '2017';
        $start = $year.'-01-01';
        $end = $year.'-12-31';

        $filename = Barangay::find($id)->description.'-'.date('Y-m-d');
        $profile = Profile::where('barangay_id',$id)->get();
        $profileservices = ProfileServices::select('profileservices.dateProfile','profileservices.service_id','profileservices.bracket_id','profileservices.barangay_id','profileservices.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
                ->leftJoin('profile','profileservices.profile_id','=','profile.id')
                ->where('profileservices.dateProfile','>=',$start)
                ->where('profileservices.dateProfile','<=',$end)
                ->where('profileservices.barangay_id',$id)
                ->get();

        $profilecases = ProfileCases::select('profilecases.dateProfile','profilecases.case_id','profilecases.bracket_id','profilecases.barangay_id','profilecases.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('profile','profilecases.profile_id','=','profile.id')
            ->where('profilecases.dateProfile','>=',$start)
            ->where('profilecases.dateProfile','<=',$end)
            ->where('profilecases.barangay_id',$id)
            ->get();

        $femalestatus = FemaleStatus::select('femalestatus.dateProfile','femalestatus.status','femalestatus.code','femalestatus.barangay_id','femalestatus.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('profile','femalestatus.profile_id','=','profile.id')
            ->where('femalestatus.dateProfile','>=',$start)
            ->where('femalestatus.dateProfile','<=',$end)
            ->where('femalestatus.barangay_id',$id)
            ->get();

        $serviceoption = ServiceOption::select('serviceoption.dateProfile','serviceoption.option','serviceoption.status','serviceoption.barangay_id','serviceoption.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('profile','serviceoption.profile_id','=','profile.id')
            ->where('serviceoption.dateProfile','>=',$start)
            ->where('serviceoption.dateProfile','<=',$end)
            ->where('weight.barangay_id',$id)
            ->get();

        return view('report.data',[
            'filename' => $filename,
            'profile' => $profile,
            'profileservices' => $profileservices,
            'profilecases' => $profilecases,
            'femalestatus' => $femalestatus,
            'serviceoption' => $serviceoption,
        ]);
    }

    function generateUserDownload($id){
        echo $id;
    }
}
