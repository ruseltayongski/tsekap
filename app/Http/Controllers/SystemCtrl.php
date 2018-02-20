<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\Profile;
use Illuminate\Http\Request;
use App\ProfileCases;
use App\ProfileServices;
use App\Http\Requests;
use App\Http\Controllers\ParameterCtrl as Param;
use App\ServiceGroup;
use App\ServiceOption;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SystemCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($process)
    {
        if($process==='profile'){
            self::checkprofile();
        }else if($process==='checkgroup'){
            self::checkgroup();
        }else if($process==='step1'){
            self::fix();
        }else if($process==='step2'){
            self::fix2();
        }else if($process==='servicegroup'){
            self::servicegroup();
        }else if($process==='transfer'){
            self::transfer();
        }else if($process==='cases'){
            self::checkcases();
        }else{
            echo 'Please specify function!';
        }
    }

    public function migrate()
    {
        Schema::table('profileservices', function (Blueprint $table) {
            $table->string('status')->after('sex');
        });
        Schema::table('profilecases', function (Blueprint $table) {
            $table->string('status')->after('sex');
        });
    }

    public function checkprofile()
    {
        $list = ProfileServices::where('barangay_id',1875)->get();
        $c = 1;
        foreach($list as $r)
        {
            $check = \App\Profile::where('unique_id',$r->profile_id)->first();
            if(!$check){
                echo $c.' found! - ' . $r->profile_id;
                echo '<br>';
                $c++;
                $data = array(
                    'profile_id' => $r->profile_id
                );
                ProfileCases::where($data)->delete();
                ProfileServices::where($data)->delete();
                ServiceOption::where($data)->delete();
                ServiceGroup::where($data)->delete();
            }
        }
    }

    public function checkgroup()
    {
        $list = ServiceGroup::where('barangay_id',1875)->get();
        foreach($list as $r)
        {
            $check = Profile::where('unique_id',$r->profile_id)->first();
            if(!$check){
                echo ' found! - ' . $r->profile_id;
                echo '<br>';
                $data = array(
                    'profile_id' => $r->profile_id
                );
                ServiceGroup::where($data)->delete();
            }
        }
    }

    public function fix()
    {
        $fix = ProfileServices::where('barangay_id',1875)->get();

        foreach($fix as $r)
        {
            $valid = date('Y',strtotime($r->dateProfile));
            if($valid!='2017')
            {
                if($r->created_at)
                {
                    $newDate = date('Y-m-d',strtotime($r->created_at));
                    ProfileServices::where('id',$r->id)
                        ->update(
                            array(
                                'dateProfile' => $newDate
                            )
                        );
                    echo $newDate .' - ' . $r->profile_id;
                    echo '<br>';
                }else{
                    ProfileServices::where('id',$r->id)->delete();
                }
            }
        }
    }

    public function fix2()
    {
        $fix = ProfileServices::where('barangay_id',1875)->get();

        foreach($fix as $r)
        {
//            if($r->sex=='' || $r->sex==null)
//            {
//                $sex = \App\Profile::where('unique_id',$r->profile_id)->first()->sex;
//                ProfileServices::where('id',$r->id)
//                    ->update(
//                        array(
//                            'sex' => "$sex"
//                        )
//                    );
//            }
            $muncity = Barangay::find($r->barangay_id)->muncity_id;
            if($r->sex=='Male')
            {
                ProfileServices::where('id',$r->id)
                    ->update(
                        array(
                            'status' => ''
                        )
                    );
            }
            if($r->muncity_id==0){
                ProfileServices::where('id',$r->id)
                    ->update(
                        array(
                            'muncity_id' => $muncity
                        )
                    );
            }
        }

    }

    public function servicegroup()
    {
        $profiles = Profile::where('barangay_id',1875)->get();
        foreach($profiles as $row)
        {
            echo $q = "INSERT IGNORE servicegroup(profile_id,sex,barangay_id,muncity_id) VALUES(
                '".$row->unique_id."',
                '".$row->sex."',
                '".$row->barangay_id."',
                '".$row->muncity_id."'
            )";
            echo '<br>';
            DB::select($q);
        }
    }

    public function fix3()
    {
        $fix = ProfileServices::where('sex','Female')
            ->where(function($q) {
                $q->orwhere('bracket_id',5)
                    ->orwhere('bracket_id',6);
            })
            ->get();

        foreach($fix as $r)
        {
            if($r->status=='')
            {
                $status = \App\FemaleStatus::where('profile_id',$r->profile_id)->first();
                if($status){

                    ProfileServices::where('id',$r->id)
                        ->update(
                            array(
                                'status' => "$status->status"
                            )
                        );
                }else{
                    ProfileServices::where('id',$r->id)
                        ->update(
                            array(
                                'status' => "non"
                            )
                        );
                }

            }
        }
    }

    public function pretransfer($province_id)
    {


        if($province_id==1){
            //select count(*) from profile where muncity_id>=49 and muncity_id<=56;
            $data = Profile::where('muncity_id','>=',44) //1,11,23,32,44
                ->where('muncity_id','<=',48) //10,22,31,43,48
                ->get();
        }else if($province_id==2){
            //select count(*) from profile where muncity_id>=49 and muncity_id<=56;
            $data = Profile::where('muncity_id','>=',90) //49,63,73,90
                ->where('muncity_id','<=',101) //62,72,89,101
                ->get();
        }else{
            $data = Profile::where('province_id',$province_id)
            ->get();
        }
        $c=1;
        foreach($data as $r)
        {
            if($r->sex=='' || $r->sex==null)
            {
                continue;
            }
            if($r->barangay_id==0 || $r->muncity_id==0)
            {
                continue;
            }

            $age = Param::getAge($r->dob);
            $option = '';
            if($age==0){
                $age = Param::getAgeMonth($r->dob).' M/o';
                $option = 'B';
                if($age==0){
                    $option = 'A';
                    $age = Param::getAgeDay($r->dob).' D/o';

                    if($age>=28){
                        $option = 'B';
                    }
                }
            }
            $bracket_id = 0;
            if($option=='A'){
                $bracket_id = 1;
            }else if($option=='B'){
                $bracket_id = 2;
            }else if($age >= 1 && $age <= 5){
                $bracket_id = 3;
            }else if($age >= 6 && $age <= 9){
                $bracket_id = 4;
            }else if($age >= 10 && $age <= 19){
                $bracket_id = 5;
            }else if($age >= 20 && $age <= 49){
                $bracket_id = 6;
            }else if($age >= 50 && $age <= 59){
                $bracket_id = 7;
            }else if($age >= 60){
                $bracket_id = 8;
            }

            $profile_id = $r->unique_id;

            $q = "INSERT IGNORE servicegroup(profile_id,sex,barangay_id,muncity_id,bracket_id)
                    VALUES(
                        '$profile_id',
                        '$r->sex',
                        '$r->barangay_id',
                        '$r->muncity_id',
                        '$bracket_id'
                        )";
            DB::select($q);
            echo $c++;
            echo '<br>';
        }
    }

    public function transfer()
    {
        $data = ProfileServices::where('barangay_id',1875)->get();
        $c = 1;
        foreach($data as $r)
        {
            $group = Param::checkGroup($r->service_id);
            $dateTmp = date('Y',strtotime($r->dateProfile));
            if($r->sex && $dateTmp == '2017'){
                Param::saveServiceGroup($r->profile_id,$r->sex,$group,$r->barangay_id,$r->muncity_id,$r->bracket_id,$r->dateProfile);
                echo $c++ . '-';
                echo $r->profile_id;
                echo '<br>';
            }
        }
    }

    public function checkcases()
    {
        $list = ProfileCases::where('barangay_id',1875)->get();
        $c = 1;
        foreach($list as $r)
        {
            $check = \App\Profile::where('unique_id',$r->profile_id)->first();
            if(!$check){
                echo $c.' found! - ' . $r->profile_id;
                echo '<br>';
                $c++;
                $data = array(
                    'profile_id' => $r->profile_id
                );
                ProfileCases::where($data)->delete();
            }
        }
    }

    public function fixcases()
    {
        $list = ProfileCases::where('barangay_id',1875)->get();
        $c = 1;
        foreach($list as $r)
        {
            $data = array(
                'profile_id' => $r->profile_id,
                'dateProfile' => $r->dateProfile
            );
            $check = ProfileServices::where($data)
                    ->first();
            if($check){
                ProfileCases::where($data)
                    ->update(
                        array(
                            'sex' => $check->sex,
                            'status' => $check->status
                        )
                    );
                echo $c.' - '.$check->profile_id;
                echo '<br>';
                $c++;
            }
        }
    }

    public function fixstatus()
    {
        $list = ProfileServices::where('sex','Female')
            ->where('status','')
            ->where('bracket_id',6)
            ->get();
        echo '<table border="2">';
        foreach($list as $r)
        {
            echo '<tr>';
            echo '<td>'.$r->profile_id.'</td>';
            echo '</tr>';

            ProfileServices::where('id',$r->id)
                ->update(
                    array(
                        'status' => 'non'
                    )
                );
        }
        echo '</table>';
    }
}
