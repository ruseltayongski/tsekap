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
use App\ResuTransport;
use App\ResuSafetyTransport;
use App\ResuSafety;
use App\ResuInpatient;
use App\ResuErOpdBhsRhu;

class PatientInjuryController extends Controller
{
    //
    public function PatientInjured(){
        $user = Auth::user();

        $profiles = Profile::with(['province', 'muncity', 'barangay'])
            ->whereNotNull('report_facilityId')
            ->orWhereNotNull('Hospital_caseno')
            ->paginate(10);

        return view('resu.manage_patient_injury.list_patient', [
            'user_priv' => $user,
            'profile' => $profiles
        ]);
    }

    public function SublistPatient($profile_id){
        $facility = Facility::all();
        $province = Province::all();
        $barangay = Barangay::all();
        $safety = ResuSafety::all();

        // $profile = Profile::with(['reportfacility', 'preadmission'])->find($profile_id);

        $profile = Profile::with(['reportfacility', 
        'preadmission.natureInjuryPreadmissions.natureInjury'
        
        ])->find($profile_id);
    
        return view('resu.manage_patient_injury.sub_list_patient',[
            'profile' => $profile,
            'facility' => $facility,
            'province' => $province,
            'muncity' => $muncity,
            'barangay' => $barangay,
            'safety' => $safety,
        ]);
    }

    public function PatientForm(){

        $facility = Facility::all();
        $province = Province::all();
        $barangay = Barangay::all();
        $safety = ResuSafety::all();

        return view('resu.manage_patient_injury.patient_form',[
            'facility' => $facility,
            'province' => $province,
            'muncity' => $muncity,
            'barangay' => $barangay,
            'safety' => $safety,
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
        $facility = new ResuReportFacility();

        $facility->reportfacility = $request->facilityname;
        $facility->typeOfdru = $request->typedru;
        $facility->Addressfacility = $request->addressfacility;
        $facility->typeofpatient = $request->typePatient;
        $facility->save();

        $profile = new Profile();
        $unique_id = $request->fname.''.$request->mname.''.$request->lname.''.$request->suffix.''.$request->barangay.''.$user->muncity;
        $profile->unique_id = $unique_id;
        $profile->Hospital_caseno = $request->hospital_no;
        $profile->report_facilityId = $facility->id;
        $profile->fname = $request->fname;
        $profile->mname = $request->mname;
        $profile->lname = $request->lname;
        $profile->sex = $request->sex;
        $profile->dob = $request->dateBirth;
        $profile->province_id = $request->province;
        $profile->muncity_id = $request->municipal;
        $profile->barangay_id = $request->barangay;
        $profile->phicID = $request->phil_no;
        $profile->save();

        $pre_admission = new ResuPreadmission();
        $pre_admission->profile_id = $profile->id;
        $pre_admission->POIProvince_id = $request->provinceInjury;
        $pre_admission->POImuncity_id = $request->municipal_injury;
        $pre_admission->POIBarangay_id = $request->barangay_injury;
        $pre_admission->POIPurok = $request->purok_injury;
        $pre_admission->dateInjury = $request->date_injury;
        $pre_admission->timeInjury = $request->time_injury;
        $pre_admission->dateConsult = $request->date_consult;
        $pre_admission->timeConsult = $request->time_consult;
        $pre_admission->injury_intent = $request->injury_intent;
        $pre_admission->first_aid = $request->firstAidGive;
        $pre_admission->what = $request->druWhat;
        $pre_admission->bywhom = $request->druByWhom;
        $pre_admission->multipleInjury = $request->multiple_injured;

        $pre_admission->save();

        if($request->InjuredBurn || $request->burnside) {
            $nature = new ResuNature_Preadmission();
            $nature->Pre_admission_id = $pre_admission->id;
            $nature->natureInjury_id = $request->InjuredBurn;
            $nature->subtype = $request->Degree; 
            $nature->details = $request->burnDetail;
            $nature->side = $request->burnside;
            $nature->save();

            $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id , $request->input('burn_body_parts', []));
        }
    
        if($request->fractureNature) {
            $nature = new ResuNature_Preadmission();
            $nature->Pre_admission_id = $pre_admission->id;
            $nature->natureInjury_id = $request->fractureNature;
            $nature->subtype = $request->fracttype;
            if($request->fracture_open_detail){
                $nature->details = $request->fracture_open_detail;
                $nature->side = $request->opentype_side;
            }else{
                $nature->details = $request->fracture_close_detail;
                $nature->side = $request->closetype_side;
            }
            $nature->save();

            $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id , $request->input('fractureclose_bodyparts', []));
            $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id ,$request->input('fracture_Open_bodyparts', []));
        }
    
