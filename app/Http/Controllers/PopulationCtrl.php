<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use App\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\ProfileServices;
use App\Http\Controllers\ParameterCtrl as Param;

class PopulationCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user_priv');
    }

    public function index(){
        $keyword = Session::get('profileKeyword');
        $province = Session::get('profileProvince');
        $muncity = Session::get('profileMuncity');
        $user = Auth::user();
        $profiles = Profile::select('profile.unique_id','profile.familyID','profile.created_at','profile.head','profile.id','profile.lname','profile.mname','profile.fname','profile.suffix','profile.dob','profile.sex','profile.barangay_id','profile.muncity_id','profile.province_id');

        if($keyword || $keyword!='' || $keyword!=null)
        {
            $profiles = $profiles->where(function($q) use ($keyword){
                $q->where('profile.fname','like',"%$keyword%")
                    ->orwhere('profile.mname','like',"%$keyword%")
                    ->orwhere('profile.lname','like',"%$keyword%")
                    ->orwhere('profile.familyID','like',"%$keyword%");
            });
        }

        if($user->user_priv == 3){
            $profiles = $profiles->where('profile.province_id',$user->province);
        }else if($province){
            $profiles = $profiles->where('profile.province_id',$province);
        }

        if(!$province){
            $profiles = $profiles->where('profile.province_id',1);
        }

        if($muncity){
            $profiles = $profiles->where('profile.muncity_id',$muncity);
        }

        $profiles = $profiles->where('profile.id','>',0)
            ->orderBy('profile.id','desc');

        $profiles = $profiles->paginate(15);
        return view('population.list',['profiles' => $profiles]);
    }

    public function searchPopulation(Request $req){
        if($req->viewAll){
            Session::forget('profileKeyword');
            Session::forget('profileProvince');
            Session::forget('profileMuncity');
            return redirect()->back();
        }

        Session::put('profileKeyword',$req->keyword);
        Session::put('profileProvince',$req->province);
        Session::put('profileMuncity',$req->muncity);
        return self::index();
    }

    public function familyMember($id)
    {
        $members = Profile::where('familyID',$id)->orderBy('fname','asc')->get();
        return $members;
    }

    public function less()
    {
        $keyword = Session::get('lessKeyword');
        $province = Session::get('lessProvince');
        $muncity = Session::get('lessMuncity');

        $user = Auth::user();

        $start = date('Y').'-01-01';
        $end = (date('Y')+1).'-01-01';

        $group1 = array('PE');
        $group2 = array('BT', 'CBC', 'URI', 'BST', 'SE', 'FBS');
        $group3 = array('HEPS', 'WM', 'HM', 'WUN', 'CNL', 'CMD', 'EE', 'ERE', 'OS', 'BP');

        $profiles = ProfileServices::select('profileservices.profile_id')
                        ->leftJoin('muncity','profileservices.muncity_id','=','muncity.id');

        if($user->user_priv == 3){
            $profiles = $profiles->where('profileservices.province_id',$user->province);
        }

        if($keyword){
            $profiles = $profiles->where('profileservices.profile_id','like',"%$keyword%");
        }
        if($province){
            $profiles = $profiles->where('muncity.province_id',$province);
        }
        if($muncity){
            $profiles = $profiles->where('profileservices.muncity_id',$muncity);
        }

        $profiles = $profiles->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<',$end)
            ->groupBy('profileservices.profile_id')
            ->get();

        $total = 0;
        $data = Profile::select('profile.unique_id','profile.familyID','profile.id','profile.head','profile.fname','profile.mname','profile.lname','profile.suffix','profile.dob','profile.sex','profile.barangay_id','profile.muncity_id','profile.province_id')
            ->where(function($q) use ($keyword){
                $q->where('profile.fname','like',"%$keyword%")
                    ->orwhere('profile.mname','like',"%$keyword%")
                    ->orwhere('profile.lname','like',"%$keyword%")
                    ->orwhere('profile.familyID','like',"%$keyword%");
            })
            ->orderBy('profile.created_at','desc');
        foreach($profiles as $p){
            $c = 0;
            $tmp = Param::groupService($group1,$p->profile_id,'','');
            if($tmp>0){
                $c++;
            }

            $tmp = Param::groupService($group2,$p->profile_id,'','');
            if($tmp>0){
                $c++;
            }

            $tmp = Param::groupService($group3,$p->profile_id,'','');
            if($tmp>0){
                $c++;
            }
            if($c > 2){
                $profile_id = $p->profile_id;
                $data = $data->where('profile.unique_id','!=',$profile_id);
            }
        }
        if($user->user_priv==3){
            $data = $data->where('profile.province_id',$user->province);
        }else if($province){
            $data = $data->where('profile.province_id',$province);
        }

        if($muncity){
            $data = $data->where('profile.muncity_id',$muncity);
        }

        $data = $data->paginate(15);

        return view('population.less',['profiles' => $data]);
    }

    public function searchLess(Request $req)
    {
        if($req->viewAll){
            Session::forget('lessKeyword');
            Session::forget('lessProvince');
            Session::forget('lessMuncity');
            return redirect()->back();
        }

        Session::put('lessKeyword',$req->keyword);
        Session::put('lessProvince',$req->province);
        Session::put('lessMuncity',$req->muncity);
        return self::less();
    }

    public function servicePopulation($id)
    {
        $tmp = htmlentities($id);
        $services = ProfileServices::select('profileservices.dateProfile','services.description')
            ->leftJoin('services','profileservices.service_id','=','services.id')
            ->where('profileservices.profile_id',$tmp)
            ->get();
        return $services;
    }

    public static function getDevice($profile_id)
    {
        $device = Device::where('profile_id',$profile_id)
                ->first();
        if($device)
        {
            $device = $device->device;
        }else{
            $device = '';
        }
        return $device;
    }
}
