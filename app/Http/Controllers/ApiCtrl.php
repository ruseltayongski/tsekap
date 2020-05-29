<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\Bracket;
use App\Cases;
use App\Device;
use App\Facility;
use App\Feedback;
use App\Muncity;
use App\Profile;
use App\Province;
use App\Purok;
use App\Service;
use App\ServiceGroup;
use App\Sitio;
use App\User;
use App\UserBrgy;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Dengvaxia;
use App\Http\Controllers\AphroditeConnCtrl as aphrodite_conn;


class ApiCtrl extends Controller
{

    public function api()
    {
        $req = Input::get('r');
        if($req==='login')
        {
            return self::login();
        }else if($req==='countProfile'){
            return self::countProfile();
        }else if($req==='profile'){
            return self::getProfiles();
        }else if($req==='version'){
            return self::getversion();
        }else if($req==='mustservices'){
            return self::getMustServices();
        }else if($req==='countmustservices'){
            return self::countMustServices();
        }else if($req==='getToken'){
            return array(
                '_token' => csrf_token()
            );
        }
    }

    public function getversion()
    {
        return array(
            'version' => '2.0',
            'description'=> '
            \n - Dengvaxia Profiling added in profile update\n - Automatic update after upload is removed\n - Check for Update is added in drawer\n - Minor bug fixes
            \n - NOTE: Please UNINSTALL the older version and DOWNLOAD the new VERSION thru ONLINE System.  
            '
        );
    }
    public function login()
    {
        $user = Input::get('user');
        $pass = Input::get('pass');

        $user = User::where('username',$user)->first();

        if(count($user))
        {
            if(Hash::check($pass,$user->password))
            {
                $count = 0;
                $userBrgy = array();
                if($user->user_priv==2){
                    $userBrgy = UserBrgy::select('userbrgy.barangay_id','barangay.description','barangay.target')
                        ->where('user_id',$user->id)
                        ->leftJoin('barangay','userbrgy.barangay_id','=','barangay.id')
                        ->get();
                }else if($user->user_priv==0){
                    $userBrgy = Barangay::select('id as barangay_id','description','target')
                        ->where('muncity_id',$user->muncity)
                        ->get();
                }
                foreach($userBrgy as $row)
                {
                    $count += $row->target;
                }
                return array(
                    'data' => $user,
                    'userBrgy' => $userBrgy,
                    'muncity' => $user->muncity,
                    'target' => $count,
                    'status' => 'success'
                );
            }else{
                return array(
                    'status' => 'denied'
                );
            }

        }else{
            return array(
                'status' => 'error'
            );
        }
    }

    public function countProfile()
    {
        $brgy_id = Input::get('brgy');
        $count  = Profile::where('barangay_id',$brgy_id)->count();
        return array(
            'count' => $count
        );
    }

    public function getProfiles()
    {
        $brgy_id = Input::get('brgy');
        $offset = Input::get('offset');
        $perPage = 100;

        $user_id = Input::get('user_id');
        if($user_id){
            $check = User::find($user_id);
            if(!$check){
                return false;
            }
        }


        $data = Profile::where('barangay_id',$brgy_id)
            ->orderBy('lname','asc')
            ->skip($offset)
            ->take($perPage)
            ->get();
        return array(
            'data' => $data
        );
    }

    public function countMustServices()
    {
        $brgy_id = Input::get('brgy');
        $servicegroup = new ServiceGroup();
        $servicegroup->setConnection('db_'.date('Y'));
        $count  = $servicegroup->where('barangay_id',$brgy_id)->count();
        return array(
            'count' => $count
        );
    }

    public function getMustServices()
    {
        $brgy_id = Input::get('brgy');
        $offset = Input::get('offset');
        $perPage = 100;
        $year = date('Y');
        $servicegroup = new ServiceGroup();
        $servicegroup->setConnection('db_'.$year);
        $list = $servicegroup->where('servicegroup.barangay_id',$brgy_id)
            ->skip($offset)
            ->take($perPage)
            ->get();
        $data = array();

        foreach($list as $row)
        {
            $id = $row->profile_id;
            $name = Profile::where('unique_id',$row->profile_id)->first();
            if($name):
                $data[] = array(
                    'fullname' => $name->lname.', '.$name->fname.' '.$name->mname.' '.$name->suffix,
                    'group1' => $row->group1,
                    'group2' => $row->group2,
                    'group3' => $row->group3
                );
            endif;
        }

        return array(
            'data' => $data
        );
    }

