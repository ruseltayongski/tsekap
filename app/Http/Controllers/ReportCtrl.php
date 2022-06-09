<?php

namespace App\Http\Controllers;

use App\ServiceGroup;
use Illuminate\Http\Request;
use App\Province;
use App\Muncity;
use App\Barangay;
use App\Profile;
use App\ProfileServices;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Session as Sess;

class ReportCtrl extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {

    }

    public function monthly(Request $req){
        $month = isset($req->month) ? $req->month : date('m');
        $year = isset($req->year) ? $req->year: date('Y');

        return view('report.monthly',['month' => $month, 'year' => $year]);
    }

    public function status(Request $req)
    {
        if($req->province_id!=0){
            Session::put('province_id',$req->province_id);
            $province_id = $req->province_id;
        }else if($req->province_id=='all'){
            $province_id = 0;
            Session::forget('province_id');
        }else{
            $province_id = Session::get('province_id');
        }

        if($req->muncity_id!=0){
            Session::put('muncity_id',$req->muncity_id);
            $muncity_id = $req->muncity_id;
        }else if($req->muncity_id=='all'){
            $muncity_id = 0;
            Session::forget('muncity_id');
        }else{
            $muncity_id = Session::get('muncity_id');
        }

        if($muncity_id){
            $title = Muncity::find($muncity_id)->description;
            $sub = \DB::connection('mysql')->select("call getBarangay('$muncity_id')");;
            $level = 'brgy';
        }else if($province_id){
            $title = Province::find($province_id)->description;
            $sub = Muncity::select('muncity.id','muncity.description',DB::raw("SUM(barangay.target) as target"))
                ->leftJoin('barangay','barangay.muncity_id','=','muncity.id')
                ->orderBy('muncity.description','asc')
                ->where('muncity.province_id',$province_id)
                ->groupBy('muncity.id')
                ->get();
            $level = 'muncity';
        }else{
            $title = 'REGION VII';
            $sub = Province::select('province.id','province.description',DB::raw("SUM(barangay.target) as target"))
                ->leftJoin('barangay','barangay.province_id','=','province.id')
                ->orderBy('province.description','asc');
            if(Auth::user()->user_priv==3){
                $sub = $sub->where('province.id',Auth::user()->province);
            }
            $sub = $sub->groupBy('province.id')
                ->get();
            $level = 'province';
        }
        return view('report.status',[
            'province_id'=>$province_id,
            'muncity_id'=>$muncity_id,
            'title' => $title,
            'sub' => $sub,
            'level' => $level,
        ]);
    }

    static function getTarget($level,$id)
    {
        $target = Barangay::select(DB::raw("SUM(target) as count"));
        if($level=='province'){
            $target = $target->where('province_id',$id);
        }else if($level=='muncity'){
            $target = $target->where('muncity_id',$id);
        }else if($level=='brgy'){
            $target = $target->where('id',$id);
        }
        $target = $target->first()
                    ->count;
        return $target;
    }

    static function getProfile($level,$id)
    {
        if($level=='province'){
            $profile = Profile::select(DB::raw("COUNT(id) as count"))->where('province_id',$id);
        }else if($level=='muncity'){
            $profile = Profile::select(DB::raw("COUNT(id) as count"))->where('muncity_id',$id);
        }else if($level=='brgy'){
            $profile = Profile::select(DB::raw("COUNT(id) as count"))->where('barangay_id',$id);
        }
        $profile = $profile->first()->count;
        return $profile;
    }

    static function getLackProfile($id,$condition)
    {
        $profile = Profile::select(DB::raw("COUNT(id) as count"))->where('barangay_id',$id)->where($condition,"!=","");
        $profile = $profile->first()->count;
        return $profile;
    }

    static function getProfiledByFamilyId($id)
    {
        $sub = \App\Profile::where("barangay_id",$id)->groupBy("familyId"); // Eloquent Builder instance

        $count = DB::table( DB::raw("({$sub->toSql()}) as sub") )
            ->mergeBindings($sub->getQuery())
            ->count();

        return $count;
    }

    static function countValidService2($level,$id)
    {
        $start = date('Y').'-01-01';
        $end = (date('Y')+1).'-01-01';

        $group1 = array('PE');
        $group2 = array('BT', 'CBC', 'URI', 'BST', 'SE', 'FBS', 'SPE', 'RBS','DT');
        $group3 = array('HEPS', 'WM', 'HM', 'WUN', 'CNL', 'CMD', 'EE', 'ERE', 'OS', 'BP', 'SC','CNS','RR');


        $profiles = ProfileServices::leftJoin('services','profileservices.service_id','=','services.id')
            ->leftJoin('profile','profileservices.profile_id','=','profile.unique_id');

        if($level == 'province'){
            $profiles = $profiles->where('profile.province_id',$id);
        }else if($level == 'muncity'){
            $profiles = $profiles->where('profile.muncity_id',$id);
        }else if($level == 'brgy'){
            $profiles = $profiles->where('profile.barangay_id',$id);
        }

        $profiles = $profiles->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<',$end)
            ->groupBy('profileservices.profile_id')
            ->get();
        $total = 0;

        foreach($profiles as $p){
            $c = 0;
            $tmp = self::groupService($group1,$p->unique_id);
            if($tmp>0){
                $c++;
            }

            $tmp = self::groupService($group2,$p->unique_id);
            if($tmp>0){
                $c++;
            }

            $tmp = self::groupService($group3,$p->unique_id);
            if($tmp>0){
                $c++;
            }
            if($c> 2){
                $total++;
            }
        }
        return $total;
    }

    static function countValidService($level,$id)
    {
        $start = date('Y').'-01-01';
        $end = (date('Y')+1).'-01-01';

        $group1 = array('PE');
        $group2 = array('BT', 'CBC', 'URI', 'BST', 'SE', 'FBS', 'SPE', 'RBS','DT');
        $group3 = array('HEPS', 'WM', 'HM', 'WUN', 'CNL', 'CMD', 'EE', 'ERE', 'OS', 'BP', 'SC','CNS','RR');


        $profiles = ProfileServices::select('profileservices.profile_id')
                        ->leftJoin('muncity','profileservices.muncity_id','=','muncity.id');

        if($level == 'province'){
            $profiles = $profiles->where('muncity.province_id',$id);
        }else if($level == 'muncity'){
            $profiles = $profiles->where('profileservices.muncity_id',$id);
        }else if($level == 'brgy'){
            $profiles = $profiles->where('profileservices.barangay_id',$id);
        }
        $profiles = $profiles->where(function($q){
            $q->where('profileservices.sex','Male')
                ->orwhere('profileservices.sex','Female');
        });

        $profiles = $profiles->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<',$end)
            ->groupBy('profileservices.profile_id')
            ->get();

        $total = 0;

        foreach($profiles as $p){
            $c = 0;
            $tmp = self::groupService($group1,$p->profile_id);
            if($tmp>0){
                $c++;

                $tmp = self::groupService($group2,$p->profile_id);
                if($tmp>0){
                    $c++;

                    $tmp = self::groupService($group3,$p->profile_id);
                    if($tmp>0){
                        $c++;
                    }
                }
            }

            if($c > 2){
                $total++;
            }
        }
        return $total;
    }

    public static function groupService($group,$profile_id){
        $start = date('Y').'-01-01';
        $end = (date('Y')+1).'-01-01';
        $profiles = ProfileServices::leftJoin('services','profileservices.service_id','=','services.id')
            ->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.profile_id',$profile_id)
            ->where('profileservices.dateProfile','<',$end);

        $profiles = $profiles->where(function($q) use($group){
            foreach($group as $g){
                $q->orwhere('services.code',$g);
            }
        });

        $profiles = $profiles->count();
        return $profiles;

    }

    public function online(){
        if(Auth::user()->user_priv==3){
            $count = Sess::select('users.fname','users.lname','users.contact','muncity.description as muncity','province.description as province')
                ->where('sessions.user_id','!=',null)
                ->leftJoin('users','sessions.user_id','=','users.id')
                ->leftJoin('muncity','users.muncity','=','muncity.id')
                ->leftJoin('province','users.province','=','province.id')
                ->where('users.province',Auth::user()->province)
                ->orderBy('users.province','asc')
                ->orderBy('users.lname','asc')
                ->groupBy('sessions.user_id')
                ->get();
        }else if(Auth::user()->user_priv==1){
            $count = Sess::select('users.fname','users.lname','users.contact','muncity.description as muncity','province.description as province')
                ->where('sessions.user_id','!=',null)
                ->leftJoin('users','sessions.user_id','=','users.id')
                ->leftJoin('muncity','users.muncity','=','muncity.id')
                ->leftJoin('province','users.province','=','province.id')
                ->orderBy('users.province','asc')
                ->orderBy('users.lname','asc')
                ->groupBy('sessions.user_id')
                ->get();
        }
        return $count;
    }

    public function statusDetails($mun_id, $bar_id) {
        return view('report.stat_details', ['muncity'=>$mun_id, 'bar_id'=>$bar_id]);
    }
}
