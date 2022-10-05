<?php

namespace App\Http\Controllers;

use App\Muncity;
use App\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function generateDownload(Request $req){
        $id = $req->province_id;
        $mun_id = $req->muncity_id;
        $bar_id = $req->bar_id;

        return self::generate($id, $mun_id, $bar_id, $req->year_selected);
    }
    public static function generate($id, $mun_id, $bar_id, $year) {
        $withyear = (isset($year) && $year != '') ? true : false;
        $year = (isset($year) && $year != '') ? $year : Carbon::now()->format('Y');

        $start = $year.'-01-01';
        $end = $year.'-12-31';
        $connection = 'db_'.$year;

        $profileservices = ProfileServices::on($connection)->select('profileservices.dateProfile','profileservices.service_id','profileservices.bracket_id','profileservices.barangay_id','profileservices.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('tsekap_main.profile','profileservices.profile_id','=','profile.unique_id')
            ->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<=',$end);

        $profilecases = ProfileCases::on($connection)->select('profilecases.dateProfile','profilecases.case_id','profilecases.bracket_id','profilecases.barangay_id','profilecases.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('tsekap_main.profile','profilecases.profile_id','=','profile.unique_id')
            ->where('profilecases.dateProfile','>=',$start)
            ->where('profilecases.dateProfile','<=',$end);

        $femalestatus = FemaleStatus::on($connection)->select('femalestatus.dateProfile','femalestatus.status','femalestatus.code','femalestatus.barangay_id','femalestatus.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('tsekap_main.profile','femalestatus.profile_id','=','profile.unique_id')
            ->where('femalestatus.dateProfile','>=',$start)
            ->where('femalestatus.dateProfile','<=',$end);

        $serviceoption = ServiceOption::on($connection)->select('serviceoption.dateProfile','serviceoption.option','serviceoption.status','serviceoption.barangay_id','serviceoption.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('tsekap_main.profile','serviceoption.profile_id','=','profile.unique_id')
            ->where('serviceoption.dateProfile','>=',$start)
            ->where('serviceoption.dateProfile','<=',$end);

        $user = Auth::user();
        $user_priv = $user->user_priv;
        $total_target = $total_profiled = 0;

        if($user_priv == 3 || $user_priv == 1 || $user_priv == 0) {
            $filename = Muncity::find($mun_id)->description.' - '.$year;
            $profile = Profile::select(
                'familyID', 'head', 'relation',
                'fname', 'mname', 'lname', 'suffix',
                'dob', 'sex',
                'barangay_id', 'muncity_id', 'province_id', 'created_at', 'updated_at',
                'updated_by'
            )->where('province_id',$id)->where('muncity_id',$mun_id);

            $profileservices = $profileservices->where('profileservices.muncity_id',$mun_id);
            $profilecases = $profilecases->where('profilecases.muncity_id',$mun_id);
            $serviceoption = $serviceoption->where('serviceoption.muncity_id',$mun_id);

            $total_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('muncity_id',$mun_id)->first()->target_count;
            $total_profiled = Profile::where('muncity_id',$mun_id)->count();

            if(isset($bar_id) && $bar_id != '') {
                $filename = Muncity::find($mun_id)->description.' ('.Barangay::find($bar_id)->description.')-'.$year;
                $profile = $profile->where('barangay_id',$bar_id);
                $profileservices = $profileservices->where('profileservices.barangay_id',$bar_id);
                $profilecases = $profilecases->where('profilecases.barangay_id', $bar_id);
                $serviceoption = $serviceoption->where('serviceoption.barangay_id',$bar_id);
                $total_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('id',$bar_id)->first()->target_count;
                $total_profiled = Profile::where('barangay_id',$bar_id)->count();
            }

            $profileservices = $profileservices->get();
            $profilecases = $profilecases->get();
            $serviceoption = $serviceoption->get();

            if($withyear == true) {
                $profile = $profile->where('updated_at','>=',$start)->where('updated_at','<=',$end);
            }
            $profile = $profile->orderBy('id','desc')->get();
        }
        else if($user_priv == 2) {
            $filename = Barangay::find($bar_id)->description.'-'.$year;
            $profile = Profile::where('barangay_id',$bar_id)
                ->orderBy('id','desc')->get();

            $profileservices = $profileservices->where('profileservices.barangay_id',$bar_id)->get();
            $profilecases = $profilecases->where('profilecases.barangay_id',$bar_id)->get();
            $serviceoption = $serviceoption->where('serviceoption.barangay_id',$bar_id)->get();

            $total_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('id',$bar_id)->first()->target_count;
            $total_profiled = Profile::where('barangay_id',$bar_id)->count();
        }

        $total_percentage = ($total_profiled / $total_target) * 100;

        return view('report.data',[
            'filename' => $filename,
            'profile' => $profile,
            'profileservices' => $profileservices,
            'profilecases' => $profilecases,
            'femalestatus' => $femalestatus,
            'serviceoption' => $serviceoption,
            'total_target' => $total_target,
            'total_profiled' => $total_profiled,
            'total_percentage' => number_format($total_percentage, 1)
        ]);
    }
}
