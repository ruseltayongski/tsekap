<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\BhertPatient;
use App\Immunization;
use App\IntegrationPatient;
use App\Medication;
use App\Medications;
use App\NutritionStatus;
use App\Profile;
use App\ProfilePending;
use App\Service;
use App\ServiceGroup;
use App\UserBrgy;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use App\BracketServices;
use App\Http\Controllers\ParameterCtrl as Param;
use Illuminate\Support\Facades\Input;
use App\ProfileServices;
use App\Weight;
use App\Height;
use App\ServiceOption;
use App\ProfileCases;
use App\FemaleStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AphroditeConnCtrl as aphrodite_conn;


class ClientCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client');
    }

    public function index(){
        $barangay = UserBrgy::select("barangay.*")->leftJoin("barangay","barangay.id","=","userbrgy.barangay_id")->where('userbrgy.user_id',Auth::user()->id)->get();

        return view('client.home',[
            "barangay" => $barangay
        ]);
    }

    public function count()
    {
        $muncity_id = Auth::user()->muncity;
        $user_priv = Auth::user()->user_priv;
        $bherds_count = 0;
        $validServices = 0;

        if($user_priv==0){
            $countBarangay = Barangay::where('muncity_id',$muncity_id)->count();
            $countPopulation = Profile::where('muncity_id',$muncity_id)->count();
            $target = Barangay::select(DB::raw("SUM(target) as count"))->where('muncity_id',$muncity_id)->first()->count;
            $validServices = Param::countMustService('muncity');
        }
        if($user_priv==2 || $user_priv==4){ // 2 NDP BARANGAY LEVEL AND 4 BHERDS BARANGAY LEVEL
            $countBarangay = UserBrgy::where('user_id',Auth::user()->id)->count();
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $countPopulation = 0;
            $target = 0;
            foreach($tmpBrgy as $tmp){
                $countPopulation += Profile::where('barangay_id',$tmp->barangay_id)->count();
                $target += Barangay::select(DB::raw("SUM(target) as count"))->where('id',$tmp->barangay_id)->first()->count;
            }
            if($user_priv == 2)
                $validServices = Param::countMustService('barangay');
            elseif($user_priv == 4){
                $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
                $bherds_count = BhertPatient::
                    leftJoin('profile','profile.id','=','bhert_patient.profile_id')
                        ->where(function($q) use ($tmpBrgy){
                            foreach($tmpBrgy as $tmp){
                                $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                            }
                        })
                    ->where('bhert_patient.integration_id','=',1)
                    ->count();
            }

        }
        //$validServices = Param::countValidService('','','','');
//        $validServices = Param::countMustService('barangay');
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
            'bhert_count' => $bherds_count,
        );
    }

    public function countPerBarangay($id) {
        $target = 0;
        $countPopulation = 0;
        $profilePercentage = 0;

        if(!$id)
            $id = Session::get('muncityBarangay');

        if($id) {
            $target = Barangay::select(DB::raw("SUM(target) as count"))->where('id',$id)->first()->count;
            $countPopulation = Profile::where('barangay_id', $id)->count();
            $profilePercentage = ($countPopulation / $target) * 100;
            Session::put('muncityBarangay',$id);
        }
        return array(
            'countPopulation' => number_format($countPopulation),
            'profilePercentage' => number_format($profilePercentage,1),
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
            $count = $profileservices->where('dateProfile','>=',$startdate)
                ->where('dateProfile','<=',$enddate)
                ->where('muncity_id',$user->muncity)
                ->groupBy('profile_id');

            if($user->user_priv == 2 || $user->user_priv == 4){ // USER PRIV 2 (NDP), USER PRIV 4 (BHERDS)
                $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
                $count = $count->where(function($q) use ($tmpBrgy){
                    foreach($tmpBrgy as $tmp){
                        $q->orwhere('barangay_id',$tmp->barangay_id);
                    }
                });
                if(count($tmpBrgy)==0){
                    $count = $count->where('barangay_id',0);
                }
            }
            $count = $count->get();
            $data['count'][] = count($count);
        }
        return $data;
    }

    public function population(){
        $temp = Session::get('profileKeyword');

        $keyword = $temp['keyword'];
        $head = $temp['familyHead'];
        $sex = $temp['sex'];
        $barangay = $temp['barangay'];
        $dengvaxia = $temp['dengvaxia'];

        $user = Auth::user();
        $data['profiles'] = Profile::select('profile.id','profile.unique_id','profile.familyID','profile.head','profile.lname','profile.mname','profile.fname','profile.suffix','profile.sex','profile.dob','profile.barangay_id','profile.dengvaxia','profile.sitio_id','profile.purok_id')
            ->where('barangay_id','!=',0);

        if($keyword || $keyword!='' || $keyword!=null){
            $data['profiles'] =  $data['profiles']->where(function($q) use ($keyword){
                $q->where(DB::raw('concat(profile.fname," ",profile.mname," ",profile.lname," ",profile.suffix," ",profile.familyID)'),'like',"%$keyword%")
                    ->orwhere(DB::raw('concat(profile.fname," ",profile.lname," ",profile.suffix," ",profile.familyID)'),'like',"%$keyword%")
                    ->orwhere(DB::raw('concat(profile.lname," ",profile.fname," ",profile.mname," ",profile.suffix," ",profile.familyID)'),'like',"%$keyword%");
            });
        }

        if($head || $head!='' || $head!=null)
        {
            $data['profiles'] = $data['profiles']->where('profile.head',$head);
        }

        if($sex || $sex!='' || $sex!=null)
        {
            if($sex!=='non')
            {
                $data['profiles'] = $data['profiles']->where('profile.sex',$sex);
            }else{
                $data['profiles'] = $data['profiles']->where('profile.sex','');
            }
        }

        if($barangay || $barangay!='' || $barangay!=null)
        {
            $data['profiles'] = $data['profiles']->where('profile.barangay_id',$barangay);
        }

        if($dengvaxia || $dengvaxia!='' || $dengvaxia!=null){
            $data['profiles'] = $data['profiles']->where('profile.dengvaxia',$dengvaxia);
        }

        if($user->user_priv == 0 || $user->user_priv == 4){
            $data['profiles'] = $data['profiles']->where('profile.muncity_id',$user->muncity);
        }

        $data['profiles'] = $data['profiles']->orderBy('profile.lname','asc');
        if($user->user_priv == 2 || $user->user_priv == 4){ //NDP = 2 and //BHERDS = 4
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $data['profiles'] = $data['profiles']->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $data['profiles'] = $data['profiles']->where('profile.barangay_id',0);
            }

            /*if($user->user_priv == 4){
                $data['profile'] = $data['profiles']->leftJoin('bhert_patient','bhert_patient.profile_id','=','profile.id');
                $data['profiles'] = $data['profiles']->where('bhert_patient.integration_id','=',1);
            }*/
        }

        $data['profiles'] = $data['profiles']->orderBy('profile.head','desc')
            ->paginate(20);

        return view('client.population',$data);
    }

    public function searchPopulation(Request $req){
        if($req->viewAll){
            Session::forget('profileKeyword');
            return redirect()->back();
        }
        $data = array(
            'keyword' => $req->keyword,
            'familyHead' => $req->familyHead,
            'sex' => $req->sex,
            'barangay' => $req->barangay,
            'dengvaxia' => $req->dengvaxia
        );
        Session::put('profileKeyword',$data);
        //Session::put('profileKeyword',$req->keyword);
        return self::population();
    }

    public function populationDuplicate(){
        $temp = Session::get('profileKeyword');

        $keyword = $temp['keyword'];
        $head = $temp['familyHead'];
        $sex = $temp['sex'];
        $barangay = $temp['barangay'];
        $dengvaxia = $temp['dengvaxia'];

        $user = Auth::user();
        $data['profiles'] = Profile::select(DB::raw("count(profile.id) as count_duplicate"),'profile.id','profile.unique_id','profile.familyID','profile.head','profile.lname','profile.mname','profile.fname','profile.suffix','profile.sex','profile.dob','profile.barangay_id','profile.dengvaxia','profile.sitio_id','profile.purok_id')
            ->where('barangay_id','!=',0);

        if($keyword || $keyword!='' || $keyword!=null){
            $data['profiles'] =  $data['profiles']->where(function($q) use ($keyword){
                $q->where(DB::raw('concat(profile.fname," ",profile.mname," ",profile.lname," ",profile.suffix," ",profile.familyID)'),'like',"%$keyword%")
                    ->orwhere(DB::raw('concat(profile.fname," ",profile.lname," ",profile.suffix," ",profile.familyID)'),'like',"%$keyword%")
                    ->orwhere(DB::raw('concat(profile.lname," ",profile.fname," ",profile.mname," ",profile.suffix," ",profile.familyID)'),'like',"%$keyword%");
            });
        }

        if($head || $head!='' || $head!=null)
        {
            $data['profiles'] = $data['profiles']->where('profile.head',$head);
        }

        if($sex || $sex!='' || $sex!=null)
        {
            if($sex!=='non')
            {
                $data['profiles'] = $data['profiles']->where('profile.sex',$sex);
            }else{
                $data['profiles'] = $data['profiles']->where('profile.sex','');
            }
        }

        if($barangay || $barangay!='' || $barangay!=null)
        {
            $data['profiles'] = $data['profiles']->where('profile.barangay_id',$barangay);
        }

        if($dengvaxia || $dengvaxia!='' || $dengvaxia!=null){
            $data['profiles'] = $data['profiles']->where('profile.dengvaxia',$dengvaxia);
        }

        if($user->user_priv == 0 || $user->user_priv == 4){
            $data['profiles'] = $data['profiles']->where('profile.muncity_id',$user->muncity);
        }

        $data['profiles'] = $data['profiles']->orderBy('profile.lname','asc');
        if($user->user_priv == 2 || $user->user_priv == 4){ //NDP = 2 and //BHERDS = 4
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $data['profiles'] = $data['profiles']->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $data['profiles'] = $data['profiles']->where('profile.barangay_id',0);
            }

        }

        $data['profiles'] = $data['profiles']->groupBy(DB::raw("concat(profile.fname,profile.mname,profile.lname,profile.sex,profile.dob,profile.barangay_id)"))
            ->havingRaw(DB::raw("count(profile.id) > 1"));

        $data['profiles'] = $data['profiles']->orderBy('profile.lname','asc')
            //->limit(10)
            ->paginate(20);

        return view('client.duplicate_population',$data);
    }

    public function searchPopulationDuplicate(Request $req){
        if($req->viewAll){
            Session::forget('profileKeyword');
            return redirect()->back();
        }
        $data = array(
            'keyword' => $req->keyword,
            'familyHead' => $req->familyHead,
            'sex' => $req->sex,
            'barangay' => $req->barangay,
            'dengvaxia' => $req->dengvaxia
        );
        Session::put('profileKeyword',$data);
        return self::populationDuplicate();
    }

    public function headChild(){
        $temp = Session::get('profileKeyword');

        $keyword = $temp['keyword'];
        $head = $temp['familyHead'];
        $sex = $temp['sex'];
        $barangay = $temp['barangay'];
        $dengvaxia = $temp['dengvaxia'];

        $user = Auth::user();
        $data['profiles'] = Profile::select('profile.id','profile.unique_id','profile.familyID','profile.head','profile.lname','profile.mname','profile.fname','profile.suffix','profile.sex','profile.dob','profile.barangay_id','profile.dengvaxia','profile.sitio_id','profile.purok_id')
            ->where('barangay_id','!=',0);

        if($keyword || $keyword!='' || $keyword!=null){
            $data['profiles'] =  $data['profiles']->where(function($q) use ($keyword){
                $q->where(DB::raw('concat(profile.fname," ",profile.mname," ",profile.lname," ",profile.suffix," ",profile.familyID)'),'like',"%$keyword%")
                    ->orwhere(DB::raw('concat(profile.fname," ",profile.lname," ",profile.suffix," ",profile.familyID)'),'like',"%$keyword%")
                    ->orwhere(DB::raw('concat(profile.lname," ",profile.fname," ",profile.mname," ",profile.suffix," ",profile.familyID)'),'like',"%$keyword%");
            });
        }

        if($head || $head!='' || $head!=null)
        {
            $data['profiles'] = $data['profiles']->where('profile.head',$head);
        }

        if($sex || $sex!='' || $sex!=null)
        {
            if($sex!=='non')
            {
                $data['profiles'] = $data['profiles']->where('profile.sex',$sex);
            }else{
                $data['profiles'] = $data['profiles']->where('profile.sex','');
            }
        }

        if($barangay || $barangay!='' || $barangay!=null)
        {
            $data['profiles'] = $data['profiles']->where('profile.barangay_id',$barangay);
        }

        if($dengvaxia || $dengvaxia!='' || $dengvaxia!=null){
            $data['profiles'] = $data['profiles']->where('profile.dengvaxia',$dengvaxia);
        }

        if($user->user_priv == 0 || $user->user_priv == 4){
            $data['profiles'] = $data['profiles']->where('profile.muncity_id',$user->muncity);
        }

        $data['profiles'] = $data['profiles']->orderBy('profile.lname','asc');
        if($user->user_priv == 2 || $user->user_priv == 4){ //NDP = 2 and //BHERDS = 4
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $data['profiles'] = $data['profiles']->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $data['profiles'] = $data['profiles']->where('profile.barangay_id',0);
            }

        }

        $data['profiles'] = $data['profiles']->where(DB::raw("TIMESTAMPDIFF(YEAR, profile.dob, CURDATE())"),"<=",17)
                                            ->where("profile.head","=","YES");
        $data['profiles'] = $data['profiles']->orderBy('profile.lname','asc')
            ->paginate(20);

        return view('client.head_child',$data);
    }

    public function searchHeadChild(Request $req){
        if($req->viewAll){
            Session::forget('profileKeyword');
            return redirect()->back();
        }
        $data = array(
            'keyword' => $req->keyword,
            'familyHead' => $req->familyHead,
            'sex' => $req->sex,
            'barangay' => $req->barangay,
            'dengvaxia' => $req->dengvaxia
        );
        Session::put('profileKeyword',$data);
        return self::headChild();
    }

    public function addPopulation($id)
    {
        return view('client.addProfile', ['id' => $id]);
    }

    public function savePopulation(Request $req)
    {
        $con=aphrodite_conn::AphroditeConn();
        $dateNow = date('Y-m-d H:i:s');
        $user = Auth::user();
        $fname = mysqli_real_escape_string($con,($req->fname));
        $mname = mysqli_real_escape_string($con,($req->mname));
        $lname = mysqli_real_escape_string($con,($req->lname));
        $unique_id = $fname.''.$mname.''.$lname.''.$req->suffix.''.$req->barangay.''.$user->muncity;
        $unique_id = mysqli_real_escape_string($con,$unique_id);
        $q = "INSERT INTO profile(
                unique_id, familyID, head, relation, 
                fname,mname,lname,suffix,dob,sex,unmet,
                barangay_id,muncity_id,province_id, created_at, updated_at, 
                phicID, nhtsID, education,
                pwd,pwd_desc,pregnant,birth_place,civil_status,religion,other_religion,contact,height,weight,
                cancer,cancer_type,covid_status,menarche,menarche_age,
                newborn_screen,newborn_text,deceased,deceased_date,nhts,four_ps,ip,member_others,balik_probinsya,sexually_active,updated_by)
                VALUES('$unique_id', '$req->familyID', 'NO', '$req->relation', '".$fname."',
                '".$mname."','".$lname."','$req->suffix','".date('Y-m-d',strtotime($req->dob))."','$req->sex','$req->unmet',
                '$req->barangay','$user->muncity','$user->province','$dateNow','$dateNow','$req->phicID','$req->nhtsID','$req->education','$req->pwd','$req->pwd_desc','$req->pregnant',
                '$req->birth_place', '$req->civil_status', '$req->religion', '$req->other_religion', '$req->contact', '$req->height', '$req->weight', '$req->cancer', '$req->cancer_type', '$req->covid_status', '$req->menarche', '$req->menarche_age', '$req->newborn_screen', '$req->newborn_text', '$req->deceased', '$req->deceased_date',
                '$req->nhts', '$req->four_ps', '$req->ip', '$req->member_others', '$req->balik_probinsya', '$req->sexually_active', '$user->id')
            ON DUPLICATE KEY UPDATE
                familyID = '$req->familyID',
                sex = '$req->sex',
                relation = '$req->relation',
                education = '$req->education',
                unmet = '$req->unmet'
            ";
        DB::select($q);

        $profile_id = Profile::where("unique_id",$unique_id)->first()->id;

        if(isset($req->hypertension)) {
            $hyper = new Medication();
            $hyper->profile_id = $profile_id;
            $hyper->type = "Hypertension";
            $hyper->status = $req->hypertension;
            $hyper->remarks = $req->hyper_remarks;
            $hyper->save();
        }

        if(isset($req->diabetic)) {
            $diab = new Medication();
            $diab->profile_id = $profile_id;
            $diab->type = "Diabetic";
            $diab->status = $req->diabetic;
            $diab->remarks = $req->diabetic_remarks;
            $diab->save();
        }

        if(isset($req->mental_med)) {
            $mental = new Medication();
            $mental->profile_id = $profile_id;
            $mental->type = "Mental Health Medication";
            $mental->status = $req->mental_med;
            $mental->remarks = $req->mental_remarks;
            $mental->save();
        }

        if(isset($req->tbdots_med)) {
            $tb = new Medication();
            $tb->profile_id = $profile_id;
            $tb->type = "TB Medication";
            $tb->status = $req->tbdots_med;
            $tb->remarks = $req->tb_remarks;
            $tb->save();
        }

        if(isset($req->cvd_med)) {
            $cvd = new Medication();
            $cvd->profile_id = $profile_id;
            $cvd->type = "CVD Medication";
            $cvd->status = $req->cvd_med;
            $cvd->remarks = $req->cvd_remarks;
            $cvd->save();
        }

        foreach($req->nutri_stat as $nutri) {
            $nstat = new NutritionStatus();
            $nstat->profile_id = $profile_id;
            $nstat->description = $nutri;
            $nstat->save();
        }

        foreach($req->immunization as $immu) {
            $i = new Immunization();
            $i->profile_id = $profile_id;
            $i->description = $immu;
            $i->save();
        }

        $q = "INSERT IGNORE profile_device(profile_id,device) values(
                '$unique_id',
                'web'
            )";
        DB::select($q);

        $q = "INSERT IGNORE servicegroup(profile_id,sex,barangay_id,muncity_id) VALUES(
                '$unique_id',
                '$req->sex',
                '$req->barangay',
                '$user->muncity'
            )";
        $db = 'db_'.date('Y');

        DB::connection($db)->select($q);

        return redirect()->back()->with('status','added');
    }

    public function addHeadProfile()
    {
        return view('client.addHeadProfile');
    }

    public function saveHeadProfile(Request $req)
    {
        $con=aphrodite_conn::AphroditeConn();
        $dateNow = date('Y-m-d H:i:s');
        $user = Auth::user();
        $fname = mysqli_real_escape_string($con,($req->fname));
        $mname = mysqli_real_escape_string($con,($req->mname));
        $lname = mysqli_real_escape_string($con,($req->lname));
        $unique_id = $fname.''.$mname.''.$lname.''.$req->suffix.''.$req->barangay.''.$user->muncity;
        $unique_id = mysqli_real_escape_string($con,$unique_id);
        $q = "INSERT IGNORE profile(
                unique_id, familyID, head, relation, 
                fname,mname,lname,suffix,dob,sex,
                barangay_id,muncity_id,province_id,
                created_at,updated_at,
                phicID, nhtsID, income, unmet, water, toilet, education,
                pwd,pwd_desc,pregnant,birth_place,civil_status,religion, other_religion,contact,height,weight,
                cancer,cancer_type,covid_status,menarche,menarche_age,
                newborn_screen,newborn_text,
                deceased,deceased_date,sexually_active,
                nhts,four_ps,ip,member_others,balik_probinsya,updated_by)
                VALUES('$unique_id', '$req->familyProfile', 'YES', 'Head', '".$fname."',
                '".$mname."','".$lname."','$req->suffix','".date('Y-m-d',strtotime($req->dob))."','$req->sex',
                '$req->barangay','$user->muncity','$user->province','$dateNow','$dateNow','$req->phicID', '$req->nhtsID', 
                '$req->income', '$req->unmet', '$req->water', '$req->toilet', '$req->education', '$req->pwd', '$req->pwd_desc', '$req->pregnant', 
                '$req->birth_place', '$req->civil_status', '$req->religion', '$req->other_religion', '$req->contact', '$req->height', '$req->weight', '$req->cancer', '$req->cancer_type', '$req->covid_status', '$req->menarche', '$req->menarche_age', '$req->newborn_screen', '$req->newborn_text', '$req->deceased', '$req->deceased_date', '$req->sexually_active',
                '$req->nhts', '$req->four_ps', '$req->ip', '$req->member_others', '$req->balik_probinsya',$user->id)
            ";
        //echo $q;
        DB::select($q); //saving profile

        $profile_id = Profile::where("unique_id",$unique_id)->first()->id;

        if(isset($req->hypertension)) {
            $hyper = new Medication();
            $hyper->profile_id = $profile_id;
            $hyper->type = "Hypertension";
            $hyper->status = $req->hypertension;
            $hyper->remarks = $req->hyper_remarks;
            $hyper->save();
        }

        if(isset($req->diabetic)) {
            $diab = new Medication();
            $diab->profile_id = $profile_id;
            $diab->type = "Diabetic";
            $diab->status = $req->diabetic;
            $diab->remarks = $req->diabetic_remarks;
            $diab->save();
        }

        if(isset($req->mental_med)) {
            $mental = new Medication();
            $mental->profile_id = $profile_id;
            $mental->type = "Mental Health Medication";
            $mental->status = $req->mental_med;
            $mental->remarks = $req->mental_remarks;
            $mental->save();
        }

        if(isset($req->tbdots_med)) {
            $tb = new Medication();
            $tb->profile_id = $profile_id;
            $tb->type = "TB Medication";
            $tb->status = $req->tbdots_med;
            $tb->remarks = $req->tb_remarks;
            $tb->save();
        }

        if(isset($req->cvd_med)) {
            $cvd = new Medication();
            $cvd->profile_id = $profile_id;
            $cvd->type = "CVD Medication";
            $cvd->status = $req->cvd_med;
            $cvd->remarks = $req->cvd_remarks;
            $cvd->save();
        }

        foreach($req->nutri_stat as $nutri) {
            $nstat = new NutritionStatus();
            $nstat->profile_id = $profile_id;
            $nstat->description = $nutri;
            $nstat->save();
        }

        foreach($req->immunization as $immu) {
            $i = new Immunization();
            $i->profile_id = $profile_id;
            $i->description = $immu;
            $i->save();
        }

        $q = "INSERT IGNORE profile_device(profile_id,device) values(
                '$unique_id',
                'web'
            )";
        DB::select($q);

        $q = "INSERT IGNORE servicegroup(profile_id,sex,barangay_id,muncity_id) VALUES(
                '$unique_id',
                '$req->sex',
                '$req->barangay',
                '$user->muncity'
            )";
        $db = 'db_'.date('Y');
        DB::connection($db)->select($q);

        return redirect()->back()->with('status','added');
    }

    public function infoPopulation($id)
    {
        $delete = array(
            'table' => 'profile',
            'id' => $id
        );
        Session::put('toDelete',$delete);
        $info = Profile::select('id as profile_id','unique_id','familyID','head','relation','fname','mname','lname','suffix','dob','sex','barangay_id','muncity_id','province_id','relation','phicID','nhtsID','income','unmet','water','toilet','education','hypertension','diabetic','pwd','pwd_desc','pregnant','birth_place','civil_status','religion','other_religion','contact','height','weight','cancer','cancer_type','mental_med','tbdots_med','cvd_med','covid_status','menarche',
            'menarche_age','newborn_screen','newborn_text','deceased','deceased_date','sexually_active','nhts','four_ps','ip','member_others','balik_probinsya', 'updated_by')
            ->where('id',$id)
            ->first();
        Session::put('profile_id',$id);

        $nutri_stat = NutritionStatus::select('description as nutri')->where('profile_id', $id)->get();
        $immu_stat = Immunization::select('description as immu')->where('profile_id', $id)->get();
        $medication = Medication::where('profile_id',$id)->get();

        if(count($medication) > 0) {
            foreach($medication as $med) {
                if($med->type === 'Hypertension') {
                    $hyper_status = $med->status;
                    $hyper_remarks = $med->remarks;
                } else if($med->type === 'Diabetic') {
                    $diab_status = $med->status;
                    $diab_remarks = $med->remarks;
                } else if($med->type === 'Mental Health Medication') {
                    $mental_status = $med->status;
                    $mental_remarks = $med->remarks;
                } else if($med->type === 'TB Medication') {
                    $tb_status = $med->status;
                    $tb_remarks = $med->remarks;
                } else if($med->type === 'CVD Medication') {
                    $cvd_status = $med->status;
                    $cvd_remarks = $med->remarks;
                }
            }
        } else {
            if($info->updated_by === '') {
                if(isset($info->hypertension))
                    $hyper_status = $info->hypertension;
                if(isset($info->diabetic))
                    $diab_status = $info->diabetic;
                if(isset($info->mental_med))
                    $mental_status = $info->mental_med;
                if(isset($info->tbdots_med))
                    $tb_status = $info->tbdots_med;
                if(isset($info->cvd_med))
                    $cvd_status = $info->cvd_med;

                $hyper_remarks = '';
                $diab_remarks = '';
                $mental_remarks = '';
                $tb_remarks = '';
                $cvd_remarks = '';
            }
        }

        return view('client.updateProfile',[
            'info' => $info,
            'nutri_stat' => $nutri_stat,
            'immu_stat' => $immu_stat,
            'hyper_status' => $hyper_status,
            'hyper_remarks' => $hyper_remarks,
            'diab_status' => $diab_status,
            'diab_remarks' => $diab_remarks,
            'mental_status' => $mental_status,
            'mental_remarks' => $mental_remarks,
            'tb_status' => $tb_status,
            'tb_remarks' => $tb_remarks,
            'cvd_status' => $cvd_status,
            'cvd_remarks' => $cvd_remarks
        ]);
    }

    public function updatePopulation(Request $req)
    {
        $user = Auth::user();
        $muncity_id = Auth::user()->muncity;
        Session::put('deleteProfile',$req->currentID);
        if($req->update){
            if($req->head=='YES'){
                $relation = 'Head';
            }else{
                $relation = $req->relation;
            }
            $fname = ($req->fname);
            $mname = ($req->mname);
            $lname = ($req->lname);
            $update = array(
                'familyID' => $req->familyName,
                'phicID' => $req->phicID,
                'nhtsID' => $req->nhtsID,
                'head' => $req->head,
                'relation' => $relation,
                'fname' => $fname,
                'mname' => $mname,
                'lname' => $lname,
                'suffix' => $req->suffix,
                'dob' => $req->dob,
                'sex' => $req->sex,
                'unmet' => $req->unmet,
                'barangay_id' => $req->barangay,
                'education' => $req->education,
                'pwd' => $req->pwd,
                'pwd_desc' => $req->pwd_desc,
                'pregnant' => $req->pregnant,
                'birth_place' => $req->birth_place,
                'civil_status' => $req->civil_status,
                'religion' => $req->religion,
                'other_religion' => $req->other_religion,
                'contact' => $req->contact,
                'height' => $req->height,
                'weight' => $req->weight,
                'cancer' => $req->cancer,
                'cancer_type' => $req->cancer_type,
                'covid_status' => $req->covid_status,
                'menarche' => $req->menarche,
                'menarche_age' => $req->menarche_age,
                'newborn_screen' => $req->newborn_screen,
                'newborn_text' => $req->newborn_text,
                'deceased' => $req->deceased,
                'deceased_date' => $req->deceased_date,
                'nhts' => $req->nhts,
                'four_ps' => $req->four_ps,
                'ip' => $req->ip,
                'member_others' => $req->member_others,
                'balik_probinsya' => $req->balik_probinsya,
                'sexually_active' => $req->sexually_active,
                'updated_by' => $user->id
            );
            if($relation=='Head')
            {
                $update['income'] = $req->income;
                $update['water'] = $req->water;
                $update['toilet'] = $req->toilet;
            }
            //$unique_id =$fname.''.$mname.''.$lname.''.$req->suffix.''.$req->barangay.''.$muncity_id;
            $unique_id = $req->unique_id;

            $profile_id = Profile::where("unique_id",$unique_id)->first()->id;
            NutritionStatus::where('profile_id', $profile_id)->delete();
            Immunization::where('profile_id', $profile_id)->delete();
            Medication::where('profile_id', $profile_id)->delete();

            if(isset($req->hypertension)) {
                $hyper = new Medication();
                $hyper->profile_id = $profile_id;
                $hyper->type = "Hypertension";
                $hyper->status = $req->hypertension;
                $hyper->remarks = $req->hyper_remarks;
                $hyper->save();
            }

            if(isset($req->diabetic)) {
                $diab = new Medication();
                $diab->profile_id = $profile_id;
                $diab->type = "Diabetic";
                $diab->status = $req->diabetic;
                $diab->remarks = $req->diabetic_remarks;
                $diab->save();
            }

            if(isset($req->mental_med)) {
                $mental = new Medication();
                $mental->profile_id = $profile_id;
                $mental->type = "Mental Health Medication";
                $mental->status = $req->mental_med;
                $mental->remarks = $req->mental_remarks;
                $mental->save();
            }

            if(isset($req->tbdots_med)) {
                $tb = new Medication();
                $tb->profile_id = $profile_id;
                $tb->type = "TB Medication";
                $tb->status = $req->tbdots_med;
                $tb->remarks = $req->tb_remarks;
                $tb->save();
            }

            if(isset($req->cvd_med)) {
                $cvd = new Medication();
                $cvd->profile_id = $profile_id;
                $cvd->type = "CVD Medication";
                $cvd->status = $req->cvd_med;
                $cvd->remarks = $req->cvd_remarks;
                $cvd->save();
            }

            foreach($req->nutri_stat as $nutri) {
                $nstat = new NutritionStatus();
                $nstat->profile_id = $profile_id;
                $nstat->description = $nutri;
                $nstat->save();
            }

            foreach($req->immunization as $immu) {
                $i = new Immunization();
                $i->profile_id = $profile_id;
                $i->description = $immu;
                $i->save();
            }

            $validate = self::validatePopulation($unique_id,$req->currentID);
            if(!$validate){
                $data = Profile::where('id',$req->currentID);
                $prevProfile = $data->first()->unique_id;
                $update['unique_id'] = $unique_id;
                //Profile::where('id',$req->currentID)
                $data->update($update);
                $servicegroup = new ServiceGroup();
                $servicegroup->setConnection('db_'.date('Y'));
                $servicegroup->where('profile_id',$prevProfile)
                    ->update(['profile_id' => $unique_id]);
                return redirect()->back()->with('status','updated');
            }else{
                return redirect()->back()->with('status','duplicate');
            }
        }else{
            echo 'deleted';
        }
    }

    public function validatePopulation($unique_id,$id=0)
    {
        $valid = Profile::where('id','!=',$id)
            ->where('unique_id',$unique_id)
            ->first();
        if($valid)
            return true;
        else
            return false;
    }
    public function services($id=null){
        $temp = Session::get('profileKeyword');
        $keyword = $temp['keyword'];
        $user = Auth::user();
        $bracket = null;
        $profiles = Profile::orderBy('lname','asc');

        if($keyword || $keyword!='' || $keyword!=null){
            $profiles =  $profiles->where(function($q) use ($keyword){
                $q->where(DB::raw('concat(fname," ",mname," ",lname," ",suffix," ",familyID)'),'like',"%$keyword%")
                    ->orwhere(DB::raw('concat(fname," ",lname," ",suffix," ",familyID)'),'like',"%$keyword%")
                    ->orwhere(DB::raw('concat(lname," ",fname," ",mname," ",suffix," ",familyID)'),'like',"%$keyword%");
            });
        }

        if(Auth::user()->user_priv==0 || Auth::user()->user_priv==4){
            $profiles = $profiles->where('muncity_id',$user->muncity);
        }

        if(Auth::user()->user_priv==2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $profiles = $profiles->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $profiles = $profiles->where('profile.barangay_id',0);
            }
        }
        $profiles = $profiles->orderBy('fname','asc')
            ->paginate(10);

        $validateID = Profile::where('id',$id)->where('muncity_id',$user->muncity)->first();
        if(!$validateID){
            return view('client.services',['profiles' => $profiles,'id' => null, 'bracket' => $bracket]);
        }
        if($id){
            $bracket = self::bracketServices($id);
        }

        $profile_id = Profile::find($id)->unique_id;
