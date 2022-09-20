<?php

namespace App\Http\Controllers;

use App\AvailService;
use App\Barangay;
use App\Facility;
use App\Facility2;
use App\FacilityAssign;
use App\Immunization;
use App\Muncity;
use App\NutritionStatus;
use App\Profile;
use App\Province;
use App\ReferralUser;
use App\ServiceGroup;
use App\User;
use App\UserBrgy;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Dengvaxia;
use App\Http\Controllers\AphroditeConnCtrl as aphrodite_conn;
use function MongoDB\BSON\toJSON;


class ApiCtrlv21 extends Controller
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

        $profile = Profile::where('barangay_id',$brgy_id)
            ->orderBy('profile.lname','asc')
            ->skip($offset)
            ->take($perPage)
            ->get();

        $data = array();

        foreach($profile as $p) {
            $immu = Immunization::select('description')->where('profile_id', $p->id)->get();
            $nutri = NutritionStatus::select('description')->where('profile_id', $p->id)->get();
            $immu_data = $nutri_data = "";
            $immu_count = $nutri_count = 0;
            foreach($immu as $i) {
                $immu_count++;
                $immu_data .= $immu_count == 1 ? $i->description : ",".$i->description;
            }
            foreach($nutri as $n) {
                $nutri_count++;
                $nutri_data .= $nutri_count == 1 ? $n->description : ",".$n->description;
            }
            $res = array (
                'id' => $p->id,
                'unique_id' => $p->unique_id,
                'familyID' => $p->familyID,
                'phicID' => $p->phicID,
                'nhtsID' => $p->nhtsID,
                'head' => $p->head,
                'relation' => $p->relation,
                'fname' => $p->fname,
                'mname' => $p->mname,
                'lname' => $p->lname,
                'suffix' => $p->suffix,
                'dob' => $p->dob,
                'sex' => $p->sex,
                'barangay_id' => $p->barangay_id,
                'muncity_id' => $p->muncity_id,
                'province_id' => $p->province_id,
                'income' => $p->income,
                'unmet' => $p->unmet,
                'water' => $p->water,
                'toilet' => $p->toilet,
                'education' => $p->education,
                'hypertension' => $p->hypertension,
                'diabetic' => $p->diabetic,
                'pwd' => $p->pwd,
                'pwd_desc' => (isset($p->pwd_desc)) ? $p->pwd_desc : '',
                'pregnant' => $p->pregnant,
                'dengvaxia' => (isset($p->dengvaxia)) ? $p->dengvaxia : '',
                'sitio_id' => (isset($p->sitio_id)) ? $p->sitio_id : '',
                'purok_id' => (isset($p->purok_id)) ? $p->purok_id : '',
                'birth_place' => (isset($p->birth_place)) ? $p->birth_place : '',
                'civil_status' => (isset($p->civil_status)) ? $p->civil_status : '',
                'religion' => (isset($p->religion)) ? $p->religion : '',
                'other_religion' => (isset($p->other_religion)) ? $p->other_religion : '',
                'contact' => (isset($p->contact)) ? $p->contact : '',
                'height' => (isset($p->height)) ? $p->height : '',
                'weight' => (isset($p->weight)) ? $p->weight : '',
                'cancer' => (isset($p->cancer)) ? $p->cancer : '',
                'cancer_type' => (isset($p->cancer_type)) ? $p->cancer_type : '',
                'mental_med' => (isset($p->mental_med)) ? $p->mental_med : '',
                'tbdots_med' => (isset($p->tbdots_med)) ? $p->tbdots_med : '',
                'cvd_med' => (isset($p->cvd_med)) ? $p->cvd_med : '',
                'covid_status' => (isset($p->covid_status)) ? $p->covid_status : '',
                'menarche' => (isset($p->menarche)) ? $p->menarche : '',
                'menarche_age' => (isset($p->menarche_age)) ? $p->menarche_age : '',
                'newborn_screen' => (isset($p->newborn_screen)) ? $p->newborn_screen : '',
                'newborn_text' => (isset($p->newborn_text)) ? $p->newborn_text : '',
                'deceased' => (isset($p->deceased)) ? $p->deceased : '',
                'deceased_date' => (isset($p->deceased_date)) ? $p->deceased_date : '',
                'sexually_active' => (isset($p->sexually_active)) ? $p->sexually_active : '',
                'immu_stat' => $immu_data,
                'nutri_stat' => $nutri_data,
                'nhts' => isset($p->nhts) ? $p->nhts : '',
                'four_ps' => isset($p->four_ps) ? $p->four_ps : '',
                'ip' => isset($p->ip) ? $p->ip : '',
                'member_others' => isset($p->member_others) ? $p->member_others : '',
                'balik_probinsya' => isset($p->balik_probinsya) ? $p->balik_probinsya : ''
            );
            array_push($data, $res);
        }

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
            $data2 = array(
                'unique_id' => $data['unique_id'],
                'familyID' => $data['familyID'],
                'head' => $data['head'],
                'relation' => $data['relation'],
                'fname' => $data['fname'],
                'mname' => $data['mname'],
                'lname' => $data['lname'],
                'suffix' => $data['suffix'],
                'dob' => date('Y-m-d',strtotime($data['dob'])),
                'sex' => $data['sex'],
                'barangay_id' => $data['barangay_id'],
                'muncity_id' => $muncity_id,
                'province_id' => $province_id,
                'phicID' => $data['phicID'],
                'nhtsID' => $data['nhtsID'],
                'income' => $data['income'],
                'unmet' => $data['unmet'],
                'water' => $data['water'],
                'toilet' => $data['toilet'],
                'education' => $data['education'],
                'hypertension' => $data['hypertension'],
                'diabetic' => $data['diabetic'],
                'pwd' => strtolower($data['pwd']),
                'pwd_desc' => $data['pwd_desc'],
                'pregnant' => $data['pregnant'],
                'birth_place' => $data['birth_place'],
                'civil_status' => $data['civil_status'],
                'religion' => $data['religion'],
                'other_religion' => $data['other_religion'],
                'contact' => $data['contact'],
                'height' => $data['height'],
                'weight' => $data['weight'],
                'cancer' => strtolower($data['cancer']),
                'cancer_type' => $data['cancer_type'],
                'mental_med' => $data['mental_med'],
                'tbdots_med' => $data['tbdots_med'],
                'cvd_med' => $data['cvd_med'],
                'covid_status' => $data['covid_status'],
                'menarche' => strtolower($data['menarche']),
                'menarche_age' => $data['menarche_age'],
                'newborn_screen' => $data['newborn_screen'],
                'newborn_text' => $data['newborn_text'],
                'deceased' => strtolower($data['deceased']),
                'deceased_date' => date('Y-m-d',strtotime($data['deceased_date'])),
                'sexually_active' => strtolower($data['sexually_active']),
                'nhts' => strtolower($data['nhts']),
                'four_ps' => strtolower($data['four_ps']),
                'ip' => strtolower($data['ip']),
                'member_others' => $data['member_others'],
                'balik_probinsya' => strtolower($data['balik_probinsya'])
            );

            Profile::updateOrCreate(['unique_id' => $data['unique_id']],$data2);

            $profile_id = $data['user_id'];
            $nutri_del = NutritionStatus::where('profile_id', $profile_id)->delete();
            $immu_del = Immunization::where('profile_id', $profile_id)->delete();

            $nutri_stat = explode(',',$data['nutri_stat']);
            foreach($nutri_stat as $nutri) {
                $nstat = new NutritionStatus();
                $nstat->profile_id = $profile_id;
                $nstat->description = $nutri;
                $nstat->save();
            }

            $immu_stat = explode(',',$data['immu_stat']);
            foreach($immu_stat as $immu) {
                $i = new Immunization();
                $i->profile_id = $profile_id;
                $i->description = $immu;
                $i->save();
            }

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

    public function getSpecialists($user_id) {
        $user = User::select('user_priv', 'muncity', 'province')->where('id', $user_id)->first();
        $user_priv = $user->user_priv;

        $specialists = ReferralUser::select(
            'username',
            'fname',
            'mname',
            'lname',
            'contact',
            'email'
        )
            ->where('level','doctor')
            ->where('status','active');

        if($user_priv == 0 || $user_priv == 2)
            $specialists = $specialists->where('muncity',$user->muncity)->get();
        else if($user_priv == 3)
            $specialists = $specialists->where('province',$user->province)->get();

        $data = array();
        foreach($specialists as $s) {
            $arr = array(
                "username" => $s->username,
                "fname" => $s->fname,
                "mname" => isset($s->mname) ? $s->mname : '',
                "lname" => $s->lname
            );
            $facility = FacilityAssign::select(
                "facility_code",
                "specialization",
                "contact",
                "email",
                "schedule",
                "fee"
            )
                ->where('username',$s->username)->get();

            $affiliated = array();
            if(count($facility) == 0) {
                $faci = Facility::select(
                    'facility_code'
                )
                    ->leftJoin('users','users.facility_id','=','facility.id')
                    ->where('users.username',$s->username)->first();

                $temp = array(
                    "facility_code" => isset($faci->facility_code) ? $faci->facility_code : '',
                    "specialization" => "",
                    "contact" => isset($s->contact) ? $s->contact : '',
                    "email" => isset($s->email) ? $s->email : '',
                    "schedule" => "",
                    "fee" => ""
                );
                array_push($affiliated, $temp);
            } else {
                foreach($facility as $faci) {
                    $temp = array(
                        "facility_code" => isset($faci->facility_code) ? $faci->facility_code : '',
                        "specialization" => isset($faci->specialization) ? $faci->specialization : '',
                        "contact" => isset($faci->contact) ? $faci->contact : '',
                        "email" => isset($faci->email) ? $faci->email : '',
                        "schedule" => isset($faci->schedule) ? $faci->schedule : '',
                        "fee" => isset($faci->fee) ? $faci->fee : ''
                    );
                    array_push($affiliated, $temp);
                }
            }

            $arr["affiliated"] = $affiliated;
            array_push($data, $arr);
        }
        return $data;
    }

    public function getFacilities($user_id) {
        $user = User::select('user_priv', 'muncity', 'province')->where('id', $user_id)->first();
        $user_priv = $user->user_priv;

        $facilities = '';
        if($user_priv == 0 || $user_priv == 2) {
            $facilities = Facility::where('muncity',$user->muncity)->get();
        } else if($user_priv == 3) {
            $facilities = Facility::where('province',$user->province)->get();
        }

        $data = array();
        foreach($facilities as $faci) {
            $add_info = Facility2::where('facility_code',$faci->facility_code)->first();
            $arr = array(
                'facility_code' => isset($faci->facility_code) ? $faci->facility_code : '',
                'facility_name' => $faci->name,
                'facility_abbr' => $faci->abbr,
                'prov_id' => $faci->province,
                'muncity_id' => $faci->muncity,
                'brgy_id' => $faci->brgy,
                'address' => $faci->address,
                'contact' => $faci->contact,
                'email' => isset($faci->email) ? $faci->email : '',
                'chief_hospital' => isset($faci->chief_hospital) ? $faci->chief_hospital : '',
                'service_capability' => isset($add_info->service_cap) ? $add_info->service_cap : '',
                'license_status' => ($add_info->licensed == 1) ? 'Licensed' : 'Unlicensed',
                'ownership' => isset($faci->hospital_type) ? $faci->hospital_type : '',
                'facility_status' => ($add_info->facility_status == 1) ? 'Functional' : 'Not Functional',
                'phic_status' => isset($add_info->phic_status) ? $add_info->phic_status : '',
                'referral_status' => ($faci->status == 1) ? 'Active' : 'Inactive',
                'transport' => isset($add_info->transport) ? $add_info->transport : '',
                'latitude' => isset($faci->latitude) ? $faci->latitude : '',
                'longitude' => isset($faci->longitude) ? $faci->longitude : '',
                'sched_day_from' => isset($add_info->sched_day_from) ? $add_info->sched_day_from : '',
                'sched_day_to' => isset($add_info->sched_day_to) ? $add_info->sched_day_to : '',
                'sched_time_from' => isset($add_info->sched_time_from) ? $add_info->sched_time_from : '',
                'sched_time_to' => isset($add_info->sched_time_to) ? $add_info->sched_time_to : '',
                'sched_notes' => isset($add_info->sched_notes) ? $add_info->sched_notes : ''
            );

            $services = array();
            $avail = AvailService::where('facility_code',$faci->facility_code)->get();
            foreach($avail as $s) {
                array_push($services, array(
                    'service_type' => $s->type,
                    'service' => $s->service,
                    'cost' => $s->costing
                ));
            }
            $arr['services_cost'] = $services;
            array_push($data, $arr);
        }
        return $data;
    }

    public function uploadSpecialist(Request $req) {
        $sent = $req->data;
        $muncity = $sent['muncity'];
        $province = $sent['province'];
        for($count = 0; $count < count($sent['specialist']); $count++) {
            $spec = $sent['specialist'][$count];
            $username = $spec['username'];
            $user = ReferralUser::where('username', $username)->first();
            if(count($user) > 0) {
                $data = array(
                    'fname' => $spec['fname'],
                    'mname' => $spec['mname'],
                    'lname' => $spec['lname'],
                );
                ReferralUser::where('username', $username)->update($data);
                FacilityAssign::select('facility_code')->where('username',$username)->delete();
            } else {
                $upload = array(
                    'fname' => $spec['fname'],
                    'mname' => $spec['mname'],
                    'lname' => $spec['lname'],
                    'username' => $spec['username'],
                    'password' => ($spec['password']) ? $spec['password'] : bcrypt('123'),
                    'level' => 'doctor',
                    'facility_id' => 0,
                    'department_id' => 0,
                    'muncity' => $muncity,
                    'province' => $province,
                    'designation' => '',
                    'status' => 'active',
                    'email' => '',
                    'contact' => ''
                );
                ReferralUser::create($upload);
            }
            for ($i = 0; $i < count($spec['affiliated']); $i++) {
                $faci_code = $spec['affiliated'][$i]['facility_code'];
                $faci_data = array(
                    'username' => $username,
                    'facility_code' => isset($faci_code) ? $faci_code : '',
                    'specialization' => isset($spec['affiliated'][$i]['specialization']) ? $spec['affiliated'][$i]['specialization'] : '',
                    'schedule' => isset($spec['affiliated'][$i]['schedule']) ? $spec['affiliated'][$i]['schedule'] : '',
                    'fee' => ($spec['affiliated'][$i]['fee'] !== "PHP .") ? $spec['affiliated'][$i]['fee'] : "",
                    'contact' => isset($spec['affiliated'][$i]['contact']) ? $spec['affiliated'][$i]['contact'] : '',
                    'email' => isset($spec['affiliated'][$i]['email']) ? $spec['affiliated'][$i]['email'] : ''
                );
                FacilityAssign::create($faci_data);
            }
        }

        $counter = 0;
        for($count = 0; $count < count($sent['specialist']); $count++) {
            $user = ReferralUser::where('username', $username)->first();
            $faci = FacilityAssign::where('username', $username)->get();
            if(count($user) > 0 && count($faci) > 0) {
                $counter++;
            }
        }
        if($counter == count($sent['specialist']))
            return array('status' => 'success');
        else
            return array('status' => 'failed');
    }

    public function uploadFacility(Request $req) {
        $sent = $req->data;
        foreach($sent as $faci) {
            $faci_code = $faci['facility_code'];
            AvailService::where('facility_code', $faci_code)->delete();
            foreach($faci['services_cost'] as $s) {
                $service = array(
                    'facility_code' => $faci_code,
                    'service' => $s['service'],
                    'costing' => $s['cost'],
                    'type' => $s['service_type']
                );
                AvailService::create($service);
            }

            $fac = Facility2::where('facility_code', $faci_code)->first();
            if (!$fac)
                $fac = new Facility2();

            $fac->facility_code = $faci_code;
            $fac->service_cap = ($faci['service_capability']) ? $faci['service_capability'] : null;
            $fac->phic_status = ($faci['phic_status']) ? $faci['phic_status'] : '';
            $fac->licensed = ($faci['license_status'] == "Licensed") ? 1 : 0;
            $fac->sched_day_from = ($faci['sched_day_from']) ? $faci['sched_day_from'] : null;
            $fac->sched_day_to = ($faci['sched_day_to']) ? $faci['sched_day_to'] : null;
            $fac->sched_time_from = ($faci['sched_time_from']) ? $faci['sched_time_from'] : null;
            $fac->sched_time_to = ($faci['sched_time_to']) ? $faci['sched_time_to'] : null;
            $fac->sched_notes = ($faci['sched_notes']) ? $faci['sched_notes'] : '';
            $fac->transport = ($faci['transport']) ? $faci['transport'] : null;
            $fac->facility_status = ($faci['facility_status'] == "Functional") ? 1 : 0;
            $fac->save();

            $faci_data = array(
                'facility_code' => $faci_code,
                'name' => $faci['facility_name'],
                'abbr' => $faci['facility_abbr'],
                'address' => $faci['address'],
                'brgy' => $faci['brgy_id'],
                'muncity' => $faci['muncity_id'],
                'province' => $faci['prov_id'],
                'contact' => $faci['contact'],
                'email' => $faci['email'],
                'chief_hospital' => $faci['chief_hospital'],
                'latitude' => $faci['latitude'],
                'longitude' => $faci['longitude'],
                'hospital_type' => $faci['ownership'],
                'status' => ($faci['status']=='Active') ? 1 : 0
            );

            $exist = Facility::where('facility_code', $faci_code)->first();
            if ($exist) {
                $exist->update($faci_data);
            } else {
                Facility::create($faci_data);
            }
        }

        $counter = 0;
        foreach($sent as $faci) {
            $faci = Facility::where('facility_code', $faci_code)->first();
            if(count($faci) > 0) {
                $counter++;
            }
        }
        if($counter == count($sent))
            return array('status' => 'success');
        else
            return array('status' => 'failed');
    }

    public function getProvinces() {
        return Province::select('id', 'description as name')->get();
    }

    public function getMuncities() {
        return Muncity::select('id', 'description as name', 'province_id as prov_id')->get();
    }

    public function getBarangays() {
        return Barangay::select('id','description as name','province_id as prov_id','muncity_id')->get();
    }

}
