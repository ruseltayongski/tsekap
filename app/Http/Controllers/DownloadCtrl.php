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
        $this->middleware('auth');
    }
    public function index(Request $req){
        $this->middleware('admin');
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

    public function downloadClinicSys(Request $req) {
        $prov_id = (isset($req->province_id)) ? $req->province_id:Auth::user()->province;
        $mun_id = $req->muncity_id;
        $bar_id = $req->bar_id;
        $year = Session::get('statreport_year');
        Session::put('clinicsys', true);

        return self::generate($prov_id, $mun_id, $bar_id, $year);
    }

    public function generateDownload(Request $req){
        $prov_id = $req->province_id;
        $mun_id = $req->muncity_id;
        $bar_id = $req->bar_id;
        $year = Session::get('statreport_year');

        return self::generate($prov_id, $mun_id, $bar_id, $year);
    }
    public static function generate($prov_id, $mun_id, $bar_id, $year) {
        $year = (isset($year) && $year != '') ? $year : '2022';
        $total_target = $total_profiled = 0;
        $target_col = ($year == '2022') ? 'target_2022':'target';
        $clinicsys = Session::get('clinicsys');

        if($clinicsys) {
            $profile = Profile::select(
                'profile.id',
                'profile.familyID',
                'profile.head',
                'profile.relation',
                'profile.fname',
                'profile.mname',
                'profile.lname',
                'profile.suffix',
                'profile.dob',
                'profile.sex',
                'profile.barangay_id',
                'profile.muncity_id',
                'profile.province_id',
                'profile.updated_by',
                'profile.created_at',
                'profile.updated_at',
                'profile.household_num',
                'profile.member_others',
                \DB::raw("DATE_FORMAT(profile.dob,'%Y-%m-%d') as birthdate"),
                'profile.ip',
                'profile.four_ps',
                'profile.fourps_num',
                'profile.philhealth_categ',
                'profile.phicID',
                'profile.civil_status',
                'profile.education',
                'profile.religion',
                'profile.other_religion',
                'profile.pregnant',
                'profile.fam_plan',
                'profile.fam_plan_method',
                'profile.fam_plan_other_method',
                'profile.fam_plan_status',
                'profile.fam_plan_other_status',
                'bar.description as barangay'
            );
        } else {
            $profile = Profile::select(
                'profile.familyID',
                'profile.head',
                'profile.relation',
                'profile.fname',
                'profile.mname',
                'profile.lname',
                'profile.suffix',
                'profile.dob',
                'profile.sex',
                'profile.barangay_id',
                'profile.muncity_id',
                'profile.province_id',
                'profile.updated_by',
                'profile.created_at',
                'profile.updated_at'
            );
        }

        $profile = $profile->where('profile.province_id', $prov_id)->where('profile.muncity_id',$mun_id);
        $muncity = Muncity::where('id',$mun_id)->first();

        if(isset($bar_id) && $bar_id != '') { // barangay data will be downloaded
            $barangay = Barangay::where('id',$bar_id)->first();
            $profile = $profile->where('profile.barangay_id',$bar_id);
            $filename = $muncity->description.' ('.$barangay->description.')-'.$year;
            if($year == '2022')
                $total_target = $barangay->target_2022;
            else
                $total_target = $barangay->target;
        }
        else { // whole muncity will be downloaded
            $filename = $muncity->description.' - '.$year;
            $total_target = Barangay::select(DB::raw("SUM(".$target_col.") as target_count"))->where('muncity_id',$mun_id)->first()->target_count;
        }

        if($year == '2022')
            $profile = $profile->where('profile.updated_at','>=','2022-01-01 00:00:00');
        else
            $profile = $profile->where('profile.updated_at','<','2022-01-01 00:00:00');

        if($clinicsys) {
            $profile = $profile
                ->leftJoin('barangay as bar','bar.id','=','profile.barangay_id')
                ->orderBy('profile.familyID','asc')->get();
            $filename .= '(ICLINICSYS)';
        } else {
            $profile = $profile->orderBy('profile.updated_at','desc')->get();
        }

        $total_profiled = count($profile);

        $return_data = [
            'filename' => $filename,
            'profile' => $profile,
            'total_target' => $total_target,
            'total_profiled' => $total_profiled,
            'total_percentage' => ($total_target > 0) ? number_format($total_percentage, 1) : 0
        ];

        if($clinicsys) {
            Session::put('clinicsys',false);
            return view('report.clinicsys_data',$return_data);
        } else {
            return view('report.data',$return_data);
        }
    }
}