//        $recordS = ProfileServices::where('profile_id',$profile_id)
//                ->orderBy('dateProfile','asc')
//                ->get();
//        $recordC = ProfileCases::where('profile_id',$profile_id)
//            ->orderBy('dateProfile','asc')
//            ->get();
        $recordS = array();
        $recordC = array();
        $years = ParameterCtrl::getYear();
        foreach($years as $year){
            $db = 'db_'.$year;
            $profileservices = new ProfileServices();
            $profileservices->setConnection($db);
            $tmp = $profileservices->where('profileservices.profile_id',$profile_id)
                ->leftJoin('tsekap_main.services','services.id','=','profileservices.service_id')
                ->orderBy('dateProfile','asc')
                ->get();
            foreach($tmp as $s){
                $recordS[] = array(
                    'service' => $s->description,
                    'date' => date('M d, Y',strtotime($s->dateProfile))
                );
            }
        }

        foreach($years as $year)
        {
            $db = 'db_'.$year;
            $profilecases = new ProfileCases();
            $profilecases->setConnection($db);
            $tmp = $profilecases->where('profilecases.profile_id',$profile_id)
                ->leftJoin('tsekap_main.cases','cases.id','=','profilecases.case_id')
                ->orderBy('dateProfile','asc')
                ->get();
            foreach($tmp as $c){
                $recordC[] = array(
                    'case' => $c->description,
                    'date' => date('M d, Y',strtotime($c->dateProfile))
                );
            }
        }

        return view('client.services',[
            'profiles' => $profiles,
            'id' => $id,
            'bracket' => $bracket,
            'recordS' => $recordS,
            'recordC' => $recordC
        ]);
    }

    public function memberPopulation($id)
    {

        $muncity_id = Auth::user()->muncity;
        $members = Profile::where('familyID',$id)
            ->where('muncity_id',$muncity_id)
            ->orderBy('head','desc')
            ->orderBy('fname','asc')->get();

        $details = Profile::select('income','unmet','water','toilet')
            ->where('familyID',$id)
            ->where('muncity_id',$muncity_id)
            ->where('head','Yes')
            ->first();

        $data['details'] = array(
            'income' => self::incomeRange($details->income),
            'familyClass' => self::familyClass($details->income),
            'unmet' => ($details->unmet==0) ? 'Not Set': 'Option '.$details->unmet,
            'water' => ($details->water==0) ? 'Not Set': 'Level '.$details->water,
            'toilet' => self::sanitaryToilet($details->toilet)
        );
        $data['members'] = $members;
        return $data;
    }

    static function sanitaryToilet($toilet)
    {
        switch($toilet){
            case 'non':
                return 'None';
            case 'comm':
                return 'Communal';
            case 'indi':
                return 'Individual Household';
            default:
                return 'Not Set';
        }
    }
    static function incomeRange($income)
    {
        switch($income){
            case 1:
                return 'Less than PHP 7,890 per month';
            case 2:
                return 'Between PHP 7,890 to PHP 15,780 per month';
            case 3:
                return 'Between PHP 15,780 to PHP 31,560 per month';
            case 4:
                return 'Between PHP 31,560 to PHP 78,900 per month';
            case 5:
                return 'Between PHP78,900 to PHP 118,350 per month';
            case 6:
                return 'Between PHP 118,350 to PHP 157,800';
            case 7:
                return 'At least PHP 157,800';
            default:
                return 'Not set';
        }
    }

    static function familyClass($income)
    {
        switch($income){
            case 1:
                return 'Poor';
            case 2:
                return 'Low income but not poor';
            case 3:
                return 'Lower middle income';
            case 4:
                return 'Middle class';
            case 5:
                return 'Upper middle income';
            case 6:
                return 'Upper income but not rich';
            case 7:
                return 'Rich';
            default:
                return 'Not set';
        }
    }

    public function bracketServices($id){
        $option = null;
        $dob = Profile::find($id)->dob;
        $brgy_id = Profile::find($id)->barangay_id;
        $age = Param::getAge($dob);
        if($age==0){
            $age = Param::getAgeMonth($dob).' M/o';
            $option = 'B';
            if($age==0){
                $option = 'A';
                $age = Param::getAgeDay($dob).' D/o';

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
        $services = Service::select('services.id','services.description')
            ->leftJoin('bracketservices','services.id','=','bracketservices.service_id')
            ->leftJoin('brackets','bracketservices.bracket_id','=','brackets.id')
            ->where('brackets.id',$bracket_id)
            ->get();
        $data = array(
            'services' => $services,
            'age' => $age,
            'dob' => $dob,
            'id' => $id,
            'brgy_id' => $brgy_id,
            'bracket_id' => $bracket_id,
            'dob' => $dob
        );
        return $data;
    }


    public function searchServices(Request $req)
    {
        Session::put('profileKeyword',[
            'keyword' => $req->profileKeyword,
            'familyHead' => '',
            'sex' => '',
            'barangay' => ''
        ]);
        return self::services();
    }

    public function saveServices(Request $req)
    {
        $year = date('Y',strtotime($req->date));
        $date = date('Y-m-d',strtotime($req->date));
        $dateP = date('mdY',strtotime($req->date));
        $profileID = $req->profileID;
        $brgy_id = $req->brgy_id;
        $muncity_id = Auth::user()->muncity;
        $bracket_id = $req->bracket_id;
        //$profileID = self::getPrefix($profileID);
        $profileID = Profile::find($profileID)->unique_id;
        $gender = Profile::where('unique_id',$profileID)->first()->sex;
        $status = isset($req->femalestatus) ? $req->femalestatus : null;
        for($i=0; $i<count($req->services); $i++)
        {
            $s = $req->services;
            $unique_id = $dateP.''.$profileID.''.$bracket_id.''.$s[$i];
            $q = "INSERT IGNORE profileservices(unique_id,sex,status, dateProfile, profile_id, service_id, bracket_id, barangay_id, muncity_id)
                            VALUES('$unique_id','$gender','$status', '$date', '$profileID', '$s[$i]', '$bracket_id', '$brgy_id', '$muncity_id')
                        ";
            $db = 'db_'.$year;
            DB::connection($db)->select($q);

            $code = Service::find($s[$i])->code;
            $unique_id = $dateP.''.$profileID.''.$req->femalestatus.''.$code;

            $group = Param::checkGroup($s[$i]);
            Param::saveServiceGroup($profileID,$gender,$group,$brgy_id,$muncity_id,$bracket_id,$date,$db,$year);
        }

        for($i=0; $i<count($req->cases); $i++)
        {
            $s = $req->cases;
            $unique_id = $dateP.''.$profileID.''.$bracket_id.''.$s[$i];
            $q = "INSERT IGNORE profilecases(unique_id,sex,status, dateProfile, profile_id, case_id, bracket_id, barangay_id, muncity_id)
                    VALUES('$unique_id','$gender','$status', '$date', '$profileID', '$s[$i]', '$bracket_id', '$brgy_id', '$muncity_id')
                ";
            $db = 'db_'.$year;
            DB::connection($db)->select($q);
        }

        if($req->weight){
            $unique_id = $dateP.''.$profileID.'weight'.$req->weight;
            $q = "INSERT IGNORE serviceoption(unique_id, dateProfile, profile_id, serviceoption.option, serviceoption.status, barangay_id, muncity_id)
                    VALUES('$unique_id', '$date', '$profileID', 'weight', '$req->weight', '$brgy_id', '$muncity_id')
                ";
            $db = 'db_'.$year;
            DB::connection($db)->select($q);
        }

        if($req->height){
            $unique_id = $dateP.''.$profileID.'height'.$req->height;
            $q = "INSERT IGNORE serviceoption(unique_id, dateProfile, profile_id, serviceoption.option, serviceoption.status, barangay_id, muncity_id)
                    VALUES('$unique_id', '$date', '$profileID', 'height', '$req->height', '$brgy_id', '$muncity_id')
                ";
            $db = 'db_'.$year;
            DB::connection($db)->select($q);
        }

        if($req->bp){
            $unique_id = $dateP.''.$profileID.'bp'.$req->weight;
            $q = "INSERT IGNORE serviceoption(unique_id, dateProfile, profile_id, serviceoption.option, serviceoption.status, barangay_id, muncity_id)
                    VALUES('$unique_id', '$date', '$profileID', 'bp', '$req->bp', '$brgy_id', '$muncity_id')
                ";
            $db = 'db_'.$year;
            DB::connection($db)->select($q);
        }

        return redirect('user/services')->with('status','added');
    }

    static function validateService($bracket_id,$code)
    {
        $service_id = Service::where('code',$code)->first()->id;
        $validate = BracketServices::where('bracket_id',$bracket_id)
            ->where('service_id',$service_id)
            ->first();
        if($validate){
            return true;
        }
        return false;
    }

    public function updateDate(Request $req){
        $date = date('M d, Y',strtotime($req->date));
        Session::put('currentDate',$date);
        return redirect()->back();
    }

    public function report(){
        $user = Auth::user();
        $keyword = Session::get('filterResult');
        $year = Carbon::now()->format('Y');

        $db = 'db_'.$year;
        $startdate = $year.'-01-01';
        $enddate = $year.'-12-31';
        if($keyword){
            $db = 'db_'.$keyword['year'];
            $startdate = $keyword['year'].'-'.$keyword['monthF'].'-01';
            $enddate = $keyword['year'].'-'.$keyword['monthT'].'-31';
        }

        $bracket_id = $keyword['bracket_id'];
        $barangay_id = $keyword['barangay_id'];
        $service_id = $keyword['service_id'];
        $name = $keyword['name'];

        $profileservices = new ProfileServices();
        $profileservices->setConnection($db);

        $data = $profileservices->select('profile_id','service_id','barangay_id','id','dateProfile')
            ->where('dateProfile','>=',$startdate)
            ->where('dateProfile','<=',$enddate)
            ->where('profile_id','like',"%$name%");

        $tmp = $profileservices->select('profile_id','service_id','barangay_id','id','dateProfile')
            ->where('dateProfile','>=',$startdate)
            ->where('dateProfile','<=',$enddate)
            ->where('profile_id','like',"%$name%");

        if($service_id){
            $data = $data->where('service_id',$service_id);
            $tmp = $tmp->where('service_id',$service_id);
        }
        if($bracket_id){
            $data = $data->where('bracket_id',$bracket_id);
            $tmp = $tmp->where('bracket_id',$bracket_id);
        }
        if($barangay_id){
            $data = $data->where('barangay_id',$barangay_id);
            $tmp = $tmp->where('barangay_id',$barangay_id);
        }

        $data = $data->where('muncity_id',$user->muncity);
        $tmp = $tmp->where('muncity_id',$user->muncity);

        if(Auth::user()->user_priv==2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $data = $data->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $data = $data->where('barangay_id',0);
            }

            $tmp = $tmp->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $tmp = $tmp->where('barangay_id',0);
            }
        }

        $profiles = $data->orderBy('profileservices.id','desc')->paginate(15);
        $count = $tmp->groupBy('profileservices.profile_id')->get();
        $total = count($count);

        return view('client.report',[
            'total'=>$total,
            'profiles'=> $profiles,
            'year'=>$keyword['year'],
            'monthF'=>$keyword['monthF'],
            'monthT'=>$keyword['monthT'],
            'bracket_id' => $bracket_id,
            'barangay_id'=>$barangay_id,
            'service_id'=>$service_id,
            'name'=>$name
        ]);
    }

    public function searchReport(Request $req){
        str_pad($req->monthF, 2, '0', STR_PAD_LEFT);
        $keyword = array(
            'year' => $req->year,
            'monthF' => str_pad($req->monthF, 2, '0', STR_PAD_LEFT),
            'monthT' => str_pad($req->monthT, 2, '0', STR_PAD_LEFT),
            'bracket_id' => $req->bracket_id,
            'barangay_id' => $req->barangay_id,
            'service_id' => $req->service_id,
            'name' => $req->name
        );

        Session::put('filterResult',$keyword);
        return self::report();
    }

    public function deleteReport(Request $req)
    {
        $id = $req->currentID;
        $year = $req->year;
        $db = 'db_'.$year;

        $profileservices = new ProfileServices();
        $profileservices->setConnection($db);

        $data = $profileservices->find($id);
        $service_id = $data->service_id;
        $code = Service::find($service_id)->code;
        $code = strtolower($code);
        $profile_id = $data->profile_id;
        $dateProfile = date('mdY',strtotime($data->dateProfile));
        $serviceoption_unique_id = $dateProfile.$profile_id.$code;

        $serviceoption = new ServiceOption();
        $serviceoption->setConnection($db);
        $serviceoption->where('unique_id',$serviceoption_unique_id)->delete();


        $profileservices->where('id',$id)->delete();

        $servicegroup = new ServiceGroup();
        $servicegroup->setConnection($db);

        $servicegroup->where('profile_id',$profile_id)->delete();
        $list = $profileservices->where('profile_id',$profile_id)->get();
        foreach($list as $r)
        {
            $group = Param::checkGroup($r->service_id);
            Param::saveServiceGroup($r->profile_id,$r->sex,$group,$r->barangay_id,$r->muncity_id,$r->bracket_id,$r->dateProfile,$db,$year);
        }
        return redirect()->back()->with('status','deleted');
    }

    public function casesReport(){
        $user = Auth::user();
        $keyword = Session::get('filterCases');

        $db = 'db_'.date('Y');
        $startdate = date('Y').'-01-01';
        $enddate = date('Y').'-12-31';
        if($keyword){
            $db = 'db_'.$keyword['year'];
            $startdate = $keyword['year'].'-'.$keyword['monthF'].'-01';
            $enddate = $keyword['year'].'-'.$keyword['monthT'].'-31';
        }

        $bracket_id = $keyword['bracket_id'];
        $barangay_id = $keyword['barangay_id'];
        $case_id = $keyword['case_id'];
        $name = $keyword['name'];

        $profilecases = new ProfileCases();
        $profilecases->setConnection($db);

        $data = $profilecases->select('profile_id','case_id','barangay_id','id','dateProfile')
            ->where('dateProfile','>=',$startdate)
            ->where('dateProfile','<=',$enddate)
            ->where('profile_id','like',"%$name%");

        $tmp = $profilecases->select('profile_id','case_id','barangay_id','id','dateProfile')
            ->where('dateProfile','>=',$startdate)
            ->where('dateProfile','<=',$enddate)
            ->where('profile_id','like',"%$name%");

        if($case_id){
            $data = $data->where('case_id',$case_id);
            $tmp = $tmp->where('case_id',$case_id);
        }
        if($bracket_id){
            $data = $data->where('bracket_id',$bracket_id);
            $tmp = $tmp->where('bracket_id',$bracket_id);
        }
        if($barangay_id){
            $data = $data->where('barangay_id',$barangay_id);
            $tmp = $tmp->where('barangay_id',$barangay_id);
        }

        $data = $data->where('muncity_id',$user->muncity);
        $tmp = $tmp->where('muncity_id',$user->muncity);

        if(Auth::user()->user_priv==2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $data = $data->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $data = $data->where('barangay_id',0);
            }

            $tmp = $tmp->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $t){
                    $q->orwhere('barangay_id',$t->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $tmp = $tmp->where('barangay_id',0);
            }
        }
        $tmp = $tmp->groupBy('profile_id')->get();
        $profiles = $data->orderBy('id','desc')->paginate(15);
        $total = count($tmp);

        return view('client.case',[
            'total'=>$total,
            'profiles'=> $profiles,
            'year'=>$keyword['year'],
            'monthF'=>$keyword['monthF'],
            'monthT'=>$keyword['monthT'],
            'year'=>$keyword['year'],
            'bracket_id' => $bracket_id,
            'barangay_id'=>$barangay_id,
            'case_id'=>$case_id,
            'name'=>$name
        ]);
    }

    public function searchCase(Request $req){
        $keyword = array(
            'year' => $req->year,
            'monthF' => str_pad($req->monthF, 2, '0', STR_PAD_LEFT),
            'monthT' => str_pad($req->monthT, 2, '0', STR_PAD_LEFT),
            'bracket_id' => $req->bracket_id,
            'barangay_id' => $req->barangay_id,
            'case_id' => $req->case_id,
            'name' => $req->name
        );

        Session::put('filterCases',$keyword);
        return self::casesReport();
    }

    public function deleteCase(Request $req)
    {
        $id = $req->currentID;
        $year = $req->currentYear;
        $db = 'db_'.$year;
        $profilecases = new ProfileCases();
        $profilecases->setConnection($db);
        $profilecases->where('id',$id)->delete();
        return redirect()->back()->with('status','deleted');
    }

    public function monthlyReport(Request $req)
    {
        $month = isset($req->month) ? $req->month : date('m');
        $year = isset($req->year) ? $req->year: date('Y');

        return view('client.monthly',['month' => $month, 'year' => $year]);
    }

    public function getFamilyProfiles()
    {
        $keyword = Input::get('key');
        if(Input::get('q'))
        {
            $keyword = Input::get('q');
        }
        $profiles = FamilyProfile::select('familyprofile.id','familyprofile.description','profile.fname','profile.mname','profile.lname')
            ->leftJoin('profile','familyprofile.id','=','profile.familyID')
            ->where(function($q) use ($keyword){
                $q->where('profile.fname','like',"%$keyword%")
                    ->orwhere('profile.mname','like',"%$keyword%")
                    ->orwhere('profile.lname','like',"%$keyword%")
                    ->orwhere('familyprofile.description','like',"%$keyword%")
                    ->orwhere('familyprofile.id',"$keyword");
            })
            ->where('profile.muncity_id',Auth::user()->muncity);
        if(Auth::user()->user_priv==2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $profiles = $profiles->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $profiles = $profiles->where('profile.barangay_id',0);
            }
        }
        $profiles = $profiles->where('profile.head','YES')
            ->orderBy('familyprofile.description','asc')
            ->get();
        $row = array();
        foreach($profiles as $p)
        {
            $row[] = $p;
        }
        $data = array(
            'total_count' => count($profiles),
            'items' => $row
        );
        return $data;
    }

    public function getProfiles()
    {
        $keyword = Input::get('key');
        if(Input::get('q'))
        {
            $keyword = Input::get('q');
        }
        $profiles = FamilyProfile::select('profile.id','familyprofile.description','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('profile','familyprofile.id','=','profile.familyID')
            ->where(function($q) use ($keyword){
                $q->where('profile.fname','like',"%$keyword%")
                    ->orwhere('profile.mname','like',"%$keyword%")
                    ->orwhere('profile.lname','like',"%$keyword%")
                    ->orwhere('familyprofile.description','like',"%$keyword%")
                    ->orwhere('familyprofile.id',"$keyword");
            })
            ->where('profile.muncity_id',Auth::user()->muncity);
        if(Auth::user()->user_priv==2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $profiles = $profiles->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $profiles = $profiles->where('profile.barangay_id',0);
            }
        }
        $profiles = $profiles->orderBy('familyprofile.description','asc')
            ->get();
        $row = array();
        foreach($profiles as $p)
        {
            $row[] = array(
                'id' => $p->id,
                'description' => $p->description,
                'full_name' => $p->fname.' '.$p->mname.' '.$p->lname.' '.$p->suffix
            );
        }
        $data = array(
            'total_count' => count($profiles),
            'items' => $row
        );
        return $data;
    }

    public function addUser()
    {
        $keyword = Session::get('userKeyword');
        $muncity_id = Auth::user()->muncity;
        $users = User::where(function($q) use ($keyword){
            $q->where('lname','like',"%$keyword%")
                ->orwhere('mname','like',"%$keyword%")
                ->orwhere('fname','like',"%$keyword%")
                ->orwhere('username','like',"%$keyword%");
        })
            ->where('muncity',$muncity_id)
            ->where('id','!=', Auth::user()->id)
            ->where('user_priv','!=','1')
            ->where('user_priv','!=','3')
            ->orderBy('lname','asc')
            ->orderBy('fname','desc')
            ->paginate(10);
        return view('client.add',['users'=>$users]);
    }

    public function searchUser(Request $req){
        $keyword = $req->userKeyword;
        Session::put('userKeyword',$keyword);
        return self::addUser();
    }

    public function saveUser(Request $req)
    {
        echo '<pre>';
        print_r($_POST);

        $name = array(
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname,
            'muncity' => Auth::user()->muncity,
            'province' => Auth::user()->province
        );
        $validate = User::where($name)->first();
        if($validate)
        {
            return redirect()->back()->with('status','duplicate');
        }else{
            $valUser = User::where('username',$req->username)->first();
            if($valUser){
                return redirect()->back()->with('status','duplicate2');
            }else{
                $name['username'] = $req->username;
                $name['password'] = bcrypt($req->password);
                $name['user_priv'] = $req->user_priv;
                $name['contact'] = $req->contact;
                $q = new User();
                foreach($name as $key => $val){
                    $q->$key = $val;
                }
                $q->save();
                $last_id = User::where($name)->first()->id;
                $brgy = $req->barangay;
                for($i=0;$i<count($brgy);$i++){
                    $b = new UserBrgy();
                    $b->user_id = $last_id;
                    $b->barangay_id = $brgy[$i];
                    $b->save();
                }
                return redirect()->back()->with('status','added');
            }
        }
    }

    public function updateUser(Request $req){
        echo '<pre>';
        print_r($_POST);
        $id = $req->currentID;
        $name = array(
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname,
            'muncity' => Auth::user()->muncity,
            'province' => Auth::user()->province
        );
        $validate = User::where($name)->where('id','!=',$id)->first();
        if($validate){
            return redirect()->back()->with('status','duplicate');
        }else{
            $valUser = User::where('username',$req->username)
                ->where('id','!=',$id)
                ->first();
            if($valUser){
                return redirect()->back()->with('status','duplicate2');
            }else{
                $name['username'] = $req->username;
                $name['contact'] = $req->contact;
                $name['user_priv'] = $req->user_priv;
                if($req->password){
                    $name['password'] = bcrypt($req->password);
                }
            }
            User::where('id',$id)->update($name);
            UserBrgy::where('user_id',$id)->delete();
            $brgy = $req->barangay;
            for($i=0;$i<count($brgy);$i++){
                $b = new UserBrgy();
                $b->user_id = $id;
                $b->barangay_id = $brgy[$i];
                $b->save();
            }
            return redirect()->back()->with('status','updated');
        }
    }

    public function infoUser($id)
    {
        $data['info'] = User::find($id);
        $brgy = UserBrgy::where('user_id',$id)->get();
        $data['brgy'] = array();
        foreach($brgy as $b){
            $data['brgy'][] = $b->barangay_id;
        }
        $delete = array(
            'table' => 'users',
            'id' => $id
        );
        Session::put('toDelete',$delete);
        return $data;
    }

    public function downloadReport(Request $req)
    {
        $year = $req->year;
        $start = $year.'-01-01';
        $end = $year.'-12-31';
        $user = Auth::user();

        $filename = $user->username.'-'.date('Y-m-d');

        $profile = Profile::where('muncity_id',$user->muncity);
        if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',$user->id)->get();
            $profile = $profile->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $profile = $profile->where('barangay_id',0);
            }
        }
        $profile = $profile->get();

        $profileservices = ProfileServices::select('profileservices.dateProfile','profileservices.service_id','profileservices.bracket_id','profileservices.barangay_id','profileservices.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('profile','profileservices.profile_id','=','profile.unique_id')
            ->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<=',$end)
            ->where('profileservices.muncity_id',$user->muncity);
        if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',$user->id)->get();
            $profileservices = $profileservices->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profileservices.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $profileservices = $profileservices->where('profileservices.barangay_id',0);
            }
        }
        $profileservices = $profileservices->get();

        $profilecases = ProfileCases::select('profilecases.dateProfile','profilecases.case_id','profilecases.bracket_id','profilecases.barangay_id','profilecases.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('profile','profilecases.profile_id','=','profile.unique_id')
            ->where('profilecases.dateProfile','>=',$start)
            ->where('profilecases.dateProfile','<=',$end)
            ->where('profilecases.muncity_id',$user->muncity);
        if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',$user->id)->get();
            $profilecases = $profilecases->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profilecases.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $profilecases = $profilecases->where('profilecases.barangay_id',0);
            }
        }
        $profilecases = $profilecases->get();

        $status1 = ProfileServices::select('profileservices.dateProfile','profileservices.status','profileservices.service_id','profileservices.barangay_id','profileservices.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('profile','profileservices.profile_id','=','profile.unique_id')
            ->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<=',$end)
            ->where('profileservices.muncity_id',$user->muncity)
            ->where('profileservices.status','!=',null);
        if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',$user->id)->get();
            $status1 = $status1->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profileservices.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $status1 = $status1->where('profileservices.barangay_id',0);
            }
        }
        $status1 = $status1->get();

        $status2 = ProfileCases::select('profilecases.dateProfile','profilecases.status','profilecases.case_id','profilecases.barangay_id','profilecases.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('profile','profilecases.profile_id','=','profile.unique_id')
            ->where('profilecases.dateProfile','>=',$start)
            ->where('profilecases.dateProfile','<=',$end)
            ->where('profilecases.muncity_id',$user->muncity)
            ->where('profilecases.status','!=',null);
        if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',$user->id)->get();
            $status2 = $status2->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profilecases.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $status2 = $status2->where('profilecases.barangay_id',0);
            }
        }
        $status2 = $status2->get();

        $serviceoption = ServiceOption::select('serviceoption.dateProfile','serviceoption.option','serviceoption.status','serviceoption.barangay_id','serviceoption.muncity_id','profile.fname','profile.mname','profile.lname','profile.suffix')
            ->leftJoin('profile','serviceoption.profile_id','=','profile.unique_id')
            ->where('serviceoption.dateProfile','>=',$start)
            ->where('serviceoption.dateProfile','<=',$end)
            ->where('serviceoption.muncity_id',$user->muncity);
        if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',$user->id)->get();
            $serviceoption = $serviceoption->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('serviceoption.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $serviceoption = $serviceoption->where('serviceoption.barangay_id',0);
            }
        }
        $serviceoption = $serviceoption->get();

        return view('report.data',[
            'filename' => $filename,
            'profile' => $profile,
            'profileservices' => $profileservices,
            'profilecases' => $profilecases,
            'status1' => $status1,
            'status2' => $status2,
            'serviceoption' => $serviceoption,
        ]);
    }

    public function downloadLogin()
    {
        return view('report.user');
    }

    public function populationLess()
    {

        $temp = Session::get('profileKeyword');
        $less = Session::get('profileKeywordLess');

        $keyword = $string = preg_replace('/\s+/', '', $temp['keyword']);
        $head = $temp['familyHead'];
        $sex = $temp['sex'];
        $barangay = $temp['barangay'];

        $group1 = $less['group1'];
        $group2 = $less['group2'];
        $group3 = $less['group3'];


        $user = Auth::user();
        $servicegroup = new ServiceGroup();

        $db = 'db_'.date('Y');
        if(isset($temp['year']))
        {
            $db = 'db_'.$temp['year'];
        }

        $servicegroup->setConnection($db);
        $data['profiles'] = $servicegroup->select('profile_id','sex','group1','group2','group3','barangay_id','muncity_id','bracket_id')
            ->where('barangay_id','!=',0);

        if($keyword || $keyword!='' || $keyword!=null){
            $data['profiles'] =  $data['profiles']->where('profile_id','like',"%$keyword%");
        }

        if($sex || $sex!='' || $sex!=null)
        {
            if($sex!=='non')
            {
                $data['profiles'] = $data['profiles']->where('sex',$sex);
            }else{
                $data['profiles'] = $data['profiles']->where('sex','');
            }
        }

        if($barangay || $barangay!='' || $barangay!=null)
        {
            $data['profiles'] = $data['profiles']->where('barangay_id',$barangay);
        }

        if($user->user_priv == 0 || $user->user_priv == 4){
            $data['profiles'] = $data['profiles']->where('muncity_id',$user->muncity);
        }

        if($group1 || $group1!=0 || $group1!=null)
        {
            $g1 = ($group1==1) ? 1 : 0;
            $data['profiles'] = $data['profiles']->where('group1',$g1);
        }

        if($group2 || $group2!=0 || $group2!=null)
        {
            $g2 = ($group2==1) ? 1 : 0;
            $data['profiles'] = $data['profiles']->where('group2',$g2);
        }

        if($group3 || $group3!=0 || $group3!=null)
        {
            $g3 = ($group3==1) ? 1 : 0;
            $data['profiles'] = $data['profiles']->where('group3',$g3);
        }

        if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $data['profiles'] = $data['profiles']->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $data['profiles'] = $data['profiles']->where('barangay_id',0);
            }
        }
        $data['profiles'] = $data['profiles']->orderBy('profile_id','asc')
            ->paginate(20);

        return view('client.populationless',[
            'profiles' => $data['profiles']
        ]);

    }

    public function searchPopulationLess(Request $req){
        if($req->viewAll){
            Session::forget('profileKeyword');
            return redirect()->back();
        }
        $data = array(
            'keyword' => $req->keyword,
            'familyHead' => $req->familyHead,
            'sex' => $req->sex,
            'barangay' => $req->barangay,
            'year' => $req->year
        );
        $less = array(
            'group1' => $req->group1,
            'group2' => $req->group2,
            'group3' => $req->group3
        );
        Session::put('profileKeyword',$data);
        Session::put('profileKeywordLess',$less);
        return self::populationLess();
    }

    public function servicePopulation($id,$year)
    {
        $db = 'db_'.$year;
        $profileservices = new ProfileServices();
        $profileservices->setConnection($db);
        $tmp = htmlentities($id);
        $services = $profileservices->select('profileservices.dateProfile','services.description')
            ->leftJoin('tsekap_main.services','profileservices.service_id','=','services.id')
            ->where('profileservices.profile_id',$tmp)
            ->get();
        $data = array();
        foreach($services as $s)
        {
            $data[] = array(
                'dateProfile' => date('M d, Y',strtotime($s->dateProfile)),
                'description' => $s->description
            );
        }
        return $data;
    }

    public function servicePopulationLess($profileID)
    {
        $id = Profile::where('unique_id',$profileID)->first()->id;
        return redirect('user/services/'.$id);
    }

    public function uploadReport(Request $req)
    {
        $file = $_FILES['file']['name'];
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if($ext=='DOH7'){
            $file = fopen($_FILES['file']['tmp_name'],"r");
            $data = array();
            while(! feof($file))
            {
                $data[] = fgetcsv($file);
            }
            fclose($file);

            $addProfile = 0;
            $addService = 0;
            $addCase = 0;
            $addStatus = 0;
            $addServiceOption = 0;

            foreach($data as $row){
                if($row[0]=='PROFILE')
                {
                    $addProfile++;
                    continue;
                }else if($row[0]=='SERVICES'){
                    $addProfile = 0;
                    $addService++;
                    continue;
                }else if($row[0]=='CASES'){
                    $addService = 0;
                    $addCase++;
                    continue;
                }else if($row[0]=='STATUS'){
                    $addCase = 0;
                    $addStatus++;
                    continue;
                }else if($row[0]=='SERVICE OPTION'){
                    $addStatus = 0;
                    $addServiceOption++;
                    continue;
                }

                if($row[0]=='FAMILY ID' && $addProfile==1){
                    $addProfile++;
                    continue;
                }else if($row[0]=='DATE CREATED' && $addService==1){
                    $addService++;
                    continue;
                }else if($row[0]=='DATE CREATED' && $addStatus==1){
                    $addStatus++;
                    continue;
                }else if($row[0]=='DATE CREATED' && $addCase==1){
                    $addCase++;
                    continue;
                }else if($row[0]=='DATE CREATED' && $addServiceOption==1){
                    $addServiceOption++;
                    continue;
                }

                $dateNow = date('Y-m-d H:i:s');
                if($addProfile==2 && $row[0]!=null){
                    $fname = html_entity_decode(htmlentities($row[3]));
                    $mname = html_entity_decode(htmlentities($row[4]));
                    $lname = html_entity_decode(htmlentities($row[5]));

                    $unique_id = $fname.''.$mname.''.$lname.''.$row[6].''.$row[9].''.$row[10];
                    $q = "INSERT INTO profile(unique_id, familyID, head, relation, fname,mname,lname,suffix,dob,sex,barangay_id,muncity_id,province_id,created_at,updated_at)
                        VALUES('$unique_id', '$row[0]','$row[1]', '$row[2]', '".$fname."',
                        '".$mname."','".$lname."','$row[6]','".date('Y-m-d',strtotime($row[7]))."','$row[8]',
                        '$row[9]','$row[10]','$row[11]','$dateNow','$dateNow')
                        ON DUPLICATE KEY UPDATE
                            familyID = '$row[0]',
                            sex = '$row[8]',
                            relation = '$row[2]',
                            head = '$row[1]'
                    ";

                    DB::select($q);

                    $q = "INSERT IGNORE servicegroup(profile_id) VALUES('$unique_id')";
                    DB::select($q);
                }

                if($addService==2 && $row[0]!=null){
                    $fname = html_entity_decode(htmlentities($row[1]));
                    $mname = html_entity_decode(htmlentities($row[2]));
                    $lname = html_entity_decode(htmlentities($row[3]));
                    $profile_id = $fname.''.$mname.''.$lname.''.$row[4].''.$row[7].''.$row[8];
                    $gender = Profile::where('unique_id',$profile_id)->first();
                    if($gender){
                        $gender = $gender->sex;
                    }else{
                        $gender = null;
                    }
                    $unique_id = date('mdY',strtotime($row[0])).''.$profile_id.''.$row[6].''.$row[5];
                    $q = "INSERT IGNORE profileservices(unique_id, dateProfile, profile_id,sex, service_id, bracket_id, barangay_id, muncity_id,created_at,updated_at)
                            VALUES('$unique_id','$row[0]', '$profile_id', '$gender', '$row[5]', '$row[6]', '$row[7]', '$row[8]','$dateNow','$dateNow')
                        ";
                    DB::select($q);
                    $group = Param::checkGroup($row[5]);
                    Param::saveServiceGroup($profile_id,$gender,$group,$row[7],$row[8],$row[6]);

                }

                if($addCase==2 && $row[0]!=null){
                    $fname = html_entity_decode(htmlentities($row[1]));
                    $mname = html_entity_decode(htmlentities($row[2]));
                    $lname = html_entity_decode(htmlentities($row[3]));
                    $profile_id = $fname.''.$mname.''.$lname.''.$row[4].''.$row[7].''.$row[8];
                    $unique_id = date('mdY',strtotime($row[0])).''.$profile_id.''.$row[6].''.$row[5];
                    $q = "INSERT IGNORE profilecases(unique_id, dateProfile, profile_id, case_id, bracket_id, barangay_id, muncity_id,created_at,updated_at)
                            VALUES('$unique_id', '$row[0]', '$profile_id', '$row[5]', '$row[6]', '$row[7]', '$row[8]','$dateNow','$dateNow')
                        ";
                    DB::select($q);
                }

                if($addStatus==2 && $row[0]!=null){
                    $fname = html_entity_decode(htmlentities($row[1]));
                    $mname = html_entity_decode(htmlentities($row[2]));
                    $lname = html_entity_decode(htmlentities($row[3]));
                    $profile_id = $fname.''.$mname.''.$lname.''.$row[4].''.$row[7].''.$row[8];

                    ProfileServices::where('dateProfile',$row[0])
                        ->where('profile_id',$profile_id)
                        ->orderBy('id','desc')
                        ->update(
                            array(
                                'status' => $row[5]
                            )
                        );
                    ProfileCases::where('profile_id',$profile_id)
                        ->orderBy('id','desc')
                        ->update(
                            array(
                                'status' => $row[5]
                            )
                        );
                }

                if($addServiceOption==2 && $row[0]!=null){
                    $fname = html_entity_decode(htmlentities($row[1]));
                    $mname = html_entity_decode(htmlentities($row[2]));
                    $lname = html_entity_decode(htmlentities($row[3]));
                    $profile_id = $fname.''.$mname.''.$lname.''.$row[4].''.$row[7].''.$row[8];
                    $unique_id = date('mdY',strtotime($row[0])).''.$profile_id.''.$row[5].''.$row[6];
                    $q = "INSERT IGNORE serviceoption(unique_id, dateProfile, profile_id, serviceoption.option, serviceoption.status, barangay_id, muncity_id,created_at,updated_at)
                            VALUES('$unique_id', '$row[0]', '$profile_id', '$row[5]', '$row[6]', '$row[7]', '$row[8]','$dateNow','$dateNow')
                        ";
                    DB::select($q);
                }
            }
        }else{
            echo 'invalid';
        }
        return redirect()->back()->with('status','uploaded');
    }

    public function getFamilyID($row){
        $data = array(
            'muncity_id' => $row[10],
            'description' => $row[0]
        );
        $check = FamilyProfile::where($data)->first();
        if(!$check){
            $q = new FamilyProfile();
            $q->muncity_id = $row[10];
            $q->description = $row[0];
            $q->save();
        }
        $id = FamilyProfile::where($data)->first()->id;
        return $id;
    }

    public function getProfileID($row)
    {
        $data = array(
            'fname' => $row[1],
            'mname' => $row[2],
            'lname' => $row[3],
            'suffix' => $row[4],
            'barangay_id' => $row[7],
            'muncity_id' => $row[8],
        );
        $id = Profile::where($data)->first()->id;
        return $id;
    }

    public function getPrefix($id){
        $p = Profile::find($id);
        return $p->fname.''.$p->mname.''.$p->lname.''.$p->suffix.''.$p->barangay_id.''.$p->muncity_id;
    }

    public function statusReport()
    {
        $priv = Auth::user()->user_priv;
        if($priv!=0 && $priv!=2){
            return redirect('/');
        }
        return view('client.status');
    }

    public function updategender($gender,$id)
    {
        $data = array(
            'sex' => $gender
        );
        Profile::where('id',$id)
            ->update($data);
        return redirect()->back();
    }


    public function health()
    {
        return view('report.health');
    }

    public function healthData()
    {
        $data['unmet'] = array(
            self::queryProfile('unmet',1),
            self::queryProfile('unmet',2),
            self::queryProfile('unmet',3)
        );

        $data['water'] = array(
            self::queryProfile('water',1),
            self::queryProfile('water',2),
            self::queryProfile('water',3)
        );

        $data['toilet'] = array(
            self::queryProfile('toilet','non'),
            self::queryProfile('toilet','comm'),
            self::queryProfile('toilet','indi')
        );

        $data['income'] = array(
            self::queryProfile('income',1),
            self::queryProfile('income',2),
            self::queryProfile('income',3),
            self::queryProfile('income',4),
            self::queryProfile('income',5),
            self::queryProfile('income',6),
            self::queryProfile('income',7)
        );
        return $data;

    }

    public function queryProfile($col,$value)
    {
        $user = Auth::user();
        $data = Profile::select('id')
            ->where('barangay_id','!=',0)
            ->where('head','YES');

        if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $data = $data->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $data = $data->where('profile.barangay_id',0);
            }
        }else if($user->user_priv == 0){
            $data = $data->where('profile.muncity_id',$user->muncity);
        }
        if($col=='unmet')
        {
            $data = $data->where('sex','Female');
        }
        $data = $data->where($col,$value)->count();
        return $data;
    }


    public function verifyProfile(Request $req)
    {
        $user = Auth::user();

        $profile = Profile::select('unique_id','fname','mname','lname','dob','id');

        if($req->fname){
            $profile = $profile->where('fname','like',"%$req->fname%");
        }
        if($req->mname){
            $profile = $profile->where('mname','like',"%$req->mname%");
        }
        if($req->lname){
            $profile = $profile->where('lname','like',"%$req->lname%");
        }
        if($req->dob){
            $profile = $profile->where('dob',"$req->dob%");
        }


        if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',$user->id)->get();
            $profile = $profile->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('barangay_id',$tmp->barangay_id);
                }
            });
        }else if($user->user_priv == 0){
            $profile = $profile->where('muncity_id',$user->muncity);
        }
        $profile = $profile->orderBy('lname','asc')
                ->limit(20)
                ->get();
        return $profile;
    }

    public function calculateAge($dob)
    {
        $age = ParameterCtrl::getAge($dob);
        return $age;
    }

    public function profilePending(){
        $userid = Auth::user()->id;
        $tmpBrgy = UserBrgy::where('user_id',$userid)->get();

        $profile_pending = ProfilePending::where(function($q) use ($tmpBrgy){
            if(count($tmpBrgy) > 0){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('barangay_id',$tmp->barangay_id);
                }
            } else {
                $q->where('barangay_id','=','no_barangay');
            }

        })->paginate(10);

        return view('client.profile_pending',[
            "profile_pending" => $profile_pending
        ]);
    }

}
