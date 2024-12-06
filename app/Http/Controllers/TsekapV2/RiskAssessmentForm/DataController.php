<?php

namespace App\Http\Controllers\TsekapV2\RiskAssessmentForm;

use Illuminate\Http\Request;

use App\Muncity;
use App\Barangay;
use App\RiskProfile;
use App\Facility;
use App\RiskFormAssesment;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DataController extends Controller
{ 
    // function to call once an endpoint is invoked
    public function api(Request $fieldsuest){
        $action = $fieldsuest -> get('r');
        // switch statement as to what is needed to be done
        
        switch($action){
            case 'getMuncity':
                return $this->getMuncity();
            case 'getBarangay':
                return $this->getBarangay();
            case 'getPatientRiskFormList':
                return $this->getPatientRiskFormList();
            case 'createRecord':
                return $this->getVersion($fieldsuest);
            case 'readRecord':
                return $this->getVersion($fieldsuest);
            case 'updateRecord':
                return $this->getVersion($fieldsuest);
            case 'deleteRecord':
                return $this->getVersion($fieldsuest); 
        }
    }

    // # ---------- AUXILIARY FUNCTIONS ----------- # //
    
    // get municipality/city
    public function getMuncity(){
        $provinceId = Input::get('province_id');

        $muncity = Muncity::where('province_id', $provinceId)
            ->select('id','province_id','description')
            ->get();

        return response()->json($muncity);
    }

    // get barangay
    public function getBarangay(){
        $muncityId = Input::get('muncity_id');

        $barangay = Barangay::where('muncity_id',$muncityId)
            ->select('id','muncity_id','description')
            ->get();
        return response()->json($barangay);
    }

    // get patient risk form list
    public function getPatientRiskFormList() {
        $user = Input::get('user');
        $keyword = Input::get('keyword');

        if(!$user){
            return response()->json(['error' => 'No user is logged in.'], 401);
        }

        $query = RiskProfile::select('id', 'fname', 'mname', 'lname', 'dob', 'sex', 'civil_status', 'barangay_id', 'municipal_id', 'province_id', 'facility_id_updated', 'created_at')
            ->with([
                'facility' => function($query){
                    $query->select('id', 'name');
                },
                'province' => function($query){
                    $query->select('id', 'description');
                },
                'muncity' => function($query){
                    $query->select('id', 'province_id', 'description');
                },
                'barangay' => function($query){
                    $query->select('id', 'muncity_id', 'description');
                },
            ])
            ->orderby('id', 'desc');
        
        // depending on the priviledge level of the user
        switch($user->user_priv){
            // provincial view
            case 3:
                if (!empty($keyword)) { // Search functionality
                $query->where('province_id', $user->province)
                    ->where(function ($q) use ($keyword) {
                        $q->where('fname', 'like', "%$keyword%")
                            ->orWhere('lname', 'like', "%$keyword%")
                            ->orWhereHas('muncity', function ($q) use ($keyword) {
                                $q->where('description', 'like', "%$keyword%");
                            });
                    });
                }
                $query->where('province_id', $user->province);
            break;

            // facility view
            case 6:
                if (!empty($keyword)) { // Search functionality
                $query->where('facility_id_updated', $user->facility_id)
                    ->where(function ($q) use ($keyword) {
                        $q->where('fname', 'like', "%$keyword%")
                            ->orWhere('lname', 'like', "%$keyword%")
                            ->orWhereHas('province', function ($q) use ($keyword) {
                                $q->where('description', 'like', "%$keyword%");
                            })
                            ->orWhereHas('muncity', function ($q) use ($keyword) {
                                $q->where('description', 'like', "%$keyword%");
                            });
                    });
                }
                $query->where('facility_id_updated', $user->facility_id);
            break;
            
            // region view
            case 7:
                if (!empty($keyword)) { // Search functionality
                $query->where(function ($q) use ($keyword) {
                    $q->where('fname', 'like', "%$keyword%")
                        ->orWhere('lname', 'like', "%$keyword%")
                        ->orWhereHas('province', function ($q) use ($keyword) {
                            $q->where('description', 'like', "%$keyword%");
                        })
                        ->orWhereHas('muncity', function ($q) use ($keyword) {
                            $q->where('description', 'like', "%$keyword%");
                        });
                    });
                }
            break;
        }

        $riskprofiles = $query->simplePaginate(15);
        return response()->json($riskprofiles, 200);
    }

    public function submitRiskForm(){
        $user = Input::get('user');
        $fields = Input::get('fields'); 
        $facility = Facility::select('id','name','address','hospital_type')
        ->where('id', $user->facility_id)    
        ->get();

        // Check for duplicate in the RiskProfile table
        $existingRiskProfile = RiskProfile::where('fname', '=', $fields->fname)
        ->where('lname', '=', $fields->lname)
        ->where('mname', '=', $fields->mname)
        ->where('dob', '=', $fields->dateofbirth)
        ->first();

        if ($existingRiskProfile) {
        // Redirect with an error message if a duplicate is found
            return redirect()->back()->with('error', 'Duplicate risk profile exists with the same data.');
        }

        $riskprofile = new RiskProfile();

        // Assign all the necessary values
        $riskprofile->profile_id = $fields->profile_id? $fields->profile_id : null;
        $riskprofile->fname = $fields->fname;
        $riskprofile->mname = $fields->mname? $fields->mname : null ;
        $riskprofile->lname = $fields->lname;
        $riskprofile->suffix = $fields->suffix? $fields->suffix : null;
        $riskprofile->sex = $fields->sex;
        $riskprofile->dob = $fields->dateofbirth;
        $riskprofile->age = $fields->age;
        $riskprofile->contact = $fields->contact;
        $riskprofile->province_id = $fields->province_risk;
        $riskprofile->municipal_id = $fields->municipal;
        $riskprofile->barangay_id = $fields->barangay;
        $riskprofile->sitio = $fields->sitio? $fields->sitio : null;
        $riskprofile->street = $fields->street? $fields->street : null;
        $riskprofile->purok = $fields->purok? $fields->purok : null;
        $riskprofile->phic_id = $fields->phic_id? $fields->phic_id : null; // Ensure you use the correct field name here
        $riskprofile->civil_status = $fields->civil_status;
        $riskprofile->religion = $fields->religion;
        $riskprofile->other_religion = $fields->other_religion ? $fields -> other_religion : null;
        $riskprofile->pwd_id = $fields->pwd_id? $fields->pwd_id : null;
        $riskprofile->ethnicity = $fields->ethnicity;
        $riskprofile->other_ethnicity = $fields -> other_ethnicity ? $fields -> other_ethnicity : null;
        $riskprofile->indigenous_person = $fields->indigenous_person;
        $riskprofile->employment_status = $fields->employment_status;
        $riskprofile->facility_id_updated = $fields->facility_id_updated; // Ensure this is not null
    
        // Save the profile
        $riskprofile->save();
        $riskform = new RiskFormAssesment();

        // Health assessment checkbox fields
        $riskform->risk_profile_id = $riskprofile->id;
        $riskform->ar_chestpain = $fields->input('chest_pain', 'No');
        $riskform->ar_diffBreath = $fields->input('difficulty_breathing', 'No');
        $riskform->ar_lossOfConsciousness = $fields->input('loss_of_consciousness', 'No');
        $riskform->ar_slurredSpeech = $fields->input('slurred_speech', 'No');
        $riskform->ar_facialAsymmetry = $fields->input('facial_asymmetry', 'No');
        $riskform->ar_weaknessNumbness = $fields->input('weakness_numbness', 'No');
        $riskform->ar_disoriented = $fields->input('disoriented', 'No');
        $riskform->ar_chestRetraction = $fields->input('chest_retractions', 'No');
        $riskform->ar_seizureConvulsion = $fields->input('seizures', 'No');
        $riskform->ar_actSelfHarmSuicide = $fields->input('self_harm', 'No');
        $riskform->ar_agitatedBehaivior = $fields->input('agitated_behavior', 'No');
        $riskform->ar_eyeInjury = $fields->input('eye_injury', 'No');
        $riskform->ar_severeInjuries = $fields->input('severe_injuries', 'No');
        $riskform->ar_refer_physicianName = $fields->input('physician_name');
        $riskform->ar_refer_reason = $fields->input('reason');
        $riskform->ar_refer_facility = $fields->input('facility');


        //PAST MEDICAL HISTORY 
        $riskform->pmh_hypertension = $fields->input('pm_hypertension', 'No');
        $riskform->pmh_heartDisease = $fields->input('pm_heartDisease', 'No');
        $riskform->pmh_diabetes = $fields->input('pm_diabetes', 'No');
        $riskform->pmh_specify_diabetes = $fields->input('pm_diabetes_details', '');
        $riskform->pmh_cancer = $fields->input('pm_cancer', 'No');
        $riskform->pmh_specify_cancer = $fields->input('pm_cancer_details', '');
        $riskform->pmh_COPD = $fields->input('pm_COPD', 'No');
        $riskform->pmh_asthma = $fields->input('pm_asthma', 'No');
        $riskform->pmh_allergies = $fields->input('pm_allergies', 'No');
        $riskform->pmh_specify_allergies = $fields->input('pm_allergies_details', '');
        $riskform->pmh_MNandSDisorder = $fields->input('pm_mnsad', 'No');
        $riskform->pmh_specify_MNandSDisorder = $fields->input('pm_mnsad_details', '');
        $riskform->pmh_visionProblems = $fields->input('pm_vision', 'No');
        $riskform->pmh_previous_Surgical = $fields->input('pm_psh', 'No');
        $riskform->pmh_specify_previous_Surgical = $fields->input('pm_psh_details', 'No');
        $riskform->pmh_thyroidDisorders = $fields->input('pm_thyroid', 'No');
        $riskform->pmh_kidneyDisorders = $fields->input('pm_kidney', 'No');
        
        //FAMILY HISTORY
        $riskform->fm_hypertension = $fields->input('fm_hypertension','No');
        $riskform->fm_stroke = $fields->input('fm_stroke','No');
        $riskform->fm_heartDisease = $fields->input('fm_heart','No');
        $riskform->fm_diabetesMel = $fields->input('fm_diabetes','No');
        $riskform->fm_asthma = $fields->input('fm_asthma','No');
        $riskform->fm_cancer = $fields->input('fm_cancer','No');
        $riskform->fm_kidneyDisease = $fields->input('fm_kidney','No');
        $riskform->fm_firstDegreRelative = $fields->input('fm_degree','No');
        $riskform->fm_havingTB5years = $fields->input('fm_famtb','No');
        $riskform->fm_MNandSDisorder = $fields->input('fm_mnsad','No');
        $riskform->fm_COPD = $fields->input('fm_cop','No');

        // NCD RISK FACTORS 
        $tobaccoUsed = $fields->input('tobaccoUse', []); 
        $tobaccoUseLimited = array_slice($tobaccoUsed, 0, 2); 
        $riskform->rf_tobbacoUse = implode(', ', $tobaccoUseLimited); 
        $riskform->rf_alcoholIntake = $fields->input('ncd_alcohol', 'No'); 
        $riskform->rf_alcoholBingeDrinker = $fields->input('ncd_alcoholBinge', 'No');
        $riskform->rf_physicalActivity = $fields->input('ncd_physical', 'No'); 
        $riskform->rf_nutritionDietary = $fields->input('ncd_nutrition', 'No'); 
        $riskform->rf_weight = $fields->input('rf_weight', '');
        $riskform->rf_height = $fields->input('rf_height', '');
        $riskform->rf_bodyMass = $fields->input('rf_BMI', '');
        $riskform->rf_waistCircum = $fields->input('rf_waist', '');

        //RISK SCREENING
        // Hypertension/Diabetes/Hypercholestrolemia/Renal Diseases

        $dmSymptoms = $fields->input('dm_symptoms', []);

        $riskform->rs_systolic_t1 = $fields->input('systolic_t1', ' ');
        $riskform->rs_diastolic_t1 = $fields->input('diastolic_t1', ' ');
        $riskform->rs_systolic_t2 = $fields->input('systolic_t2', ' ');
        $riskform->rs_diastolic_t2 = $fields->input('diastolic_t2', ' ');
        $riskform->rs_bloodSugar_fbs = $fields->input('fbs_result', ' ');
        $riskform->rs_bloodSugar_rbs = $fields->input('rbs_result', ' ');
        $riskform->rs_bloodSugar_date_taken = $fields->input('bloodSugar_date_taken', '');
        $riskform->rs_bloodSugar_symptoms = implode(', ', $dmSymptoms);
        $riskform->rs_lipid_cholesterol = $fields->input('lipid_cholesterol', ''); 
        $riskform->rs_lipid_hdl = $fields->input('lipid_hdl', ''); 
        $riskform->rs_lipid_ldl = $fields->input('lipid_ldl', ''); 
        $riskform->rs_lipid_vldl = $fields->input('lipid_vldl', ''); 
        $riskform->rs_lipid_triglyceride = $fields->input('lipid_triglyceride', ''); 
        $riskform->rs_lipid_date_taken = $fields->input('lipid_date_taken', date('Y-m-d'));
        $riskform->rs_urine_protein = $fields->input('uri_protein', '');
        $riskform->rs_urine_protein_date_taken = $fields->input('uri_protein_date_taken', date('Y-m-d'));
        $riskform->rs_urine_ketones = $fields->input('uri_ketones', '');
        $riskform->rs_urine_ketones_date_taken = $fields->input('uri_ketones_date_taken', date('Y-m-d'));
        
        $symptoms = [];

        // Check each checkbox and add the label to the array if selected
        if ($fields->has('symptom_breathlessness')) {
            $symptoms[] = 'Breathlessness';
        }
        if ($fields->has('symptom_sputum_production')) {
            $symptoms[] = 'Sputum (mucous) production';
        }
        if ($fields->has('symptom_chronic_cough')) {
            $symptoms[] = 'Chronic cough';
        }
        if ($fields->has('symptom_chest_tightness')) {
            $symptoms[] = 'Chest tightness';
        }
        if ($fields->has('symptom_wheezing')) {
            $symptoms[] = 'Wheezing';
        }

        // Convert the array into a comma-separated string
        $riskform->rs_Chronic_Respiratory_Disease = implode(', ', $symptoms);  // Store as a string

        // For PEFR checkboxes, similarly store the selected labels as a comma-separated string
        $pefr = [];
        if ($fields->has('pefr_above_20_percent')) {
            $pefr[] = '20% change from baseline (consider Probable Asthma)';
        }
        if ($fields->has('pefr_below_20_percent')) {
            $pefr[] = '20% change from baseline (consider Probable COPD)';
        }

        // Convert the array into a comma-separated string for PEFR
        $riskform->rs_if_yes_any_symptoms = implode(', ', $pefr);  // Store as a string
        // Anti-Hypertensives: Store selected option and any specify text
        $riskform->mngm_med_hypertension = $fields->input('anti_hypertensives');
        $riskform->mngm_med_hypertension_specify = $fields->input('anti_hypertensives_specify');
    
        // Anti-Diabetes: Store selected option and any specify text, and type
        $riskform->mngm_med_diabetes = $fields->input('anti_diabetes');
        $riskform->mngm_med_diabetes_options = $fields->input('anti_diabetes_type');
        $riskform->mngm_med_diabetes_specify = $fields->input('anti_diabetes_specify');
    
        // Follow-up Date
        $riskform->mngm_date_follow_up = $fields->input('follow_up_date');
    
        // Remarks (Text area)
        $riskform->mngm_remarks = $fields->input('remarks');
    
        // Save the data
        $riskform->save();
    }
}