    public function syncProfile(Request $req)
    {
        try{
            $con=aphrodite_conn::AphroditeConn();
            $user_id = $req->user_id;
            if($user_id){
                $check = User::find($user_id);
                if(!$check){
                    return false;
                }

            }
            $data = $req->data;
            $dateNow = date('Y-m-d H:i:s');

            $brgy = Barangay::find($data['barangay_id']);
            $muncity_id = $brgy->muncity_id;
            $province_id = $brgy->province_id;
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
                  updated_at,
                  phicID,
                  nhtsID,
                  income,
                  unmet,
                  water,
                  toilet,
                  education
                  )
                VALUES(
                  '".mysqli_real_escape_string($con,$data['unique_id'])."',
                  '".mysqli_real_escape_string($con,$data['familyID'])."',
                  '".mysqli_real_escape_string($con,$data['head'])."',
                  '".mysqli_real_escape_string($con,$data['relation'])."',
                  '".mysqli_real_escape_string($con,$data['fname'])."',
                  '".mysqli_real_escape_string($con,$data['mname'])."',
                  '".mysqli_real_escape_string($con,$data['lname'])."',
                  '".mysqli_real_escape_string($con,$data['suffix'])."',
                  '".date('Y-m-d',strtotime($data['dob']))."',
                  '".$data['sex']."',
                  '".$data['barangay_id']."',
                  '$muncity_id',
                  '$province_id',
                  '$dateNow',
                  '$dateNow',
                  '".mysqli_real_escape_string($con,$data['phicID'])."',
                  '".mysqli_real_escape_string($con,$data['nhtsID'])."',
                  '".mysqli_real_escape_string($con,$data['income'])."',
                  '".mysqli_real_escape_string($con,$data['unmet'])."',
                  '".mysqli_real_escape_string($con,$data['water'])."',
                  '".mysqli_real_escape_string($con,$data['toilet'])."',
                  '".mysqli_real_escape_string($con,$data['education'])."'
                  )
            ON DUPLICATE KEY UPDATE
                familyID = '".mysqli_real_escape_string($con,$data['familyID'])."',
                head = '".$data['head']."',
                fname = '".mysqli_real_escape_string($con,$data['fname'])."',
                mname = '".mysqli_real_escape_string($con,$data['mname'])."',
                lname = '".mysqli_real_escape_string($con,$data['lname'])."',
                suffix = '".$data['suffix']."',
                dob = '".date('Y-m-d',strtotime($data['dob']))."',
                sex = '".$data['sex']."',
                relation = '".$data['relation']."',
                education = '".$data['education']."',
                phicID = '".$data['phicID']."',
                nhtsID = '".$data['nhtsID']."',
                income = '".$data['income']."',
                unmet = '".$data['unmet']."',
                water = '".$data['water']."',
                toilet = '".$data['toilet']."'
            ";

            DB::select($q);

            $q = "INSERT IGNORE profile_device(profile_id,device) values(
                '".mysqli_real_escape_string($con,$data['unique_id'])."',
                'mobile'
            )";
            DB::select($q);