        if($request->Others_nature_injured) {
            $nature = new ResuNature_Preadmission();
            $nature->Pre_admission_id = $pre_admission->id;
            $nature->natureInjury_id = $request->Others_nature_injured;
            $nature->details = $request->other_nature_datails;
            $nature->side = $request->side_others;
            $nature->save();

            $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id ,$request->input('body_parts_others', []));
        }

        $injuredcount = $request->input('injured_count');

        for($i = 1; $i <= $injuredcount; $i++){
            if($request->has('nature' . $i) || $request->has('nature_details' . $i) || $request->has('sideInjured' . $i)){
                $nature = new ResuNature_Preadmission();
                $nature->Pre_admission_id = $pre_admission->id; // Update this as needed
                $nature->natureInjury_id = $request->input('nature' . $i);
                $nature->details = $request->input('nature_details' . $i);
                $nature->side = $request->input('sideInjured' . $i); // Save side directly here
                $nature->save();

                $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id ,$request->input('body_parts_injured' . $i, []));
            }
        }

        //save selected external Injuries
        $this->SelectedExternalSaveInjury($request, $pre_admission->id);
        //-------------------------------------------------------------------------//
        //for Transport form 
            $this->TransportVehicle($request, $pre_admission->id);

        //Hospital/Facility Data
        $hospital_data = $request->hospital_data;
        $hospital_dataSecond = $request->hospital_data_second;
        if($hospital_dataSecond){
            $inpatient = new ResuInpatient();
            $inpatient->hospitalfacility_id = $hospital_dataSecond;
            $inpatient->profile_id = $profile->id;
            $inpatient->complete_Diagnose = $request->final_diagnose;
            $inpatient->Disposition = $request->disposition1;
            if($request->trans_facility_hos_details2){
                $inpatient->details = $request->trans_facility_hos_details2;
            }else{
                $inpatient->details = $request->disposition_others_details;
            }
            $inpatient->outcome = $request->Outcome1;
            $inpatient->icd10Code_nature = $request->icd10_nature1;
            $inpatient->icd10Code_external = $request->icd10_external1;

            $inpatient->save();
        }elseif($hospital_data){
            $erOpd = new ResuErOpdBhsRhu();

            $erOpd->hospitalfacility_id = $hospital_data;
            $erOpd->profile_id = $profile->id;
            $erOpd->transferred_facility = $request->Transferred;
            $erOpd->referred_facility = $request->Referred;
            $erOpd->originating_hospital = $request->name_orig;
            $erOpd->status_facility = $request->reashingFact;
            $erOpd->mode_transport_facility = $request->mode_transport;
            $erOpd->other_details = $request->mode_others_details;
            $erOpd->initial_impression = $request->Initial_Impression;
            $erOpd->icd10Code_nature = $request->icd10_nature;
            $erOpd->icd10Code_external = $request->icd10_external;
            $erOpd->disposition = $request->disposition;
            $erOpd->details = $request->trans_facility_hos_details;
            $erOpd->outcome = $request->outcome;

            $erOpd->save();
        }
        
        else{
            return "Invalid Hosiptal Id";
        }

        return redirect()->route('patientInjury')->with('success', 'Patient Successfully Added');
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

    private function SelectedExternalSaveInjury($request, $pre_admission_id){

        if($request->ex_burn){
            $external = new Resuexternal_injury_preAdmission();
            $external->Pre_admission_id = $pre_admission_id;
            $external->externalinjury_id = $request->ex_burn;
            $external->subtype = $request->burn_type;
            $external->details = $request->exburnDetails;
            $external->save();
        }
        
        if($request->exDrowning){
            $external = new Resuexternal_injury_preAdmission();
            $external->Pre_admission_id = $pre_admission_id;
            $external->externalinjury_id = $request->exDrowning;
            $external->subtype = $request->drowningType;
            $external->details = $request->exdrowning_Details;
            $external->save();
        }

        if($request->externalTransport){
            $external = new Resuexternal_injury_preAdmission();
            $external->Pre_admission_id = $pre_admission_id;
            $external->externalinjury_id = $request->externalTransport;
            $external->details = $request->transport_details;
            $external->save();
        }

        $external_count = $request->input('external_count');

        for($i = 1; $i <= $external_count; $i++){
            if($request->has('external' . $i) || $request->has('external_details')){
                $external = new Resuexternal_injury_preAdmission();
                $external->Pre_admission_id = $pre_admission_id;
                $external->externalinjury_id = $request->input('external' . $i);
                $external->details = $request->input('external_details' . $i);
                $external->save();
            }
        }
    }

    //saving for transport vehicle
    private function TransportVehicle($request, $pre_admission_id){

        $external_injury_pread_id = $request->externalTransport;
        if($external_injury_pread_id){
            $transport = new ResuTransport();
            $transport->Pre_admission_id = $pre_admission_id;
            if($request->transport_accident_id){
                $transport->transport_accident_id = $request->transport_accident_id;
            }else{
                $transport->transport_accident_id = $request->transport_collision_id;
                $transport->other_collision = $request->Othercollision;
                $transport->other_collision_details = $request->other_collision_details;
            }
            $transport->xternal_injury_pread_id = $external_injury_pread_id;

            $transport->PatientVehicle = $request->Patient_vehicle;
            $transport->Pvother_detail = $request->Patient_vehicle_others;

            $transport->positionPatient = $request->position_patient;
            $transport->ppother_detail = $request->position_other_details;

            $transport->pofOccurence = $request->Occurrence;
            $transport->workplace_occurence_specify = $request->workplace_occ_specify;
            $transport->pofOccurence_others = $request->Occurrence_others;
    
            $transport->activity_patient = $request->activity_patient;
            $transport->AP_others = $request->activity_patient_other;

            $transport->risk_factors = $request->risk_factors;
            $transport->rf_others = $request->rf_others;
            $transport->save(); 
            if($request->safeOthers){
                $transport->safety = $request->safeOthers;
                $transport->safety_others = $request->safeothers_details;
            }else{
                $transport->safety = $transport->id;
            }
            $transport->save(); 

            if($request->has('safe')){
                $safet_values = $request->input('safe');
                
                foreach($safet_values as $safety_value){
                    $safety = new ResuSafetyTransport();
                    $safety->Transport_safety_id = $transport->id;
                    $safety->safety_id = $safety_value;
                    $safety->save();
                }
               
            } 
            
      
        }else{
            return "Invalid Transport Id";
        }

    }
}
