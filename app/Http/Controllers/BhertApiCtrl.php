<?php
namespace App\Http\Controllers;
use App\BhertPatient;
use App\UserBrgy;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Profile;
use Illuminate\Http\Request;

class BhertApiCtrl extends Controller{
    public function login($username,$password){
        $user = $username;
        $pass = $password;

        $user = User::where('username',$user)->first();
        if(count($user))
        {
            if(Hash::check($pass,$user->password))
            {
                $count = 0;
                $userBrgy = UserBrgy::select('userbrgy.barangay_id','barangay.description','barangay.target')
                    ->where('user_id',$user->id)
                    ->leftJoin('barangay','userbrgy.barangay_id','=','barangay.id')
                    ->get();
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
                'status' => 'no_record'
            );
        }
    }

    public function getProfiles($userid,$offset,$limit)
    {

        $tmpBrgy = UserBrgy::where('user_id',$userid)->get();


        if(count($tmpBrgy) <= 0){
            return 'no data';
        }

        $data = Profile::
                select(
                    'profile.id',
                    'profile.familyID',
                    'profile.phicID',
                    'profile.nhtsID',
                    'profile.head',
                    'profile.relation',
                    'profile.fname',
                    'profile.mname',
                    'profile.lname',
                    'profile.suffix',
                    'profile.dob',
                    'profile.sex',
                    'profile.barangay_id',
                    'profile.muncity_id',
                    'profile.province_id',
                    'profile.income',
                    'profile.unmet',
                    'profile.water',
                    'profile.toilet',
                    'profile.education',
                    'profile.hypertension',
                    'profile.diabetic',
                    'profile.pwd',
                    'profile.pregnant',
                    'bhert_patient.date_of_arrival',
                    'bhert_patient.end_of_quarantine',
                    'bhert_patient.patient_code',
                    'bhert_patient.nationality',
                    'bhert_patient.purok',
                    'bhert_patient.sitio',
                    'bhert_patient.contact_no',
                    'bhert_patient.travel_history',
                    'bhert_patient.passport_number',
                    'bhert_patient.flight_number',
                    'bhert_patient.type_quarantine',
                    'bhert_patient.sign_symptoms',
                    'bhert_patient.remarks',
                    'bhert_patient.latitude',
                    'bhert_patient.longitude',
                    'bhert_patient.start_time',
                    'bhert_patient.completion_time',
                    'bhert_patient.email',
                    'bhert_patient.icd_10',
                    'bhert_patient.admitted',
                    'bhert_patient.date_admission',
                    'bhert_patient.date_onset',
                    'bhert_patient.name_coordinator',
                    'bhert_patient.dsc_contact_number',
                    'bhert_patient.cat1',
                    'bhert_patient.cat_date',
                    'bhert_patient.admitting_diagnosis',
                    'bhert_patient.with_fever',
                    'bhert_patient.with_colds',
                    'bhert_patient.with_cough',
                    'bhert_patient.with_sore_throat',
                    'bhert_patient.with_diarrhea',
                    'bhert_patient.with_difficult_breathing',
                    'bhert_patient.parent_name',
                    'bhert_patient.number_person_living',
                    'bhert_patient.outcome_date_died'
                )
                ->where(function($q) use ($tmpBrgy){
                    foreach($tmpBrgy as $tmp){
                        $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                    }
                })
                ->leftJoin('bhert_patient','bhert_patient.profile_id','=','profile.id')
                ->orderBy('profile.lname','asc')
                ->skip($offset)
                ->take($limit)
                ->get();

        return $data;
    }

