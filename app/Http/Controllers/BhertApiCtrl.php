<?php
namespace App\Http\Controllers;
use App\BhertPatient;
use App\ProfilePending;
use App\UserBrgy;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BhertApiCtrl extends Controller{
    public function login($username,$password){   //this is where the refer login controller
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

    public function getProfileSitio($userid,$sitio_id,$offset,$limit)
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
                    'profile.sitio_id',
                    'profile.purok_id',
                    'profile.barangay_id',
                    'profile.muncity_id',
                    'profile.province_id',
                    'bhert_patient.date_of_arrival',
                    'bhert_patient.end_of_quarantine',
                    'bhert_patient.patient_code',
                    'bhert_patient.nationality',
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
                ->where('profile.sitio_id',$sitio_id)
                ->leftJoin('bhert_patient','bhert_patient.profile_id','=','profile.id')
                ->orderBy('profile.lname','asc')
                ->skip($offset)
                ->take($limit)
                ->get();

        return $data;
    }

    public function getProfilePurok($userid,$purok_id,$offset,$limit)
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
            'profile.sitio_id',
            'profile.purok_id',
            'profile.barangay_id',
            'profile.muncity_id',
            'profile.province_id',
            'bhert_patient.date_of_arrival',
            'bhert_patient.end_of_quarantine',
            'bhert_patient.patient_code',
            'bhert_patient.nationality',
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
            ->where('profile.purok_id',$purok_id)
            ->leftJoin('bhert_patient','bhert_patient.profile_id','=','profile.id')
            ->orderBy('profile.lname','asc')
            ->skip($offset)
            ->take($limit)
            ->get();

        return $data;
    }


    public function countProfile($userid){
        $tmpBrgy = UserBrgy::where('user_id',$userid)->get();
        $profile_count = Profile::where(function($q) use ($tmpBrgy){
                            foreach($tmpBrgy as $tmp){
                                $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                            }
                        })
                        ->count();

        return $profile_count;
    }

    public function savePopulation(Request $req)
    {
        $user = User::find($req->userid);
        $fname = $req->fname;
        $mname = $req->mname;
        $lname = $req->lname;
        $unique_id = $fname.''.$mname.''.$lname.''.$req->suffix.''.$req->barangay.''.$user->muncity;

        $profile = new Profile();
        $profile->unique_id = $unique_id;
        $profile->familyID = $req->familyID;
        $profile->phicID = $req->phicID;
        $profile->nhtsID = $req->nhtsID;
        $profile->head = 'NO';
        $profile->relation = $req->relation;
        $profile->fname = $fname;
        $profile->mname = $mname;
        $profile->lname = $lname;
        $profile->suffix = $req->suffix;
        $profile->dob = date('Y-m-d',strtotime($req->dob));
        $profile->sex = $req->sex;
        $profile->sitio_id = $req->sitio_id;
        $profile->purok_id = $req->purok_id;
        $profile->barangay_id = $req->barangay_id;
        $profile->muncity_id = $req->muncity_id;
        $profile->province_id = $req->province_id;
        $profile->save();

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

    public function saveHeadProfile(Request $req)
    {
        $user = User::find($req->userid);
        $fname = $req->fname;
        $mname = $req->mname;
        $lname = $req->lname;

        //family ID
        $ctrlNo = date('His');
        $ctrlNo = str_pad($ctrlNo, 4, '0', STR_PAD_LEFT);
        $idNo = str_pad($user->id, 4, '0', STR_PAD_LEFT);
        //$family_id = date('mdy').'-'.$idNo.'-'.$ctrlNo;
        //end familyID
        $unique_id = $fname.''.$mname.''.$lname.''.$req->suffix.''.$req->barangay.''.$user->muncity.$ctrlNo;

        $profile = new Profile();
        $profile->unique_id = $unique_id;
        $profile->familyID = $req->familyID;
        $profile->phicID = $req->phicID;
        $profile->nhtsID = $req->nhtsID;
        $profile->head = 'YES';
        $profile->relation = 'HEAD';
        $profile->fname = $fname;
        $profile->mname = $mname;
        $profile->lname = $lname;
        $profile->suffix = $req->suffix;
        $profile->dob = date('Y-m-d',strtotime($req->dob));
        $profile->sex = $req->sex;
        $profile->sitio_id = $req->sitio_id;
        $profile->purok_id = $req->purok_id;
        $profile->barangay_id = $req->barangay_id;
        $profile->muncity_id = $req->muncity_id;
        $profile->province_id = $req->province_id;
        $profile->save();

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
        header('Access-Control-Allow-Origin: *');
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
            $message = 'The profile was exist'; //The profile is exist
            $profile_id = $check_profile->id;
            $profile_pending = new ProfilePending();
            $profile_pending->id = $check_profile->id;
            $profile_pending->familyID = $request->familyID;
            $profile_pending->phicID = $request->phicID;
            $profile_pending->nhtsID = $request->nhtsID;
            $profile_pending->relation = $request->relation;
            $profile_pending->fname = $request->fname;
            $profile_pending->mname = $request->mname;
            $profile_pending->lname = $request->lname;
            $profile_pending->dob = $request->dob;
            $profile_pending->sex = $request->sex;
            $profile_pending->sitio_id = $request->sitio_id;
            $profile_pending->purok_id = $request->purok_id;
            $profile_pending->barangay_id = $request->barangay_id;
            $profile_pending->muncity_id = $request->muncity_id;
            $profile_pending->province_id = $request->province_id;
            $profile_pending->encoded_by = $request->userid;
            $profile_pending->save();
        } else{
            if($request->head == 'YES'){
                $message = 'Success(Head)';
                $profile_id = $this->saveHeadProfile($request); //return profile id
            }
            else{
                $message = 'Success';
                $profile_id = $this->savePopulation($request); // return profile id
            }
        }

        BhertPatient::updateOrCreate(
            ['profile_id'=>$profile_id],
            [
                "encoded_by" => $request->userid,
                "date_of_arrival" => $request->date_of_arrival,
                "end_of_quarantine" => $request->end_of_quarantine,
                "patient_code" => $request->patient_code,
                "nationality" => $request->nationality,
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