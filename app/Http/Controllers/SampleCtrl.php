<?php

namespace App\Http\Controllers;

use App\ServiceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserBrgy;
use App\Http\Requests;

class SampleCtrl extends Controller
{
    //
    public function index()
    {
//        $db = 'db_'.date('Y');
//        $user = Auth::user();
//        $model = new ServiceGroup();
//        $model->setConnection($db);
//        $count = $model->where('group1',1)
//            ->where('group2',1)
//            ->where('group3',1)
//            ->get();
//        dd($count);
        $db = 'db_'.date('Y');
        $user = Auth::user();
        $start = date('Y').'-01-01';
        $end = (date('Y')+1).'-01-01';
        $servicegroup = new ServiceGroup();
        $servicegroup->setConnection($db);

        $count = $servicegroup->leftJoin('tsekap_main.muncity','servicegroup.muncity_id','=','muncity.id')
            ->where('servicegroup.group1',1)
            ->where('servicegroup.group2',1)
            ->where('servicegroup.group3',1);

        $level = 'barangay';
        if($level === 'province'){
            $count = $count->where('tsekap_main.muncity.province_id',$user->province);
        }else if($level === 'muncity'){
            $count = $count->where('servicegroup.muncity_id',$user->muncity);
        }else if($level === 'barangay'){

            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $count = $count->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('servicegroup.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $count = $count->where('servicegroup.barangay_id',0);
            }
        }
        $count = $count->where(function($q){
            $q->where('servicegroup.sex','Male')
                ->orwhere('servicegroup.sex','Female');
        });
        $count = $count->where('servicegroup.dateProfile','>=',$start)
            ->where('servicegroup.dateProfile','<',$end)
            ->count();
        dd($count);
    }
}
