<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facility;
use App\Barangay;
use App\Muncity;
use App\Province;
use App\ResuReportFacility;
use App\Profile;
use App\ResuPreadmission;
use App\ResuNature_Preadmission;
use App\Resunature_injury_bodyparts;
use App\Resuexternal_injury_preAdmission;


class PatientInjuryController extends Controller
{
    //
    public function PatientInjured(){
        $user = Auth::user();

        return view('resu.manage_patient_injury.list_patient', [
            'user_priv' => $user
        ]);
    }

    public function PatientForm(){

        $facility = Facility::all();
        $province = Province::all();
        $barangay = Barangay::all();
     
        return view('resu.manage_patient_injury.patient_form',[
            'facility' => $facility,
            'province' => $province,
            'muncity' => $muncity,
            'barangay' => $barangay
        ]);
    }

    public function getMunicipal($provinceid){

      $muncity = Muncity::where('province_id', $provinceid)->get();
      
      return response()->json($muncity);
    }

    public function getBarangay($muncity_id){
        $barangay = Barangay::where('muncity_id',$muncity_id)->get();
        return response()->json($barangay);
    }

    public function SubmitPatientInjury(Request $request){
        $user = Auth::user();
        // $facility = new ResuReportFacility();

        // $facility->reportfacility = $request->facilityname;
        // $facility->typeOfdru = $request->typedru;
        // $facility->Addressfacility = $request->addressfacility;
        // $facility->typeofpatient = $request->typePatient;
        // $facility->save();

        // $profile = new Profile();
        // $unique_id = $request->fname.''.$request->mname.''.$request->lname.''.$request->suffix.''.$request->barangay.''.$user->muncity;
        // $profile->unique_id = $unique_id;
        // $profile->Hospital_caseno = $request->hospital_no;
        // $profile->report_facilityId = $facility->id;
        // $profile->fname = $request->fname;
        // $profile->mname = $request->mname;
        // $profile->lname = $request->lname;
        // $profile->sex = $request->sex;
        // $profile->dob = $request->dateBirth;
        // $profile->province_id = $request->province;
        // $profile->muncity_id = $request->municipal;
        // $profile->barangay_id = $request->barangay;
        // $profile->phicID = $request->phil_no;
        // $profile->save();

        // $pre_admission = new ResuPreadmission();
        // $pre_admission->profile_id = $profile->id;
        // $pre_admission->POIProvince_id = $request->provinceInjury;
        // $pre_admission->POImuncity_id = $request->municipal_injury;
        // $pre_admission->POIBarangay_id = $request->barangay_injury;
        // $pre_admission->POIPurok = $request->purok_injury;
        // $pre_admission->dateInjury = $request->date_injury;
        // $pre_admission->timeInjury = $request->time_injury;
        // $pre_admission->dateConsult = $request->date_consult;
        // $pre_admission->timeConsult = $request->time_consult;
        // $pre_admission->injury_intent = $request->injury_intent;
        // $pre_admission->first_aid = $request->firstAidGive;
        // $pre_admission->what = $request->druWhat;
        // $pre_admission->bywhom = $request->druByWhom;
        // $pre_admission->multipleInjury = $request->multiple_injured;

        // $pre_admission->save();

        // if($request->InjuredBurn || $request->burnside) {
        //     $nature = new ResuNature_Preadmission();
        //     $nature->Pre_admission_id = 1;
        //     $nature->natureInjury_id = $request->InjuredBurn;
        //     $nature->subtype = $request->Degree; 
        //     $nature->details = $request->burnDetail;
        //     $nature->side = $request->burnside;
        //     $nature->save();

        //     $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id , $request->input('burn_body_parts', []));
        // }
    
        // if($request->fractureNature) {
        //     $nature = new ResuNature_Preadmission();
        //     $nature->Pre_admission_id = 1;
        //     $nature->natureInjury_id = $request->fractureNature;
        //     $nature->subtype = $request->fracttype;
        //     if($request->fracture_open_detail){
        //         $nature->details = $request->fracture_open_detail;
        //         $nature->side = $request->opentype_side;
        //     }else{
        //         $nature->details = $request->fracture_close_detail;
        //         $nature->side = $request->closetype_side;
        //     }
        //     $nature->save();

        //     $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id , $request->input('fractureclose_bodyparts', []));
        //     $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id ,$request->input('fracture_Open_bodyparts', []));
        // }
    
        // if($request->Others_nature_injured) {
        //     $nature = new ResuNature_Preadmission();
        //     $nature->Pre_admission_id = 1;
        //     $nature->natureInjury_id = $request->Others_nature_injured;
        //     $nature->details = $request->other_nature_datails;
        //     $nature->side = $request->side_others;
        //     $nature->save();

        //     $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id ,$request->input('body_parts_others', []));
        // }

        // $injuredcount = $request->input('injured_count');

        // for($i = 1; $i <= $injuredcount; $i++){
        //     if($request->has('nature' . $i) || $request->has('nature_details' . $i) || $request->has('sideInjured' . $i)){
        //         $nature = new ResuNature_Preadmission();
        //         $nature->Pre_admission_id = 1; // Update this as needed
        //         $nature->natureInjury_id = $request->input('nature' . $i);
        //         $nature->details = $request->input('nature_details' . $i);
        //         $nature->side = $request->input('sideInjured' . $i); // Save side directly here
        //         $nature->save();

        //         $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id ,$request->input('body_parts_injured' . $i, []));
        //     }
        // }

        //save external Injuries
        if($request->ex_burn){
            $external = new Resuexternal_injury_preAdmission();
            $external->Pre_admission_id = 1;
            $external->externalinjury_id = $request->ex_burn;
            $external->subtype = $request->burn_type;
            $external->details = $request->exburnDetails;
            $external->save();
        }
        
        if($request->exDrowning){
            $external = new Resuexternal_injury_preAdmission();
            $external->Pre_admission_id = 1;
            $external->externalinjury_id = $request->exDrowning;
            $external->subtype = $request->drowningType;
            $external->details = $request->exdrowning_Details;
            $external->save();
        }

        if($request->externalTransport){
            $external = new Resuexternal_injury_preAdmission();
            $external->Pre_admission_id = 1;
            $external->externalinjury_id = $request->externalTransport;
            $external->details = $request->transport_details;
            $external->save();
        }

        $external_count = $request->input('external_count');

        for($i = 1; $i <= $external_count; $i++){
            if($request->has('external' . $i) || $request->has('external_details')){
                $external = new Resuexternal_injury_preAdmission();
                $external->Pre_admission_id = 1;
                $external->externalinjury_id = $request->input('external' . $i);
                $external->details = $request->input('external_details' . $i);
                $external->save();
            }
        }
    }   

    //sub sub category bodyparts
    private function SaveBodyParts($natureId,$pre_admiss_id,$bodyParts)
    {
        $bodyPartsData = [];
        foreach($bodyParts as $bodypart){
            $bodyPartsData[] = [
                'preadmission_id' => $pre_admiss_id,
                'nature_injury_id' => $natureId,
                'bodyparts_id' => $bodypart
            ];
        }
        Resunature_injury_bodyparts::insert($bodyPartsData);
    }
}
