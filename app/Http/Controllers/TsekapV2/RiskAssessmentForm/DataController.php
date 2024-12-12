<?php

namespace App\Http\Controllers\TsekapV2\RiskAssessmentForm;

use Exception;

use App\Muncity;
use App\Facility;
use App\Province;
use App\Barangay;
use App\RiskProfile;
use App\RiskFormAssesment;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DataController extends Controller
{ 
    // # ---------- AUXILIARY FUNCTIONS ----------- # //
    // get municipality/city
    public function getMuncity(Request $request){
        $provinceId = $request->query('province_id');

        $muncity = Muncity::where('province_id', $provinceId)
            ->select('id','province_id','description')
            ->query();

        return response()->json($muncity);
    }

    // get barangay
    public function getBarangay(Request $request){
        $muncityId = $request->query('muncity_id');

        $barangay = Barangay::where('muncity_id',$muncityId)
            ->select('id','muncity_id','description')
            ->query();
        return response()->json($barangay);
    }
    // get patient risk form list
    
    // # ---------- END OF AUXILIARY FUNCTIONS ----------- # //
    public function getPatientRiskFormList(Request $request) {
        $user = $request->query('user');
        $keyword = $request->query('keyword');

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

    public function sublistRiskPatient(Request $request){
        $user = $request->query('user');
        $fields = $request->query('fields');

        if(!$user){
            return response()->json(['error' => 'No user is logged in.'], 401);
        }

        $id = $fields->id;
        $facility = Facility::select('id','name','address','hospital_type')->query();

        $selectedMuncity = Muncity::select('id','description')->query();
        $province = Province::select('id','description')->query();

        $provinceSelectedMun = $province->merge($selectedMuncity);

        $profile = RiskProfile::select('id', 'fname', 'mname', 'lname', 'dob', 'suffix', 'sex',  'age',
                                        'civil_status','religion','other_religion','contact','municipal_id', 'province_id', 
                                         'barangay_id','street','purok','sitio','phic_id', 'pwd_id','ethnicity','other_ethnicity',
                                         'indigenous_person','employment_status', 'facility_id_updated','created_at')
             ->with([
            'riskForm' => function ($query) {
                $query->select('id','risk_profile_id','ar_chestpain','ar_diffBreath',
                    'ar_lossOfConsciousness','ar_slurredSpeech','ar_facialAsymmetry',
                    'ar_weaknessNumbness','ar_disoriented','ar_chestRetraction',
                    'ar_seizureConvulsion', 'ar_actSelfHarmSuicide','ar_agitatedBehaivior',
                    'ar_eyeInjury', 'ar_severeInjuries','ar_refer_physicianName',
                    'ar_refer_reason','ar_refer_facility', 'pmh_hypertension',
                    'pmh_heartDisease', 
                    'pmh_diabetes', 
                    'pmh_specify_diabetes',
                    'pmh_cancer',
                    'pmh_specify_cancer',
                    'pmh_COPD', 
                    'pmh_asthma',
                    'pmh_allergies', 
                    'pmh_specify_allergies', 
                    'pmh_MNandSDisorder', 
                    'pmh_specify_MNandSDisorder', 
                    'pmh_specify_previous_Surgical',
                    'pmh_visionProblems', 
                    'pmh_previous_Surgical','pmh_thyroidDisorders', 'pmh_kidneyDisorders',
                    'fm_hypertension','fm_stroke','fm_heartDisease','fm_diabetesMel',
                    'fm_asthma','fm_cancer', 
                    'fm_kidneyDisease', 'fm_firstDegreRelative', 
                    'fm_havingTB5years', 
                    'fm_MNandSDisorder', 'fm_COPD', 
                    'rf_tobbacoUse', 'rf_alcoholIntake', 'rf_alcoholBingeDrinker', 
                    'rf_physicalActivity','rf_nutritionDietary','rf_weight','rf_height','rf_bodyMass','rf_waistCircum',
                    'rs_systolic_t1', 'rs_diastolic_t1',
                    'rs_systolic_t2', 'rs_diastolic_t2',
                    'rs_bloodSugar_fbs','rs_bloodSugar_rbs',
                    'rs_bloodSugar_date_taken',
                    'rs_bloodSugar_symptoms', 'rs_lipid_cholesterol',
                    'rs_lipid_hdl',
                    'rs_lipid_ldl',
                    'rs_lipid_vldl',
                    'rs_lipid_triglyceride',
                    'rs_lipid_date_taken',
                    'rs_urine_protein','rs_urine_protein_date_taken',
                    'rs_urine_ketones','rs_urine_ketones_date_taken',
                    'rs_Chronic_Respiratory_Disease', 'rs_if_yes_any_symptoms','mngm_med_hypertension','mngm_med_hypertension_specify', 'mngm_med_diabetes', 
                    'mngm_med_diabetes_options',
                    'mngm_med_diabetes_specify',
                    'mngm_date_follow_up',
                    'mngm_remarks'); 
            }
        ])->find($id);

        return response()->json(['profile' => $profile, 'facility' => $facility, 'province' => $provinceSelectedMun], 200);
    }

    public function submitRiskForm(Request $request){
        $user = $request->query('user');
        $fields = $request->query('fields'); 
        
        if(!$user){
            return response()->json(['error' => 'No user is logged in.'], 401);
        }

        // Check for duplicate in the RiskProfile table
        $existingRiskProfile = RiskProfile::where('fname', '=', $fields->fname)
        ->where('lname', '=', $fields->lname)
        ->where('mname', '=', $fields->mname)
        ->where('dob', '=', $fields->dateofbirth)
        ->first();

        if ($existingRiskProfile) {
        // Redirect with an error message if a duplicate is found
            return response()->json(['error' => 'Duplicate in entered data. Please recheck.'], 409);
        }

        try{
            $riskprofile = new RiskProfile();

            // Assign all the necessary values
            $riskprofile->profile_id = $fields->profile_id? $fields->profile_id : null;
            $riskprofile->fname = $fields->fname;
            $riskprofile->mname = $fields->mname? $fields->mname : null;
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
            $riskform->ar_chestpain = $fields->chest_pain;
            $riskform->ar_diffBreath = $fields->difficulty_breathing;
            $riskform->ar_lossOfConsciousness = $fields->loss_of_consciousness;
            $riskform->ar_slurredSpeech = $fields->slurred_speech;
            $riskform->ar_facialAsymmetry = $fields->facial_asymmetry;
            $riskform->ar_weaknessNumbness = $fields->weakness_numbness;
            $riskform->ar_disoriented = $fields->disoriented;
            $riskform->ar_chestRetraction = $fields->chest_retractions;
            $riskform->ar_seizureConvulsion = $fields->seizures;
            $riskform->ar_actSelfHarmSuicide = $fields->self_harm;
            $riskform->ar_agitatedBehaivior = $fields->agitated_behavior;
            $riskform->ar_eyeInjury = $fields->eye_injury;
            $riskform->ar_severeInjuries = $fields->severe_injuries;
            $riskform->ar_refer_physicianName = $fields->physician_name;
            $riskform->ar_refer_reason = $fields->reason;
            $riskform->ar_refer_facility = $fields->facility;


            //PAST MEDICAL HISTORY 
            $riskform->pmh_hypertension = $fields->pm_hypertension;
            $riskform->pmh_heartDisease = $fields->pm_heartDisease;
            $riskform->pmh_diabetes = $fields->pm_diabetes;
            $riskform->pmh_specify_diabetes = $fields->pm_diabetes_details;
            $riskform->pmh_cancer = $fields->pm_cancer;
            $riskform->pmh_specify_cancer = $fields->pm_cancer_details;
            $riskform->pmh_COPD = $fields->pm_COPD;
            $riskform->pmh_asthma = $fields->pm_asthma;
            $riskform->pmh_allergies = $fields->pm_allergies;
            $riskform->pmh_specify_allergies = $fields->pm_allergies_details;
            $riskform->pmh_MNandSDisorder = $fields->pm_mnsad;
            $riskform->pmh_specify_MNandSDisorder = $fields->pm_mnsad_details;
            $riskform->pmh_visionProblems = $fields->pm_vision;
            $riskform->pmh_previous_Surgical = $fields->pm_psh;
            $riskform->pmh_specify_previous_Surgical = $fields->pm_psh_details;
            $riskform->pmh_thyroidDisorders = $fields->pm_thyroid;
            $riskform->pmh_kidneyDisorders = $fields->pm_kidney;
            
            //FAMILY HISTORY
            $riskform->fm_hypertension = $fields->fm_hypertension;
            $riskform->fm_stroke = $fields->fm_stroke;
            $riskform->fm_heartDisease = $fields->fm_heart;
            $riskform->fm_diabetesMel = $fields->fm_diabetes;
            $riskform->fm_asthma = $fields->fm_asthma;
            $riskform->fm_cancer = $fields->fm_cancer;
            $riskform->fm_kidneyDisease = $fields->fm_kidney;
            $riskform->fm_firstDegreRelative = $fields->fm_degree;
            $riskform->fm_havingTB5years = $fields->fm_famtb;
            $riskform->fm_MNandSDisorder = $fields->fm_mnsad;
            $riskform->fm_COPD = $fields->fm_cop;

            // NCD RISK FACTORS 
            $tobaccoUsed = $fields->tobaccoUse; 
            $tobaccoUseLimited = array_slice($tobaccoUsed, 0, 2); 
            $riskform->rf_tobbacoUse = implode(', ', $tobaccoUseLimited); 
            $riskform->rf_alcoholIntake = $fields->ncd_alcohol; 
            $riskform->rf_alcoholBingeDrinker = $fields->ncd_alcoholBinge;
            $riskform->rf_physicalActivity = $fields->ncd_physical; 
            $riskform->rf_nutritionDietary = $fields->ncd_nutrition; 
            $riskform->rf_weight = $fields->rf_weight;
            $riskform->rf_height = $fields->rf_height;
            $riskform->rf_bodyMass = $fields->rf_BMI;
            $riskform->rf_waistCircum = $fields->rf_waist;

            //RISK SCREENING
            // Hypertension/Diabetes/Hypercholestrolemia/Renal Diseases

            $dmSymptoms = $fields->dm_symptoms;

            $riskform->rs_systolic_t1 = $fields->systolic_t1;
            $riskform->rs_diastolic_t1 = $fields->diastolic_t1;
            $riskform->rs_systolic_t2 = $fields->systolic_t2;
            $riskform->rs_diastolic_t2 = $fields->diastolic_t2;
            $riskform->rs_bloodSugar_fbs = $fields->fbs_result;
            $riskform->rs_bloodSugar_rbs = $fields->rbs_result;
            $riskform->rs_bloodSugar_date_taken = $fields->bloodSugar_date_taken;
            $riskform->rs_bloodSugar_symptoms = implode(', ', $dmSymptoms);
            $riskform->rs_lipid_cholesterol = $fields->lipid_cholesterol; 
            $riskform->rs_lipid_hdl = $fields->lipid_hdl; 
            $riskform->rs_lipid_ldl = $fields->lipid_ldl; 
            $riskform->rs_lipid_vldl = $fields->lipid_vldl; 
            $riskform->rs_lipid_triglyceride = $fields->lipid_triglyceride; 
            $riskform->rs_lipid_date_taken = date('Y-m-d', strtotime($fields->lipid_date_taken));
            $riskform->rs_urine_protein = $fields->uri_protein;
            $riskform->rs_urine_protein_date_taken = date('Y-m-d', strtotime($fields->uri_protein_date_taken));
            $riskform->rs_urine_ketones = $fields->uri_ketones;
            $riskform->rs_urine_ketones_date_taken = date('Y-m-d', strtotime($fields->uri_ketones_date_taken));
            
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
            $riskform->mngm_med_hypertension = $fields->anti_hypertensives;
            $riskform->mngm_med_hypertension_specify = $fields->anti_hypertensives_specify;
        
            // Anti-Diabetes: Store selected option and any specify text, and type
            $riskform->mngm_med_diabetes = $fields->anti_diabetes;
            $riskform->mngm_med_diabetes_options = $fields->anti_diabetes_type;
            $riskform->mngm_med_diabetes_specify = $fields->anti_diabetes_specify;
        
            // Follow-up Date
            $riskform->mngm_date_follow_up = $fields->follow_up_date;
        
            // Remarks (Text area)
            $riskform->mngm_remarks = $fields->remarks;
        
            // Save the data
            $riskform->save();
            return response()->json(['message' => 'Entry successfully saved.'], 200);
        }catch(Exception $e){
            return response()->json(['error' => 'Something went wrong. Please try again later'], 500);
        }
    }
}
