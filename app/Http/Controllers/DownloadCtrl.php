<?php

namespace App\Http\Controllers;

use App\Muncity;
use App\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function generateDownload($id, $prov_desc, $mun_id, $mun_desc){
//        $id = $req->province_id;
//        $prov_desc = $req->province_desc;
//        $mun_id = $req->muncity_id;
//        $mun_desc = $req->muncity_desc;
//        $year = isset($req->year_selected) ? $req->year_selected : Carbon::now()->format('Y');

        $year = Carbon::now()->format('Y');

        $start = $year.'-01-01';
        $end = $year.'-12-31';
        $connection = 'db_'.$year;

        $profileservices = ProfileServices::on($connection)->select('profileservices.dateProfile','profileservices.service_id','profileservices.bracket_id','profileservices.barangay_id','profileservices.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('tsekap_main.profile','profileservices.profile_id','=','profile.id')
            ->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<=',$end);

        $profilecases = ProfileCases::on($connection)->select('profilecases.dateProfile','profilecases.case_id','profilecases.bracket_id','profilecases.barangay_id','profilecases.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('tsekap_main.profile','profilecases.profile_id','=','profile.id')
            ->where('profilecases.dateProfile','>=',$start)
            ->where('profilecases.dateProfile','<=',$end);

        $femalestatus = FemaleStatus::on($connection)->select('femalestatus.dateProfile','femalestatus.status','femalestatus.code','femalestatus.barangay_id','femalestatus.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('tsekap_main.profile','femalestatus.profile_id','=','profile.id')
            ->where('femalestatus.dateProfile','>=',$start)
            ->where('femalestatus.dateProfile','<=',$end);

        $serviceoption = ServiceOption::on($connection)->select('serviceoption.dateProfile','serviceoption.option','serviceoption.status','serviceoption.barangay_id','serviceoption.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('tsekap_main.profile','serviceoption.profile_id','=','profile.id')
            ->where('serviceoption.dateProfile','>=',$start)
            ->where('serviceoption.dateProfile','<=',$end)
            ->get();

        $user_priv = Auth::user()->user_priv;
        if($user_priv == 3) {
            $filename = Muncity::find($mun_id)->description.'-'.date('Y-m-d');
            $profile = Profile::where('muncity_id',$mun_id)->get();

            $profileservices = $profileservices->where('profileservices.muncity_id',$mun_id)->get();
            $profilecases = $profilecases->where('profilecases.muncity_id',$mun_id)->get();
            $femalestatus = $femalestatus->where('femalestatus.muncity_id',$mun_id)->get();
        }
        else if($user_priv == 2) {
            $filename = Barangay::find($id)->description.'-'.date('Y-m-d');
            $profile = Profile::where('barangay_id',$id)->get();
            $profileservices = $profileservices->where('profileservices.barangay_id',$id)->get();
            $profilecases = $profilecases->where('profilecases.barangay_id',$id)->get();
            $femalestatus = $femalestatus->where('femalestatus.barangay_id',$id)->get();
        }

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
