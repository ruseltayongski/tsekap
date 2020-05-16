<?php
namespace App\Http\Controllers;
use App\BherdsPatient;
use App\UserBrgy;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Profile;
use App\Http\Requests\Request;

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

    public function insertBhert(Request $request){
        $bhert = new BherdsPatient();
        $bhert->date_of_arrival = $request->date_of_arrival;
        $bhert->end_of_quarantine = $request->end_of_quarantine;
        $bhert->patient_code = $request->patient_code;
        $bhert->nationality = $request->nationality;
        $bhert->purok = $request->purok;
        $bhert->sitio = $request->sitio;
        $bhert->contact_no = $request->contact_no;
        $bhert->travel_history = $request->travel_history;
        $bhert->passport_number = $request->passport_number;
        $bhert->flight_number = $request->flight_number;
        $bhert->type_quarantine = $request->type_quarantine;
        $bhert->sign_symptoms = $request->sign_symptoms;
        $bhert->remarks = $request->remarks;
        $bhert->latitude = $request->latitude;
        $bhert->longitude = $request->longitude;
        $bhert->longitude = $request->start_time;
        $bhert->completion_time = $request->completion_time;
        $bhert->email = $request->email;
        $bhert->icd_10 = $request->icd_10;
        $bhert->admitted = $request->admitted;
        $bhert->date_admission = $request->date_admission;
        $bhert->date_onset = $request->date_onset;
        $bhert->name_coordinator = $request->name_coordinator;
        $bhert->dsc_contact_number = $request->dsc_contact_number;
        $bhert->cat1 = $request->cat1;
        $bhert->cate_date = $request->cat_date;
        $bhert->admitting_diagnosis = $request->admitting_diagnosis;
        $bhert->with_fever = $request->with_fever;
        $bhert->with_colds = $request->with_colds;
        $bhert->with_cough = $request->with_cough;
        $bhert->with_sore_throat = $request->with_sore_throat;
        $bhert->with_diarrhea = $request->with_diarrhea;
        $bhert->with_difficult_breathing = $request->with_difficult_breathing;
        $bhert->parent_name = $request->parent_name;
        $bhert->number_person_living = $request->number_person_living;
        $bhert->outcome_date_died;
        $bhert->save();
    }

}

?>