    public function savePopulation(Request $req)
    {
        $con=mysqli_connect("localhost","root","","tsekap_main");
        $dateNow = date('Y-m-d H:i:s');
        $user = User::find($req->userid);
        $fname = mysqli_real_escape_string($con,($req->fname));
        $mname = mysqli_real_escape_string($con,($req->mname));
        $lname = mysqli_real_escape_string($con,($req->lname));
        $unique_id = $fname.''.$mname.''.$lname.''.$req->suffix.''.$req->barangay.''.$user->muncity;
        $unique_id = mysqli_real_escape_string($con,$unique_id);

        $q = "INSERT INTO profile(unique_id, familyID, head, relation, fname,mname,lname,suffix,dob,sex,unmet,barangay_id,muncity_id,province_id, created_at, updated_at, phicID, nhtsID, education,hypertension,diabetic,pwd,pregnant)
                VALUES('$unique_id', '$req->familyID', 'NO', '$req->relation', '".$fname."',
                '".$mname."','".$lname."','$req->suffix','".date('Y-m-d',strtotime($req->dob))."','$req->sex','$req->unmet',
                '$req->barangay','$user->muncity','$user->province','$dateNow','$dateNow','$req->phicID','$req->nhtsID','$req->education','$req->hypertension','$req->diabetic','$req->pwd','$req->pregnant')
            ON DUPLICATE KEY UPDATE
                familyID = '$req->familyID',
                sex = '$req->sex',
                relation = '$req->relation',
                education = '$req->education',
                unmet = '$req->unmet'
            ";
        DB::select($q);

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

    public function saveHeadProfile(Request $req)
    {
        $con=mysqli_connect("localhost","root","","tsekap_main");
        $dateNow = date('Y-m-d H:i:s');
        $user = User::find($req->userid);
        $fname = mysqli_real_escape_string($con,($req->fname));
        $mname = mysqli_real_escape_string($con,($req->mname));
        $lname = mysqli_real_escape_string($con,($req->lname));
        $unique_id = $fname.''.$mname.''.$lname.''.$req->suffix.''.$req->barangay.''.$user->muncity;
        $unique_id = mysqli_real_escape_string($con,$unique_id);

        //family ID
        $ctrlNo = date('His');
        $ctrlNo = str_pad($ctrlNo, 4, '0', STR_PAD_LEFT);
        $idNo = str_pad($user->id, 4, '0', STR_PAD_LEFT);
        $family_id = date('mdy').'-'.$idNo.'-'.$ctrlNo;
        //end familyID

        $q = "INSERT IGNORE profile(unique_id, familyID, head, relation, fname,mname,lname,suffix,dob,sex,barangay_id,muncity_id,province_id,created_at,updated_at,phicID, nhtsID, income, unmet, water, toilet, education,hypertension,diabetic,pwd,pregnant)
                VALUES('$unique_id', '$family_id', 'YES', 'Head', '".$fname."',
                '".$mname."','".$lname."','$req->suffix','".date('Y-m-d',strtotime($req->dob))."','$req->sex',
                '$req->barangay','$user->muncity','$user->province','$dateNow','$dateNow','$req->phicID', '$req->nhtsID', '$req->income', '$req->unmet', '$req->water', '$req->toilet', '$req->education', '$req->hypertension', '$req->diabetic', '$req->pwd', '$req->pregnant')
            ";
        //echo $q;
        DB::select($q);

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
    }

    public function insertBhert(Request $request){
        return $request->all();
        $check_profile = Profile::where('id','=',$request->profile_id)
                                ->orWhere(function($q) use ($request){
                                    $q->where('fname','=',$request->fname);
                                    $q->where('lname','=',$request->lname);
                                    $q->where('dob','=',$request->dob);
                                    $q->where('sex','=',$request->sex);
                                    $q->where('barangay_id','=',$request->barangay_id); // no need muncity_id and province_id kay barangay unique na ang id, and naa napud ang muncity_id and province_id
                                })
                                ->first();
        if($check_profile){
            $message = $check_profile; //The profile is exist
        } else{
            if($request->head == 'YES'){
                //$this->saveHeadProfile($request);
                $message = 'Successfully save the patient(Head)';
            }
            else{
                //$this->savePopulation($request);
                $message = 'Successfully save the patient';
            }
        }

        BhertPatient::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "date_of_arrival" => $request->date_of_arrival,
                "end_of_quarantine" => $request->end_of_quarantine,
                "patient_code" => $request->patient_code,
                "nationality" => $request->nationality,
                "purok" => $request->purok,
                "sitio" => $request->sitio,
                "contact_no" => $request->contact_no,
                "travel_history" => $request->travel_history,
                "passport_number" => $request->passport_number,
                "flight_number" => $request->flight_number,
                "type_quarantine" => $request->type_quarantine,
                "sign_symptoms" => $request->sign_symptoms,
                "remarks" => $request->remarks,
                "latitude" => $request->latitude,
                "longitude" => $request->longitude,
                "start_time" => $request->start_time,
                "completion_time" => $request->completion_time,
                "email" => $request->email,
                "icd_10" => $request->icd_10,
                "admitted" => $request->admitted,
                "date_admission" => $request->date_admission,
                "date_onset" => $request->date_onset,
                "name_coordinator" => $request->name_coordinator,
                "dsc_contact_number" => $request->dsc_contact_number,
                "cat1" => $request->cat1,
                "cat_date" => $request->cat_date,
                "admitting_diagnosis" => $request->admitting_diagnosis,
                "with_fever" => $request->with_fever,
                "with_colds" => $request->with_colds,
                "with_cough" => $request->with_cough,
                "with_sore_throat" => $request->with_sore_throat,
                "with_diarrhea" => $request->with_diarrhea,
                "with_difficult_breathing" => $request->with_difficult_breathing,
                "parent_name" => $request->parent_name,
                "number_person_living" => $request->number_person_living,
                "outcome_date_died" => $request->outcome_date_died
            ]
        );

        return $message;

    }

}

?>