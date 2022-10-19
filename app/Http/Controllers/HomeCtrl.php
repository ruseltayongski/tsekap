<?php

namespace App\Http\Controllers;

use App\Muncity;
use App\Province;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Barangay;
use App\Profile;
use App\ProfileServices;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ParameterCtrl as Param;
use App\Http\Controllers\ReportCtrl as Report;

use App\Http\Requests;

class HomeCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('home');
    }

    public function countTarget($year){
        $province_id = Auth::user()->province;
        $user_priv = Auth::user()->user_priv;
        $target_col = ($year == '2022') ? 'target_2022' : 'target';
        if($user_priv==1){
            $target = Barangay::select(DB::raw("SUM(".$target_col.") as count"))->first()->count;
            if($year == '2022') {
                $countPopulation = Profile::where('updated_at','>=','2022-01-01 00:00:00')->count();
            } else {
                $countPopulation= Profile::where('created_at','<','2022-01-01 00:00:00')->count();
            }
        }else if($user_priv==3){
            $target = Barangay::select(DB::raw("SUM(".$target_col.") as count"))->where('province_id',$province_id)->first()->count;
            if($year == '2022') {
                $countPopulation = Profile::where('province_id',$province_id)->where('updated_at','>=','2022-01-01 00:00:00')->count();
            } else {
                $countPopulation = Profile::where('province_id',$province_id)->where('created_at','<','2022-01-01 00:00:00')->count();
            }
        }

        $profilePercentage = ($target > 0 && $countPopulation > 0) ? ($countPopulation / $target) * 100 : 0;

        return array(
            'target' => number_format($target),
            'countPopulation' => number_format($countPopulation),
            'profilePercentage' => number_format($profilePercentage,1)
        );
    }

    public function count($type){
        $province_id = Auth::user()->province;
        $user_priv = Auth::user()->user_priv;

        if($type=='countBarangay'){
            if($user_priv==1){
                $countBarangay = Barangay::count();
            }else if($user_priv==3){
                $countBarangay = Barangay::where('province_id',$province_id)->count();
            }
            return array('countBarangay' => number_format($countBarangay));
        }else if($type=='validServices'){
            if($user_priv==1){
                $old_target = Barangay::select(DB::raw("SUM(old_target) as count"))->first()->count;
                $target = Barangay::select(DB::raw("SUM(target) as count"))->first()->count;
                $validServices = Param::countMustService('');
            }else if($user_priv==3){
                $old_target = Barangay::select(DB::raw("SUM(old_target) as count"))->where('province_id',$province_id)->first()->count;
                $target = Barangay::select(DB::raw("SUM(target) as count"))->where('province_id',$province_id)->first()->count;
                $validServices = Param::countMustService('province');
            }
            if($validServices==0){
                $servicePercentage = 0;
            }else{
                $servicePercentage = ($validServices / $target) * 100;
            }

            return array(
                'validServices' => number_format($validServices),
                'servicePercentage' => number_format($servicePercentage,2)
            );
        }
        return false;
    }

    public function countPerProvince($id, $year) {
        $countPopulation = 0;
        $profilePercentage = 0;
        $target_col = ($year == '2022') ? 'target_2022' : 'target';

        if(!$id)
            $id = Session::get('homeProvince');

        if($id) {
            $target = Barangay::select(DB::raw("SUM(".$target_col.") as count"))->where('province_id',$id)->first()->count;
            if($year == '2022')
                $countPopulation = Profile::where('province_id', $id)->where('updated_at','>=','2022-01-01 00:00:00')->count();
            else
                $countPopulation = Profile::where('province_id', $id)->where('created_at','<','2022-01-01 00:00:00')->count();

            $profilePercentage = ($target > 0 && $countPopulation > 0) ? ($countPopulation / $target) * 100 : 0;
        }

        Session::put('homeProvince', $id);
        Session::put('homeMuncity', '');
        Session::put('homeBarangay', '');

        return array(
            'countPopulation' => number_format($countPopulation),
            'profilePercentage' => number_format($profilePercentage, 1),
            'profiled' => $countPopulation
        );
    }

    public function countPerMuncity($id, $year) {
        $countPopulation = 0;
        $profilePercentage = 0;
        $target_col = ($year == '2022') ? 'target_2022' : 'target';

        if(!$id)
            $id = Session::get('homeMuncity');

        if($id) {
            $target = Barangay::select(DB::raw("SUM(".$target_col.") as count"))->where('muncity_id',$id)->first()->count;
            if($year == '2022')
                $countPopulation = Profile::where('muncity_id', $id)->where('updated_at','>=','2022-01-01 00:00:00')->count();
            else
                $countPopulation = Profile::where('muncity_id', $id)->where('created_at','<','2022-01-01 00:00:00')->count();

            $profilePercentage = ($target > 0 && $countPopulation > 0) ? ($countPopulation / $target) * 100 : 0;
        }
        Session::put('homeMuncity', $id);
        Session::put('homeBarangay', '');

        return array(
            'countPopulation' => number_format($countPopulation),
            'profilePercentage' => number_format($profilePercentage,1),
        );
    }

    public function countPerBarangay($id, $year) {
        $countPopulation = 0;
        $profilePercentage = 0;
        $target_col = ($year == '2022') ? 'target_2022' : 'target';

        if(!$id)
            $id = Session::get('homeBarangay');

        if($id) {
            $target = Barangay::select(DB::raw("SUM(".$target_col.") as count"))->where('id',$id)->first()->count;
            if($year == '2022')
                $countPopulation = Profile::where('barangay_id', $id)->where('updated_at','>=','2022-01-01 00:00:00')->count();
            else
                $countPopulation = Profile::where('barangay_id', $id)->where('created_at','<','2022-01-01 00:00:00')->count();

            $profilePercentage = ($target > 0 && $countPopulation > 0) ? ($countPopulation / $target) * 100 : 0;
            Session::put('homeBarangay',$id);
        }
        return array(
            'countPopulation' => number_format($countPopulation),
            'profilePercentage' => number_format($profilePercentage,1),
        );
    }

    public function counts()
    {
        $province_id = Auth::user()->province;
        $user_priv = Auth::user()->user_priv;

        if($user_priv==1){
            $countBarangay = Barangay::count();
            $countPopulation = Profile::count();
            $target = Barangay::select(DB::raw("SUM(target) as count"))->first()->count;
            $validServices = Report::countValidService('','');
        }

        if($user_priv==3){
            $countBarangay = Barangay::where('province_id',$province_id)->count();
            $countPopulation = Profile::where('province_id',$province_id)->count();
            $target = Barangay::select(DB::raw("SUM(target) as count"))->where('province_id',$province_id)->first()->count;
            $validServices = Report::countValidService('province',$province_id);
        }

        if($target==0){
            $target=$countPopulation;
        }

        if($countPopulation==0){
            $profilePercentage = 0;
        }else{
            $profilePercentage = ($countPopulation / $target) * 100;
        }

        if($validServices==0){
            $servicePercentage = 0;
        }else{
            $servicePercentage = ($validServices / $target) * 100;
        }

        return array(
            'countBarangay' => number_format($countBarangay),
            'countPopulation' => number_format($countPopulation),
            'validServices' => number_format($validServices),
            'target' => number_format($target),
            'profilePercentage' => number_format($profilePercentage,1),
            'servicePercentage' => number_format($servicePercentage,1),
        );
    }

    public function chart(){
        $user = Auth::user();
        for($i=1; $i<=12; $i++){
            $new = str_pad($i, 2, '0', STR_PAD_LEFT);
            $current = '01.'.$new.'.'.date('Y');
            $data['months'][] = date('M/y',strtotime($current));
            $startdate = date('Y-m-d',strtotime($current));
            $end = '01.'.($new+1).'.'.date('Y');
            if($new==12){
                $end = '12/31/'.date('Y');
            }
            $enddate = date('Y-m-d',strtotime($end));
            $db = 'db_'.date('Y');
            $profileservices = new ProfileServices();
            $profileservices->setConnection($db);
            $count = $profileservices->leftJoin('tsekap_main.muncity as muncity','profileservices.muncity_id','=','muncity.id')
                ->where('profileservices.dateProfile','>=',$startdate)
                ->where('profileservices.dateProfile','<=',$enddate);
            if($user->user_priv == 3){
                $count = $count->where('muncity.province_id',$user->province);
            }
            $count = $count->groupBy('profile_id');
            $count = $count->get();
            $data['count'][] = count($count);
        }
        return $data;
    }
}
