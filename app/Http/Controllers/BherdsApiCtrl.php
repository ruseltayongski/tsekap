<?php
namespace App\Http\Controllers;
use App\UserBrgy;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Profile;

class BherdsApiCtrl extends Controller{
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
                    'profile.unique_id',
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
                    'bherds_patient.date_of_arrival',
                    'bherds_patient.end_of_quarantine',
                    'bherds_patient.patient_code',
                    'bherds_patient.nationality',
                    'bherds_patient.purok',
                    'bherds_patient.sitio',
                    'bherds_patient.contact_no',
                    'bherds_patient.travel_history',
                    'bherds_patient.passport_number',
                    'bherds_patient.flight_number',
                    'bherds_patient.type_quarantine',
                    'bherds_patient.sign_symptoms',
                    'bherds_patient.remarks',
                    'bherds_patient.latitude',
                    'bherds_patient.longitude',
                    'bherds_patient.start_time',
                    'bherds_patient.completion_time',
                    'bherds_patient.email',
                    'bherds_patient.icd_10',
                    'bherds_patient.admitted',
                    'bherds_patient.date_admission',
                    'bherds_patient.date_onset',
                    'bherds_patient.name_coordinator',
                    'bherds_patient.dsc_contact_number',
                    'bherds_patient.cat1',
                    'bherds_patient.cat_date',
                    'bherds_patient.admitting_diagnosis',
                    'bherds_patient.with_fever',
                    'bherds_patient.with_colds',
                    'bherds_patient.with_cough',
                    'bherds_patient.with_sore_throat',
                    'bherds_patient.with_diarrhea',
                    'bherds_patient.with_difficult_breathing',
                    'bherds_patient.parent_name',
                    'bherds_patient.number_person_living',
                    'bherds_patient.outcome_date_died'
                )
                ->where(function($q) use ($tmpBrgy){
                    foreach($tmpBrgy as $tmp){
                        $q->orwhere('profile.barangay_id',$tmp->barangay_id);
                    }
                })
                ->leftJoin('bherds_patient','bherds_patient.profile_id','=','profile.id')
                ->orderBy('profile.lname','asc')
                ->skip($offset)
                ->take($limit)
                ->get();

        return $data;
    }

}

?>