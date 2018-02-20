<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\ParameterCtrl;
use App\ProfileCases;
use App\ProfileServices;
use App\ServiceOption;
use App\UserBrgy;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Profile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ReportCtrl extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    function download()
    {
        return view('client.data.download');
    }

    function upload()
    {
        return view('client.data.upload');
    }

    function uploadOld()
    {
        return view('client.data.upload-old');
    }

    function uploadData(Request $req)
    {
        $content = $req->data;
        $handle = false;
        $c = 1;
        $dateNow = date('Y-m-d H:i:s');

        foreach($content as $row){
            $tmp = explode("\r", $row);
            foreach($tmp as $obj)
            {
                if($obj==='version1.4')
                {
                    Session::put('version','1.4');
                    Session::put('process','none');
                    continue;
                }else if($obj=='PROFILES'){
                    Session::put('process',$obj);
                    continue;
                }else if($obj=='SERVICES'){
                    Session::put('process',$obj);
                    $handle = false;
                    continue;
                }else if($obj=='CASES'){
                    Session::put('process',$obj);
                    $handle = false;
                    continue;
                }else if($obj=='OPTIONS'){
                    Session::put('process',$obj);
                    $handle = false;
                    continue;
                }else if(!$obj){
                    continue;
                }

                $process = Session::get('process');

                if($process=='PROFILES'){
                    if($handle && $obj){
                        $content = explode(',',$obj);
                        $data = array(
                            'unique_id' => $content[0],
                            'familyID' => $content[1],
                            'phicID' => $content[2],
                            'nhtsID' => $content[3],
                            'head' => $content[4],
                            'relation' => $content[5],
                            'fname' => $content[6],
                            'mname' => $content[7],
                            'lname' => $content[8],
                            'suffix' => $content[9],
                            'dob' => $content[10],
                            'sex' => $content[11],
                            'barangay_id' => $content[12],
                            'muncity_id' => $content[13],
                            'province_id' => $content[14],
                            'income' => $content[15],
                            'unmet' => $content[16],
                            'water' => $content[17],
                            'toilet' => $content[18],
                            'education' => $content[19]
                        );
                        echo '<pre>';
                        print_r($data);

                    }else{
                        $handle = true;
                        continue;
                    }

                }else if($process=='SERVICES'){
                    if($handle && $obj){
                        $content = explode(',',$obj);
                        $data = array(
                            'unique_id' => $content[0],
                            'sex' => $content[1],
                            'status' => $content[2],
                            'dateProfile' => $content[3],
                            'profile_id' => $content[4],
                            'service_id' => $content[5],
                            'bracket_id' => $content[6],
                            'barangay_id' => $content[7],
                            'muncity_id' => $content[8]
                        );
                        echo '<pre>';
                        print_r($data);
                    }else{
                        $handle = true;
                        continue;
                    }

                }else if($process=='CASES'){
                    if($handle && $obj){
                        $content = explode(',',$obj);
                        $data = array(
                            'unique_id' => $content[0],
                            'dateProfile' => $content[1],
                            'profile_id' => $content[2],
                            'sex' => $content[3],
                            'status' => $content[4],
                            'barangay_id' => $content[5],
                            'muncity_id' => $content[6],
                            'bracket_id' => $content[7],
                            'case_id' => $content[8]
                        );
                        echo '<pre>';
                        print_r($data);
                    }else{
                        $handle = true;
                        continue;
                    }

                }else if($process=='OPTIONS'){
                    if($handle && $obj){
                        $content = explode(',',$obj);
                        $data = array(
                            'unique_id' => $content[0],
                            'dateProfile' => $content[1],
                            'profile_id' => $content[2],
                            'barangay_id' => $content[3],
                            'muncity_id' => $content[4],
                            'option' => $content[5],
                            'status' => $content[6]
                        );
                        echo '<pre>';
                        print_r($data);
                    }else{
                        $handle = true;
                        continue;
                    }

                }
            }
        }
        return array(
            'version' => '1.4'
        );
    }

    function uploadDataOld(Request $req)
    {
        $dateNow = date('Y-m-d H:i:s');
        $content = $req->data;
        $handle = Session::get('handle')? Session::get('handle'): false;
        $c = 1;
        $output = array();
        foreach($content as $row){
            $tmp = explode("\r", $row);
            foreach($tmp as $obj)
            {
                $str = explode(',',$obj);
                $str = str_replace('"','',$str);
                $str = str_replace(' ', '', $str);

                echo '<br>';
                if($obj=='PROFILE'){
                    Session::put('process',$obj);
                    continue;
                }else if($obj=='SERVICES'){
                    Session::put('process',$obj);
                    Session::put('handle',false);
                    $handle = false;
                    continue;
                }else if($obj=='CASES'){
                    Session::put('process',$obj);
                    Session::put('handle',false);
                    $handle = false;
                    continue;
                }else if($obj=='STATUS'){
                    Session::put('process',$obj);
                    Session::put('handle',false);
                    $handle = false;
                    continue;
                }else if($obj=='SERVICE OPTION'){
                    Session::put('process',$obj);
                    Session::put('handle',false);
                    $handle = false;
                    continue;
                }else if(!$obj){
                    continue;
                }

               $process = Session::get('process');

                if($process=='PROFILE'){
                    if($handle && $obj && count($content)){
                        $content = explode(',',$obj);
                        $content = str_replace('"','',$content);
                        $unique_id = array(
                            $content[3],
                            $content[4],
                            $content[5],
                            $content[6],
                            $content[9],
                            $content[10]
                        );
                        $unique_id = implode('',$unique_id);

                        $q = "INSERT INTO profile(
                                  unique_id,
                                  familyID,
                                  head,
                                  relation,
                                  fname,
                                  mname,
                                  lname,
                                  suffix,
                                  dob,
                                  sex,
                                  barangay_id,
                                  muncity_id,
                                  province_id,
                                  created_at,
                                  updated_at
                                  )
                                VALUES(
                                  '$unique_id',
                                  '$content[0]',
                                  '$content[1]',
                                  '$content[2]',
                                  '$content[3]',
                                  '$content[4]',
                                  '$content[5]',
                                  '$content[6]',
                                  '".date('Y-m-d',strtotime($content[7]))."',
                                  '$content[8]',
                                  '$content[9]',
                                  '$content[10]',
                                  '$content[11]',
                                  '$dateNow',
                                  '$dateNow'
                                  )
                            ON DUPLICATE KEY UPDATE
                                familyID = '$content[0]',
                                head = '$content[1]',
                                fname = '$content[3]',
                                mname = '$content[4]',
                                lname = '$content[5]',
                                suffix = '$content[6]',
                                dob = '".date('Y-m-d',strtotime($content[7]))."',
                                sex = '$content[8]',
                                relation = '$content[2]'                               
                            ";

                        $save = DB::select($q);

                        if(!$save){
                            $output[] = $unique_id;
                        }

                        $q = "INSERT IGNORE servicegroup(profile_id,sex,barangay_id,muncity_id) VALUES(
                                '$unique_id',
                                '".$content[8]."',
                                '".$content[9]."',
                                '".$content[10]."'
                            )";
                        DB::select($q);
                    }else{
                        Session::put('handle',true);
                        $handle = true;
                        continue;
                    }

                }else if($process=='SERVICES'){
                    if($handle && $obj && count($content)){
                        $content = explode(',',$obj);
                        $content = str_replace('"','',$content);
                        $profile_id = array(
                            $content[1],
                            $content[2],
                            $content[3],
                            $content[4],
                            $content[7],
                            $content[8]
                        );
                        $profile_id = implode('',$profile_id);

                        $unique_id = array(
                            date('mdY',strtotime($content[0])),
                            $profile_id,
                            $content[6],
                            $content[5]
                        );
                        $sex = '';
                        $unique_id = implode('',$unique_id);
                        $info = Profile::where('unique_id',$profile_id)->first();
                        if($info)
                        {
                            $sex = $info->sex;
                        }
                        $q = "INSERT IGNORE profileservices(
                            unique_id, 
                            dateProfile, 
                            profile_id,
                            sex, 
                            service_id, 
                            bracket_id, 
                            barangay_id, 
                            muncity_id,
                            created_at,
                            updated_at
                        )
                        VALUES
                        (
                            '".$unique_id."',
                            '".date('Y-m-d',strtotime($content[0]))."', 
                            '".$profile_id."', 
                            '".$sex."',  
                            '".$content[5]."', 
                            '".$content[6]."', 
                            '".$content[7]."', 
                            '".$content[8]."',
                            '$dateNow',
                            '$dateNow'
                        )
                        ";
                        DB::select($q);
                        $group = ParameterCtrl::checkGroup($content[5]);
                        ParameterCtrl::saveServiceGroup($profile_id,$sex,$group,$content[7],$content[8],$content[6],date('Y-m-d',strtotime($content[0])));
                    }else{
                        Session::put('handle',true);
                        $handle = true;
                        continue;
                    }

                }else if($process=='CASES'){
                    if($handle && $obj && count($content)){
                        $content = explode(',',$obj);
                        $content = str_replace('"','',$content);
                        $profile_id = array(
                            $content[1],
                            $content[2],
                            $content[3],
                            $content[4],
                            $content[7],
                            $content[8]
                        );
                        $profile_id = implode('',$profile_id);

                        $unique_id = array(
                            date('mdY',strtotime($content[0])),
                            $profile_id,
                            $content[6],
                            $content[5]
                        );
                        $unique_id = implode('',$unique_id);
                        $sex = '';
                        $info = Profile::where('unique_id',$profile_id)->first();
                        if($info)
                        {
                            $sex = $info->sex;
                        }
                        $q = "INSERT IGNORE profilecases(
                            unique_id, 
                            dateProfile, 
                            profile_id, 
                            sex,
                            case_id, 
                            bracket_id, 
                            barangay_id, 
                            muncity_id,
                            created_at,
                            updated_at
                        )
                        VALUES(
                            '$unique_id', 
                            '".date('Y-m-d',strtotime($content[0]))."', 
                            '$profile_id', 
                            '$sex', 
                            '".$content[5]."', 
                            '".$content[6]."', 
                            '".$content[7]."', 
                            '".$content[8]."', 
                            '$dateNow',
                            '$dateNow'
                        )";

                        DB::select($q);
                    }else{
                        Session::put('handle',true);
                        $handle = true;
                        continue;
                    }

                }else if($process=='STATUS'){
                    if($handle && $obj && count($content)){
                        $content = explode(',',$obj);
                        $content = str_replace('"','',$content);
                        print_r($content);
                        $profile_id = array(
                            $content[1],
                            $content[2],
                            $content[3],
                            $content[4],
                            $content[7],
                            $content[8]
                        );
                        $profile_id = implode('',$profile_id);
                        ProfileServices::where('dateProfile',date('Y-m-d',strtotime($content[0])))
                            ->where('profile_id',$profile_id)
                            ->orderBy('id','desc')
                            ->update(
                                array(
                                    'status' => $content[5]
                                )
                            );
                        ProfileCases::where('dateProfile',date('Y-m-d',strtotime($content[0])))
                            ->where('profile_id',$profile_id)
                            ->orderBy('id','desc')
                            ->update(
                                array(
                                    'status' => $content[5]
                                )
                            );
                    }else{
                        Session::put('handle',true);
                        $handle = true;
                        continue;
                    }

                }else if($process=='SERVICE OPTION'){
                    //date, profile, option, status
                    if($handle && $obj && count($content)){
                        $content = explode(',',$obj);
                        $content = str_replace('"','',$content);
                        $profile_id = array(
                            $content[1],
                            $content[2],
                            $content[3],
                            $content[4],
                            $content[7],
                            $content[8]
                        );
                        $profile_id = implode('',$profile_id);
                        $unique_id = array(
                            date('mdY',strtotime($content[0])),
                            $profile_id,
                            $content[5],
                            $content[6]
                        );
                        $unique_id = implode('',$unique_id);
                        $q = "INSERT IGNORE serviceoption(
                            unique_id, 
                            dateProfile, 
                            profile_id, 
                            serviceoption.option, 
                            serviceoption.status, 
                            barangay_id, 
                            muncity_id,
                            created_at,
                            updated_at
                        )VALUES(
                            '$unique_id', 
                            '".$content[1]."', 
                            '$profile_id', 
                            '".$content[5]."', 
                            '".$content[6]."', 
                            '".$content[7]."', 
                            '".$content[8]."',
                            '$dateNow',
                            '$dateNow')
                            ";
                        DB::select($q);
                    }else{
                        Session::put('handle',true);
                        $handle = true;
                        continue;
                    }

                }
            }
        }
        echo '<pre>';
        print_r($output);
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
            'countOptions' => self::countOptions($year)
        );
    }

    function downloadProfile($offset)
    {
        $id = Auth::user()->id;
        $priv = Auth::user()->user_priv;
        $data = array();
        $services = array();
        $cases = array();
        $servicegroup = array();
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
            $count = ProfileServices::where('muncity_id',$muncity)
                ->where('dateProfile','>=',$startDate)
                ->where('dateProfile','<=',$endDate)
                ->count();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            foreach($userBrgy as $row)
            {
                $count += ProfileServices::where('barangay_id',$row->barangay_id)
                    ->where('dateProfile','>=',$startDate)
                    ->where('dateProfile','<=',$endDate)
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
            $data = ProfileServices::where('muncity_id',$muncity)
                ->where('dateProfile','>=',$startDate)
                ->where('dateProfile','<=',$endDate)
                ->skip($offset)
                ->take(100)
                ->get();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            $data = ProfileServices::select('*');
            foreach($userBrgy as $row)
            {
                $data = $data->orwhere('barangay_id',$row->barangay_id);
            }
            $data = $data->where('dateProfile','>=',$startDate)
                ->where('dateProfile','<=',$endDate)
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
            $count = ProfileCases::where('muncity_id',$muncity)
                ->where('dateProfile','>=',$startDate)
                ->where('dateProfile','<=',$endDate)
                ->count();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            foreach($userBrgy as $row)
            {
                $count += ProfileCases::where('barangay_id',$row->barangay_id)
                    ->where('dateProfile','>=',$startDate)
                    ->where('dateProfile','<=',$endDate)
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
            $data = ProfileCases::where('muncity_id',$muncity)
                ->where('dateProfile','>=',$startDate)
                ->where('dateProfile','<=',$endDate)
                ->skip($offset)
                ->take(100)
                ->get();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            $data = ProfileCases::select('*');
            foreach($userBrgy as $row)
            {
                $data = $data->orwhere('barangay_id',$row->barangay_id);
            }
            $data = $data->where('dateProfile','>=',$startDate)
                ->where('dateProfile','<=',$endDate)
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
            $count = ServiceOption::where('muncity_id',$muncity)
                ->where('dateProfile','>=',$startDate)
                ->where('dateProfile','<=',$endDate)
                ->count();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            foreach($userBrgy as $row)
            {
                $count += ServiceOption::where('barangay_id',$row->barangay_id)
                    ->where('dateProfile','>=',$startDate)
                    ->where('dateProfile','<=',$endDate)
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
            $data = ServiceOption::where('muncity_id',$muncity)
                ->where('dateProfile','>=',$startDate)
                ->where('dateProfile','<=',$endDate)
                ->skip($offset)
                ->take(100)
                ->get();
        }else{
            $userBrgy = UserBrgy::where('user_id',$id)->get();
            $data = ServiceOption::select('*');
            foreach($userBrgy as $row)
            {
                $data = $data->orwhere('barangay_id',$row->barangay_id);
            }
            $data = $data->where('dateProfile','>=',$startDate)
                ->where('dateProfile','<=',$endDate)
                ->skip($offset)
                ->take(100)
                ->get();
        }

        return array(
            'data' => $data
        );
    }
}
