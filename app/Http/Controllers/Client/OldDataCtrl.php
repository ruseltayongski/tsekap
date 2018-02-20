<?php

namespace App\Http\Controllers\Client;

use App\Profile;
use App\ProfileCases;
use App\ProfileServices;
use App\ServiceOption;
use App\UserBrgy;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OldDataCtrl extends Controller
{
    function __construct()
    {

    }

    public function index()
    {

    }

    public function download()
    {
        return view('client.data.download-old');
    }

    function countProfile($year)
    {
        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $count = 0;
        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $count  = Profile::where('muncity_id',$muncity)->count();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            foreach($userBrgy as $row)
            {
                $count += Profile::where('barangay_id',$row->barangay_id)->count();
            }
        }
        return array(
            'count' => $count,
            'countServices' => self::countServices($year),
            'countCases' => self::countCases($year),
            'countStatus' => self::countStatus($year),
            'countOptions' => self::countOptions($year)
        );
    }

    function downloadProfile($offset)
    {
        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $data = Profile::where('muncity_id',$muncity)
                ->skip($offset)
                ->take(100)
                ->get();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            $data = Profile::select('*');
            foreach($userBrgy as $row)
            {
                $data = $data->orwhere('barangay_id',$row->barangay_id);
            }
            $data = $data->skip($offset)
                ->take(100)
                ->get();
        }
        return array(
            'data' => $data
        );
    }

    function countServices($year)
    {
        $count = 0;
        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $startDate = "$year-01-01";
        $endDate = "$year-12-31";

        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $count = ProfileServices::leftJoin('profile','profile.unique_id','=','profileservices.profile_id')
                ->where('profileservices.muncity_id',$muncity)
                ->where('profileservices.dateProfile','>=',$startDate)
                ->where('profileservices.dateProfile','<=',$endDate)
                ->where('profile.fname','!=',null)
                ->count();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            foreach($userBrgy as $row)
            {
                $count += ProfileServices::leftJoin('profile','profile.unique_id','=','profileservices.profile_id')
                    ->where('profileservices.barangay_id',$row->barangay_id)
                    ->where('profileservices.dateProfile','>=',$startDate)
                    ->where('profileservices.dateProfile','<=',$endDate)
                    ->where('profile.fname','!=',null)
                    ->count();
            }
        }
        return $count;
    }

    function getServices($year,$offset)
    {
        $data = array();

        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $startDate = "$year-01-01";
        $endDate = "$year-12-31";
        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $data = ProfileServices::leftJoin('profile','profile.unique_id','=','profileservices.profile_id')
                ->where('profileservices.muncity_id',$muncity)
                ->where('profileservices.dateProfile','>=',$startDate)
                ->where('profileservices.dateProfile','<=',$endDate)
                ->where('profile.fname','!=',null)
                ->skip($offset)
                ->take(100)
                ->get();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            $data = ProfileServices::select('*')
                ->leftJoin('profile','profileservices.profile_id','=','profile.unique_id');
            foreach($userBrgy as $row)
            {
                $data = $data->orwhere('profileservices.barangay_id',$row->barangay_id);
            }
            $data = $data->where('profileservices.dateProfile','>=',$startDate)
                ->where('profileservices.dateProfile','<=',$endDate)
                ->where('profile.fname','!=',null)
                ->skip($offset)
                ->take(100)
                ->get();
        }

        return array(
            'data' => $data
        );
    }

    function countCases($year)
    {
        $count = 0;
        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $startDate = "$year-01-01";
        $endDate = "$year-12-31";
        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $count = ProfileCases::leftJoin('profile','profile.unique_id','=','profilecases.profile_id')
                ->where('profilecases.muncity_id',$muncity)
                ->where('profilecases.dateProfile','>=',$startDate)
                ->where('profilecases.dateProfile','<=',$endDate)
                ->where('profile.fname','!=',null)
                ->count();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            foreach($userBrgy as $row)
            {
                $count += ProfileCases::leftJoin('profile','profile.unique_id','=','profilecases.profile_id')
                    ->where('profilecases.barangay_id',$row->barangay_id)
                    ->where('profilecases.dateProfile','>=',$startDate)
                    ->where('profilecases.dateProfile','<=',$endDate)
                    ->where('profile.fname','!=',null)
                    ->count();
            }
        }
        return $count;
    }

    function getCases($year,$offset)
    {
        $data = array();

        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $startDate = "$year-01-01";
        $endDate = "$year-12-31";
        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $data = ProfileCases::leftJoin('profile','profile.unique_id','=','profilecases.profile_id')
                ->where('profilecases.muncity_id',$muncity)
                ->where('profilecases.dateProfile','>=',$startDate)
                ->where('profilecases.dateProfile','<=',$endDate)
                ->where('profile.fname','!=',null)
                ->skip($offset)
                ->take(100)
                ->get();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            $data = ProfileCases::select('*')
                    ->leftJoin('profile','profile.unique_id','=','profilecases.profile_id');
            foreach($userBrgy as $row)
            {
                $data = $data->orwhere('profilecases.barangay_id',$row->barangay_id);
            }
            $data = $data->where('profilecases.dateProfile','>=',$startDate)
                ->where('profilecases.dateProfile','<=',$endDate)
                ->where('profile.fname','!=',null)
                ->skip($offset)
                ->take(100)
                ->get();
        }

        return array(
            'data' => $data
        );
    }

    function countOptions($year)
    {
        $count = 0;
        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $startDate = "$year-01-01";
        $endDate = "$year-12-31";
        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $count = ServiceOption::leftJoin('profile','profile.unique_id','=','serviceoption.profile_id')
                ->where('serviceoption.muncity_id',$muncity)
                ->where('serviceoption.dateProfile','>=',$startDate)
                ->where('serviceoption.dateProfile','<=',$endDate)
                ->where('profile.fname','!=',null)
                ->count();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            foreach($userBrgy as $row)
            {
                $count += ServiceOption::leftJoin('profile','profile.unique_id','=','serviceoption.profile_id')
                    ->where('serviceoption.barangay_id',$row->barangay_id)
                    ->where('serviceoption.dateProfile','>=',$startDate)
                    ->where('serviceoption.dateProfile','<=',$endDate)
                    ->where('profile.fname','!=',null)
                    ->count();
            }
        }
        return $count;
    }

    function getOptions($year,$offset)
    {
        $data = array();

        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $startDate = "$year-01-01";
        $endDate = "$year-12-31";
        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $data = ServiceOption::leftJoin('profile','profile.unique_id','=','serviceoption.profile_id')
                ->where('serviceoption.muncity_id',$muncity)
                ->where('serviceoption.dateProfile','>=',$startDate)
                ->where('serviceoption.dateProfile','<=',$endDate)
                ->where('profile.fname','!=',null)
                ->skip($offset)
                ->take(100)
                ->get();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            $data = ServiceOption::select('*')
                    ->leftJoin('profile','profile.unique_id','=','serviceoption.profile_id');
            foreach($userBrgy as $row)
            {
                $data = $data->orwhere('serviceoption.barangay_id',$row->barangay_id);
            }
            $data = $data->where('serviceoption.dateProfile','>=',$startDate)
                ->where('serviceoption.dateProfile','<=',$endDate)
                ->where('profile.fname','!=',null)
                ->skip($offset)
                ->take(100)
                ->get();
        }

        return array(
            'data' => $data
        );
    }

    function countStatus($year)
    {
        $count = 0;
        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $startDate = "$year-01-01";
        $endDate = "$year-12-31";
        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $count = ProfileServices::leftJoin('profile','profile.unique_id','=','profileservices.profile_id')
                ->where('profileservices.muncity_id',$muncity)
                ->where('profileservices.dateProfile','>=',$startDate)
                ->where('profileservices.dateProfile','<=',$endDate)
                ->where('profileservices.status','!=','')
                ->where('profile.fname','!=',null)
                ->count();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            foreach($userBrgy as $row)
            {
                $count += ProfileServices::leftJoin('profile','profile.unique_id','=','profileservices.profile_id')
                    ->where('profileservices.barangay_id',$row->barangay_id)
                    ->where('profileservices.dateProfile','>=',$startDate)
                    ->where('profileservices.dateProfile','<=',$endDate)
                    ->where('profileservices.status','!=','')
                    ->where('profile.fname','!=',null)
                    ->count();
            }
        }
        return $count;
    }

    function getStatus($year,$offset)
    {
        $data = array();

        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $startDate = "$year-01-01";
        $endDate = "$year-12-31";
        if($priv==0)
        {
            $muncity = Auth::user()->muncity;
            $data = ProfileServices::leftJoin('profile','profile.unique_id','=','profileservices.profile_id')
                ->leftJoin('services','services.id','=','profileservices.service_id')
                ->where('profileservices.muncity_id',$muncity)
                ->where('profileservices.dateProfile','>=',$startDate)
                ->where('profileservices.dateProfile','<=',$endDate)
                ->where('profileservices.status','!=','')
                ->where('profile.fname','!=',null)
                ->skip($offset)
                ->take(100)
                ->get();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            $data = ProfileServices::select('*')
                ->leftJoin('profile','profile.unique_id','=','profileservices.profile_id')
                ->leftJoin('services','services.id','=','profileservices.service_id');
            foreach($userBrgy as $row)
            {
                $data = $data->orwhere('profileservices.barangay_id',$row->barangay_id);
            }
            $data = $data->where('profileservices.dateProfile','>=',$startDate)
                ->where('profileservices.dateProfile','<=',$endDate)
                ->where('profileservices.status','!=','')
                ->where('profileservices.status','!=','')
                ->where('profile.fname','!=',null)
                ->skip($offset)
                ->take(100)
                ->get();
        }

        return array(
            'data' => $data
        );
    }
}
