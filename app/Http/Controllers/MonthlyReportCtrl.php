<?php

namespace App\Http\Controllers;

use App\ProfileServices;
use App\Service;
use App\ServiceOption;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\UserBrgy;

class MonthlyReportCtrl extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function countService($code,$month,$year)
    {
        $start = "$year-$month-01";
        $end = "$year-$month-31";
        if($month==="ALL")
        {
            $start = "$year-01-01";
            $end = "$year-12-31";
        }

        if($code==='obese')
        {
            return self::serviceOption($code,$month,$year);
        }else if($code==='under'){
            return self::serviceOption($code,$month,$year);
        }else if($code==='stunted'){
            return self::serviceOption($code,$month,$year);
        }else{
            $service_id = Service::where('code',strtoupper($code))->first()->id;

            $brackets = self::brackets();

            $user = Auth::user();
            $province_id = $user->province;
            $muncity_id = $user->muncity;
            $db = 'db_'.$year;
            $services = new ProfileServices();
            $services->setConnection($db);
            $data = array();
            $male = 0;
            $female = 0;
            foreach($brackets as $b)
            {
                $bracket = $b[0];
                $status = $b[1];
                $count = $services->where('bracket_id',$bracket)
                    ->where('service_id',$service_id);

                if($bracket==5|| $bracket==6)
                {
                    if($status=='Male')
                    {
                        $count = $count->where('sex',$status);
                    }else{
                        $count = $count->where('status',$status);
                    }
                }else{
                    $count = $count->where('sex',$status);
                }
                if($user->user_priv == 3){
                    //$count = $count->where('muncity.province_id',$province_id);
                }else if($user->user_priv == 0){
                    //$count = $count->where('profileservices.muncity_id',$muncity_id);
                }else if($user->user_priv == 2){
                    $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
                    $count = $count->where(function($q) use ($tmpBrgy){
                        foreach($tmpBrgy as $tmp){
                            $q->orwhere('barangay_id',$tmp->barangay_id);
                        }
                    });
                    if(count($tmpBrgy)==0){
                        $count = $count->where('profileservices.barangay_id',0);
                    }
                }
                $count = $count->where('dateProfile','>=',$start)
                    ->where('dateProfile','<=',$end)
                    ->groupBy('profile_id')
                    ->get();
                $count = count($count);

                if($status=='Male')
                {
                    $male = $male + $count;
                }else{
                    $female = $female + $count;
                }
                $data[] = $count;
            }
            $data[] = $male;
            $data[] = $female;
            $data[] = $male + $female;

            return $data;
        }
    }

    public function serviceOption($code,$month,$year)
    {
        $start = "$year-$month-01";
        $end = "$year-$month-31";
        if($month==="ALL")
        {
            $start = "$year-01-01";
            $end = "$year-12-31";
        }
        $status = 0;
        $service = '';
        if($code=='obese') {
            $status = 1;
            $service = 'weight';
        }else if($code=='under'){
            $status = 2;
            $service = 'weight';
        }else if($code=='stunted'){
            $status = 1;
            $service = 'height';
        }

        $brackets = self::brackets();

        $user = Auth::user();
        $province_id = $user->province;
        $muncity_id = $user->muncity;
        $db = 'db_'.$year;
        $options = new ServiceOption();
        $options->setConnection($db);
        $data = array();
        $male = 0;
        $female = 0;
        foreach($brackets as $b)
        {
            $bracket = $b[0];
            $sex = $b[1];

            $count = $options->leftJoin('profileservices','profileservices.profile_id','=','serviceoption.profile_id')
                ->where('profileservices.bracket_id',$bracket)
                ->where('serviceoption.option',$service)
                ->where('serviceoption.status',$status);

            if($bracket==5|| $bracket==6)
            {
                if($status=='Male')
                {
                    $count = $count->where('profileservices.sex',$sex);
                }else{
                    $count = $count->where('profileservices.status',$sex);
                }
            }else{
                $count = $count->where('profileservices.sex',$sex);
            }
            if($user->user_priv == 3){
                //$count = $count->where('muncity.province_id',$province_id);
            }else if($user->user_priv == 0){
                //$count = $count->where('serviceoption.muncity_id',$muncity_id);
            }else if($user->user_priv == 2){
                $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
                $count = $count->where(function($q) use ($tmpBrgy){
                    foreach($tmpBrgy as $tmp){
                        $q->orwhere('serviceoption.barangay_id',$tmp->barangay_id);
                    }
                });
                if(count($tmpBrgy)==0){
                    $count = $count->where('serviceoption.barangay_id',0);
                }
            }
            $count = $count->where('serviceoption.dateProfile','>=',$start)
                ->where('serviceoption.dateProfile','<=',$end)
                ->groupBy('serviceoption.profile_id')
                ->get();
            echo 'bracket: '.$bracket . ' <br>';
            echo 'option: '.$service. ' <br>';
            echo 'status: '.$status. ' <br>';

            $count = count($count);
            echo 'count: '.$count. ' <br>';
            echo '<br>';

            if($sex=='Male')
            {
                $male = $male + $count;
            }else{
                $female = $female + $count;
            }
            $data[] = $count;
        }
        $data[] = $male;
        $data[] = $female;
        $data[] = $male + $female;

        //return $data;

    }

    public function brackets()
    {
        $data = array();
        $data[] = array('1','Male');
        $data[] = array('1','Female');
        $data[] = array('2','Male');
        $data[] = array('2','Female');
        $data[] = array('3','Male');
        $data[] = array('3','Female');
        $data[] = array('4','Male');
        $data[] = array('4','Female');
        $data[] = array('5','Male');
        $data[] = array('5','pregnant');
        $data[] = array('5','post');
        $data[] = array('5','non');
        $data[] = array('6','Male');
        $data[] = array('6','pregnant');
        $data[] = array('6','post');
        $data[] = array('6','non');
        $data[] = array('7','Male');
        $data[] = array('7','Female');
        $data[] = array('8','Male');
        $data[] = array('8','Female');

        return $data;
    }

    public function physical($start,$end)
    {

    }
}