            $q = "INSERT IGNORE servicegroup(profile_id,sex,barangay_id,muncity_id) VALUES(
                '".mysqli_real_escape_string($con,$data['unique_id'])."',
                '".$data['sex']."',
                '".$data['barangay_id']."',
                '$muncity_id'
            )";
            $year = date('Y');
            $db = 'db_'.$year;
            DB::connection($db)->select($q);
            return array(
                'status' => 'success'
            );
        }
        catch(Exception $e){
            return $e->getMessage();
        }

    }

    /*public function syncProfile(Request $req)
    {
        $user_id = $req->user_id;
        if($user_id){
            $check = User::find($user_id);
            if(!$check){
                return false;
            }

        }
        $data = $req->data;
        $dateNow = date('Y-m-d H:i:s');

        $brgy = Barangay::find($data['barangay_id']);
        $muncity_id = $brgy->muncity_id;
        $province_id = $brgy->province_id;
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
                  updated_at,
                  phicID,
                  nhtsID,
                  income,
                  unmet,
                  water,
                  toilet,
                  education
                  )
                VALUES(
                  '".$data['unique_id']."',
                  '".$data['familyID']."',
                  '".$data['head']."',
                  '".$data['relation']."',
                  '".$data['fname']."',
                  '".$data['mname']."',
                  '".$data['lname']."',
                  '".$data['suffix']."',
                  '".date('Y-m-d',strtotime($data['dob']))."',
                  '".$data['sex']."',
                  '".$data['barangay_id']."',
                  '$muncity_id',
                  '$province_id',
                  '$dateNow',
                  '$dateNow',
                  '".$data['phicID']."',
                  '".$data['nhtsID']."',
                  '".$data['income']."',
                  '".$data['unmet']."',
                  '".$data['water']."',
                  '".$data['toilet']."',
                  '".$data['education']."'
                  )
            ON DUPLICATE KEY UPDATE
                familyID = '".$data['familyID']."',
                head = '".$data['head']."',
                fname = '".$data['fname']."',
                mname = '".$data['mname']."',
                lname = '".$data['lname']."',
                suffix = '".$data['suffix']."',
                dob = '".date('Y-m-d',strtotime($data['dob']))."',
                sex = '".$data['sex']."',
                relation = '".$data['relation']."',
                education = '".$data['education']."',
                phicID = '".$data['phicID']."',
                nhtsID = '".$data['nhtsID']."',
                income = '".$data['income']."',
                unmet = '".$data['unmet']."',
                water = '".$data['water']."',
                toilet = '".$data['toilet']."'
            ";

        DB::select($q);

        $q = "INSERT IGNORE profile_device(profile_id,device) values(
                '".$data['unique_id']."',
                'mobile'
            )";
        DB::select($q);

        $q = "INSERT IGNORE servicegroup(profile_id,sex,barangay_id,muncity_id) VALUES(
                '".$data['unique_id']."',
                '".$data['sex']."',
                '".$data['barangay_id']."',
                '$muncity_id'
            )";
        $year = date('Y');
        $db = 'db_'.$year;
        DB::connection($db)->select($q);
        return array(
            'status' => 'success'
        );
    }*/

    public function syncServices(Request $req)
    {
        $services = $req->services;
        $cases =  $req->diagnoses;
        $options = $req->options;
        $dateNow = date('Y-m-d H:i:s');

        $muncity = Barangay::find($req->barangay_id)->muncity_id;
        foreach($services as $s)
        {
            $service_id = $s['id'];
            $unique_id = date('mdY',strtotime($req->dateProfile)).''.$req->profile_id.''.$req->bracket_id.''.$service_id;

            $q = "INSERT IGNORE profileservices(
                        unique_id, 
                        dateProfile, 
                        profile_id,
                        sex, 
                        status,
                        service_id, 
                        bracket_id, 
                        barangay_id, 
                        muncity_id,
                        created_at,
                        updated_at
                    )
                    VALUES
                    (
                        '$unique_id',
                        '$req->dateProfile', 
                        '$req->profile_id', 
                        '$req->sex', 
                        '$req->status', 
                        '$service_id', 
                        '$req->bracket_id', 
                        '$req->barangay_id', 
                        '$muncity',
                        '$dateNow',
                        '$dateNow'
                    )
            ";
            $year = date('Y',strtotime($req->dateProfile));
            $db = 'db_'.$year;
            DB::connection($db)->select($q);
            $group = ParameterCtrl::checkGroup($service_id);
            ParameterCtrl::saveServiceGroup($req->profile_id,$req->sex,$group,$req->barangay_id,$req->muncity_id,$req->bracket_id,$req->dateProfile,$db,$year);
        }

        foreach($cases as $c)
        {
            $case_id = $c['id'];
            $unique_id = date('mdY',strtotime($req->dateProfile)).''.$req->profile_id.''.$req->bracket_id.''.$case_id;
            $year = date('Y',strtotime($req->dateProfile));
            $q = "INSERT IGNORE profilecases(
                        unique_id, 
                        dateProfile, 
                        profile_id, 
                        sex,
                        status,
                        case_id, 
                        bracket_id, 
                        barangay_id, 
                        muncity_id,
                        created_at,
                        updated_at
                    )
                    VALUES(
                        '$unique_id', 
                        '$req->dateProfile', 
                        '$req->profile_id', 
                        '$req->sex', 
                        '$req->status', 
                        '$case_id', 
                        '$req->bracket_id', 
                        '$req->barangay_id', 
                        '$muncity',
                        '$dateNow',
                        '$dateNow'
                    )";
            $db = 'db_'.$year;
            DB::connection($db)->select($q);
        }

        foreach($options as $o)
        {
            foreach($o as $key => $value)
            {
                $unique_id = date('mdY',strtotime($req->dateProfile)).''.$req->profile_id.''.$key.''.$value;
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
                        '$req->dateProfile', 
                        '$req->profile_id', 
                        '$key', 
                        '$value', 
                        '$req->barangay_id', 
                        '$muncity',
                        '$dateNow',
                        '$dateNow')
                        ";
                $year = date('Y',strtotime($req->dateProfile));
                $db = 'db_'.$year;
                DB::connection($db)->select($q);
            }
        }
        return array(
            'status' => 'success'
        );
    }

    public function insertDengvaxia(Request $request){
        $data = $request->all();
        $data['phic_membership'] = json_encode($request->phic_membership);
        $data['family_history'] = json_encode($request->family_history);
        $data['medical_history'] = json_encode($request->medical_history);
        $data['disability_injury'] = json_encode($request->disability_injury);
        $data['hospital_history'] = json_encode($request->hospital_history);
        $data['surgical_history'] = json_encode($request->surgical_history);
        $data['personal_history'] = json_encode($request->personal_history);
        $data['mens_gyne_history'] = json_encode($request->mens_gyne_history);
        $data['vaccine_history'] = json_encode($request->vaccine_history);
        $data['review_systems'] = json_encode($request->review_systems);
        $data['physical_exam'] = json_encode($request->physical_exam);
        $data['bronchial_asthma'] = json_encode($request->bronchial_asthma);
        $data['tuberculosis'] = json_encode($request->tuberculosis);
        $data['other_procedures'] = json_encode($request->other_procedures);
        $data['platform'] = "mobile";

        Dengvaxia::updateOrCreate(['unique_id' => $data['unique_id']], $data);

        Profile::updateOrCreate(
            ['unique_id' => $data['unique_id']], [
                "lname" => $request->lname,
                "fname" => $request->fname,
                "mname" => $request->mname,
                "suffix" => $request->suffix,
                "head" => $request->head,
                "dob" => $request->dob,
                "barangay_id" => $request->barangay_id,
                "muncity_id" => $request->muncity_id,
                "province_id" => $request->province_id,
                "education" => $request->education,
                "dengvaxia" => "yes"
            ]
        );

        return array(
            'status' => 'Successfully Registered'
        );
    }

    public function patient_api($id){
        $data = Dengvaxia::find($id);
        return $data;
    }

    public function getUsers(){
        if(Input::get('count'))
            return User::count();

        return User::get();
    }

    public function getBarangay(){
        if(Input::get('count'))
            return Barangay::count();

        return Barangay::get();
    }

    public function getBrackets(){
        if(Input::get('count'))
            return Bracket::count();

        return Bracket::get();
    }

    public function getCases(){
        if(Input::get('count'))
            return Cases::count();

        return Cases::get();
    }

    public function getFeedback(){
        if(Input::get('count'))
            return Feedback::count();

        return Feedback::get();
    }

    public function getMuncity(){
        if(Input::get('count'))
            return Muncity::count();

        return Muncity::get();
    }

    public function getProfile($offset,$limit){
        if(Input::get('count'))
            return Profile::count();

        return Profile::offset($offset)
            ->limit($limit)
            ->get();
    }

    public function getProfileDevice($offset,$limit){
        if(Input::get('count'))
            return Device::count();

        return Device::offset($offset)
            ->limit($limit)
            ->get();
    }

    public function getProvince(){
        if(Input::get('count'))
            return Province::count();

        return Province::get();
    }

    public function getServices(){
        if(Input::get('count'))
            return Service::count();

        return Service::get();
    }

    public function getUserBrgy($offset,$limit){
        if(Input::get('count'))
            return UserBrgy::count();

        return UserBrgy::offset($offset)
            ->limit($limit)
            ->get();
    }

    public function getSitio(){
        if(Input::get('count'))
            return Sitio::count();

        return Sitio::get();
    }

    public function getPurok(){
        if(Input::get('count'))
            return Purok::count();

        return Purok::get();
    }

    public function getFacility(){
        if(Input::get('count'))
            return Facility::count();

        return Facility::get();
    }


}
