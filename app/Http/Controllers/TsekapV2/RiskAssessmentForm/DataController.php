<?php

namespace App\Http\Controllers\TsekapV2\RiskAssessmentForm;

use Exception;

use App\RiskProfile;
use App\RiskFormAssesment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

// for logging
use Illuminate\Support\Facades\Log;

class DataController extends Controller
{
    public function retrievePatientRiskProfile(Request $request)
    {
        // Manually validate the request
        $validator = Validator::make($request->all(), [
            'fields' => 'required|array',
            'fields.keyword' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        // Log the entire request for debugging
        \Log::info('Request Payload:', $request->all());

        // Retrieve the fields parameter
        $fields = $request->input('fields');
        echo "Fields:";
        print_r($fields);

        // Log the fields for debugging
        \Log::info('Fields Input:', ['fields' => $fields]);

        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Log the user for debugging
        \Log::info('User:', ['user' => $user]);

        // Build the query
        $query = RiskProfile::select('id', 'fname', 'mname', 'lname', 'dob', 'sex', 'civil_status', 'barangay_id', 'municipal_id', 'province_id', 'facility_id_updated', 'created_at')
            ->with([
                'province' => function ($query) use ($user) {
                    $query->select('id', 'description')->where('id', $user->province);
                },
                'muncity' => function ($query) use ($user) {
                    $query->select('id', 'province_id', 'description')->where('province_id', $user->province);
                },
            ])
            ->orderby('id', 'desc');

        // Log the query for debugging
        \Log::info('Query Instance:', ['query' => $query->toSql(), 'bindings' => $query->getBindings()]);

        // Get the user privilege and keyword
        $user_priv = $user->user_priv;
        $keyword = isset($fields['keyword']) ? $fields['keyword'] : null;

        // Build the query based on user privileges
        switch ($user_priv) {
            case 3: // provincial view
                if (!empty($keyword)) {
                    $query->where('province_id', $user->province)->where(function ($q) use ($keyword) {
                        $q->where('fname', 'like', "%$keyword%")
                            ->orWhere('lname', 'like', "%$keyword%")
                            ->orWhereHas('muncity', function ($q) use ($keyword) {
                                $q->where('description', 'like', "%$keyword%");
                            });
                    });
                } else {
                    $query->where('province_id', $user->province);
                }
                break;

            case 6: // facility view
                if (!empty($keyword)) {
                    $query->where('facility_id_updated', $user->facility_id)->where(function ($q) use ($keyword) {
                        $q->where('fname', 'like', "%$keyword%")
                            ->orWhere('lname', 'like', "%$keyword%")
                            ->orWhereHas('province', function ($q) use ($keyword) {
                                $q->where('description', 'like', "%$keyword%");
                            })
                            ->orWhereHas('muncity', function ($q) use ($keyword) {
                                $q->where('description', 'like', "%$keyword%");
                            });
                    });
                } else {
                    $query->where('facility_id_updated', $user->facility_id);
                }
                break;

            case 7: // region view
                if (!empty($keyword)) {
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

        // Paginate the results
        $riskprofiles = $query->simplePaginate(15);

        // Return the results as JSON
        return response()->json($riskprofiles, 200);
    }

    public function retrievePatientRiskAssessment(Request $request)
    {
        $fields = $request->input('fields');

        // check authentication if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $id = $fields['id'];
        $muncity = $fields['muncity_id'] !== null ? $fields['muncity_id'] : null;
        $province = $fields['province_id'] !== null ? $fields['province_id'] : null;

        // Building the query
        $profileQuery = RiskProfile::select('id', 'profile_id', 'lname', 'fname', 'mname', 'suffix', 'sex', 'dob', 'age', 'civil_status', 'religion', 'other_religion', 'contact', 'province_id', 'muncity_id', 'barangay_id', 'street', 'purok', 'sitio', 'phic_id', 'pwd_id', 'citizenship', 'other_citizenship', 'indigenous_person', 'employment_status', 'facility_id_updated', 'created_at', 'updated_at')->with([
            'riskForm' => function ($query) {
                $query->select(
                    'id',
                    'risk_profile_id',
                    'ar_chest_pain',
                    'ar_difficulty_breathing',
                    'ar_loss_of_consciousness',
                    'ar_slurred_speech',
                    'ar_facial_asymmetry',
                    'ar_weakness_numbness',
                    'ar_disoriented',
                    'ar_chest_retractions',
                    'ar_seizure_convulsion',
                    'ar_act_self_harm_suicide',
                    'ar_agitated_behavior',
                    'ar_eye_injury',
                    'ar_severe_injuries',
                    'ar_refer_physician_name',
                    'ar_refer_reason',
                    'ar_refer_facility',
                    'pmh_hypertension',
                    'pmh_heart_disease',
                    'pmh_diabetes',
                    'pmh_specify_diabetes',
                    'pmh_cancer',
                    'pmh_specify_cancer',
                    'pmh_copd',
                    'pmh_asthma',
                    'pmh_allergies',
                    'pmh_specify_allergies',
                    'pmh_mn_and_s_disorder',
                    'pmh_specify_mn_and_s_disorder',
                    'pmh_vision_problems',
                    'pmh_previous_surgical',
                    'pmh_specify_previous_surgical',
                    'pmh_thyroid_disorders',
                    'pmh_kidney_disorders',
                    'fmh_hypertension',
                    'fmh_side_hypertension',
                    'fmh_stroke',
                    'fmh_side_stroke',
                    'fmh_heart_disease',
                    'fmh_side_heart_disease',
                    'fmh_diabetes_mellitus',
                    'fmh_side_diabetes_mellitus',
                    'fmh_asthma',
                    'fmh_side_asthma',
                    'fmh_cancer',
                    'fmh_side_cancer',
                    'fmh_kidney_disease',
                    'fmh_side_kidney_disease',
                    'fmh_first_degree_relative',
                    'fmh_side_coronary_disease',
                    'fmh_having_tuberculosis_5_years',
                    'fmh_side_tuberculosis',
                    'fmh_mn_and_s_disorder',
                    'fmh_side_m_and_s_disorder',
                    'fmh_copd',
                    'fmh_side_copd',
                    'rf_tobacco_use',
                    'rf_alcohol_intake',
                    'rf_alcohol_binge_drinker',
                    'rf_physical_activity',
                    'rf_nutrition_dietary',
                    'rf_weight',
                    'rf_height',
                    'rf_body_mass',
                    'rf_waist_circumference',
                    'rs_systolic_t1',
                    'rs_diastolic_t1',
                    'rs_systolic_t2',
                    'rs_diastolic_t2',
                    'rs_blood_sugar_fbs',
                    'rs_blood_sugar_rbs',
                    'rs_blood_sugar_date_taken',
                    'rs_blood_sugar_symptoms',
                    'rs_lipid_cholesterol',
                    'rs_lipid_hdl',
                    'rs_lipid_ldl',
                    'rs_lipid_vldl',
                    'rs_lipid_triglyceride',
                    'rs_lipid_date_taken',
                    'rs_urine_protein',
                    'rs_urine_protein_date_taken',
                    'rs_urine_ketones',
                    'rs_urine_ketones_date_taken',
                    'rs_chronic_respiratory_disease',
                    'rs_if_yes_any_symptoms',
                    'mngm_med_hypertension',
                    'mngm_med_hypertension_specify',
                    'mngm_med_diabetes',
                    'mngm_med_diabetes_options',
                    'mngm_med_diabetes_specify',
                    'mngm_date_follow_up',
                    'mngm_remarks',
                );
            },
        ]);

        // Applying filters based on muncity and province
        if ($muncity) {
            $profileQuery->where('municity_id', $muncity);
        }

        if ($province) {
            $profileQuery->where('province_id', $province);
        }

        $profile = $profileQuery->find($id);

        if (!$profile) {
            return response()->json(['error' => 'Profile not found.'], 404);
        }

        return response()->json(['profile' => $profile, 'province' => $province, 'municipality' => $muncity], 200);
    }

    public function submitRiskProfile(Request $request)
    {
        $fields = $request->input('fields');

        // check authentication if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Define validation rules
        $rules = [
            'fields.profile_id' => 'nullable|integer',
            'fields.lname' => 'required|string|max:255',
            'fields.fname' => 'required|string|max:255',
            'fields.mname' => 'nullable|string|max:255',
            'fields.suffix' => 'nullable|string|max:10',
            'fields.sex' => 'required|string|max:1',
            'fields.dob' => 'required|date',
            'fields.age' => 'required|integer|min:0|max:150',
            'fields.civil_status' => 'required|string|max:20',
            'fields.religion' => 'required|string|max:50',
            'fields.other_religion' => 'nullable|string|max:50',
            'fields.contact' => 'required|string|max:20',
            'fields.province_id' => 'required|integer',
            'fields.muncity_id' => 'required|integer',
            'fields.barangay_id' => 'required|integer',
            'fields.street' => 'nullable|string|max:255',
            'fields.purok' => 'nullable|string|max:255',
            'fields.sitio' => 'nullable|string|max:255',
            'fields.phic_id' => 'nullable|string|max:20',
            'fields.pwd_id' => 'nullable|string|max:20',
            'fields.citizenship' => 'required|string|max:50',
            'fields.other_citizenship' => 'nullable|string|max:50',
            'fields.indigenous_person' => 'required|boolean',
            'fields.employment_status' => 'required|string|max:50',
            'fields.facility_id_updated' => 'required|integer',
        ];

        // Validate the request
        $validator = Validator::make($fields, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Check for duplicate in the RiskProfile table
        $existingRiskProfile = RiskProfile::where('profile_id', $fields['profile_id'])
            ->where('fname', $fields['fname'])
            ->where('lname', $fields['lname'])
            ->where('mname', $fields['mname'])
            ->where('dob', $fields['dateofbirth'])
            ->first();

        if ($existingRiskProfile) {
            return response()->json(['error' => 'Duplicate in entered data. Please recheck.'], 409);
        }

        try {
            $riskprofile = new RiskProfile($fields);
            $riskprofile->save();

            return response()->json(['message' => 'Entry successfully saved.'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later'], 500);
        }
    }

    public function submitRiskForm(Request $request)
    {
        $fields = $request->input('fields');

        // check authentication if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Define validation rules
        $rules = [
            'fields.risk_profile_id' => 'required|integer',
            'fields.chest_pain' => 'required|boolean',
            'fields.difficulty_breathing' => 'required|boolean',
            'fields.loss_of_consciousness' => 'required|boolean',
            'fields.slurred_speech' => 'required|boolean',
            'fields.facial_asymmetry' => 'required|boolean',
            'fields.weakness_numbness' => 'required|boolean',
            'fields.disoriented' => 'required|boolean',
            'fields.chest_retractions' => 'required|boolean',
            'fields.seizures' => 'required|boolean',
            'fields.self_harm' => 'required|boolean',
            'fields.agitated_behavior' => 'required|boolean',
            'fields.eye_injury' => 'required|boolean',
            'fields.severe_injuries' => 'required|boolean',
            'fields.physician_name' => 'required|string|max:255',
            'fields.reason' => 'required|string|max:255',
            'fields.facility' => 'required|string|max:255',
            'fields.pm_hypertension' => 'required|boolean',
            'fields.pm_heartDisease' => 'required|boolean',
            'fields.pm_diabetes' => 'required|boolean',
            'fields.pm_diabetes_details' => 'nullable|string|max:255',
            'fields.pm_cancer' => 'required|boolean',
            'fields.pm_cancer_details' => 'nullable|string|max:255',
            'fields.pm_COPD' => 'required|boolean',
            'fields.pm_asthma' => 'required|boolean',
            'fields.pm_allergies' => 'required|boolean',
            'fields.pm_allergies_details' => 'nullable|string|max:255',
            'fields.pm_mnsad' => 'required|boolean',
            'fields.pm_mnsad_details' => 'nullable|string|max:255',
            'fields.pm_vision' => 'required|boolean',
            'fields.pm_psh' => 'required|boolean',
            'fields.pm_psh_details' => 'nullable|string|max:255',
            'fields.pm_thyroid' => 'required|boolean',
            'fields.pm_kidney' => 'required|boolean',

            'fields.fmh_hypertension' => 'required|boolean',
            'fields.fmh_side_hypertension' => 'required|boolean',
            'fields.fmh_stroke' => 'required|boolean',
            'fields.fmh_side_stroke' => 'required|boolean',
            'fields.fmh_heart_disease' => 'required|boolean',
            'fields.fmh_side_heart_disease' => 'required|boolean',
            'fields.fmh_diabetes' => 'required|boolean',
            'fields.fmh_side_diabetes' => 'required|boolean',
            'fields.fmh_asthma' => 'required|boolean',
            'fields.fmh_side_asthma' => 'required|boolean',
            'fields.fmh_cancer' => 'required|boolean',
            'fields.fmh_side_cancer' => 'required|boolean',
            'fields.fmh_kidney_disease' => 'required|boolean',
            'fields.fmh_side_kidney_disease' => 'required|boolean',
            'fields.fmh_degree' => 'required|boolean',
            'fields.fmh_side_coronary_disease' => 'required|boolean',
            'fields.fmh_famtb' => 'required|boolean',
            'fields.fmh_side_famtb' => 'required|boolean',
            'fields.fmh_mnsad' => 'required|boolean',
            'fields.fmh_side_mnsad' => 'required|boolean',
            'fields.fmh_copd' => 'required|boolean',
            'fields.fmh_side_copd' => 'required|boolean',

            'fields.tobaccoUse' => 'required|array|min:1',
            'fields.ncd_alcohol' => 'required|boolean',
            'fields.ncd_alcoholBinge' => 'required|boolean',
            'fields.ncd_physical' => 'required|boolean',
            'fields.ncd_nutrition' => 'required|boolean',
            'fields.rf_weight' => 'required|numeric',
            'fields.rf_height' => 'required|numeric',
            'fields.rf_BMI' => 'required|numeric',
            'fields.rf_waist' => 'required|numeric',
            'fields.dm_symptoms' => 'required|array|min:1',
            'fields.systolic_t1' => 'required|numeric',
            'fields.diastolic_t1' => 'required|numeric',
            'fields.systolic_t2' => 'required|numeric',
            'fields.diastolic_t2' => 'required|numeric',
            'fields.fbs_result' => 'required|numeric',
            'fields.rbs_result' => 'required|numeric',
            'fields.bloodSugar_date_taken' => 'required|date',
            'fields.lipid_cholesterol' => 'required|numeric',
            'fields.lipid_hdl' => 'required|numeric',
            'fields.lipid_ldl' => 'required|numeric',
            'fields.lipid_vldl' => 'required|numeric',
            'fields.lipid_triglyceride' => 'required|numeric',
            'fields.lipid_date_taken' => 'required|date',
            'fields.uri_protein' => 'required|numeric',
            'fields.uri_protein_date_taken' => 'required|date',
            'fields.uri_ketones' => 'required|numeric',
            'fields.uri_ketones_date_taken' => 'required|date',
            'fields.symptom_breathlessness' => 'required|boolean',
            'fields.symptom_sputum_production' => 'required|boolean',
            'fields.symptom_chronic_cough' => 'required|boolean',
            'fields.symptom_chest_tightness' => 'required|boolean',
            'fields.symptom_wheezing' => 'required|boolean',
            'fields.pefr_above_20_percent' => 'required|boolean',
            'fields.pefr_below_20_percent' => 'required|boolean',
            'fields.anti_hypertensives' => 'required|string|max:255',
            'fields.anti_hypertensives_specify' => 'nullable|string|max:255',
            'fields.anti_diabetes' => 'required|string|max:255',
            'fields.anti_diabetes_type' => 'nullable|string|max:255',
            'fields.anti_diabetes_specify' => 'nullable|string|max:255',
            'fields.follow_up_date' => 'required|date',
            'fields.remarks' => 'nullable|string|max:1000',
        ];

        $validator = Validator::make($fields, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $riskform = new RiskFormAssesment();

            // Health assessment checkbox fields
            $riskform->risk_profile_id = $fields->risk_profile_id;
            $riskform->ar_chest_pain = $fields->chest_pain;
            $riskform->ar_difficulty_breathing = $fields->difficulty_breathing;
            $riskform->ar_loss_of_consciousness = $fields->loss_of_consciousness;
            $riskform->ar_slurred_speech = $fields->slurred_speech;
            $riskform->ar_facial_asymmetry = $fields->facial_asymmetry;
            $riskform->ar_weakness_numbness = $fields->weakness_numbness;
            $riskform->ar_disoriented = $fields->disoriented;
            $riskform->ar_chest_retractions = $fields->chest_retractions;
            $riskform->ar_seizure_convulsion = $fields->seizures;
            $riskform->ar_act_self_harm_suicide = $fields->self_harm;
            $riskform->ar_agitated_behavior = $fields->agitated_behavior;
            $riskform->ar_eye_injury = $fields->eye_injury;
            $riskform->ar_severe_injuries = $fields->severe_injuries;
            $riskform->ar_refer_physician_name = $fields->physician_name;
            $riskform->ar_refer_reason = $fields->reason;
            $riskform->ar_refer_facility = $fields->facility;

            //PAST MEDICAL HISTORY
            $riskform->pmh_hypertension = $fields->pm_hypertension;
            $riskform->pmh_heart_disease = $fields->pm_heartDisease;
            $riskform->pmh_diabetes = $fields->pm_diabetes;
            $riskform->pmh_specify_diabetes = $fields->pm_diabetes_details;
            $riskform->pmh_cancer = $fields->pm_cancer;
            $riskform->pmh_specify_cancer = $fields->pm_cancer_details;
            $riskform->pmh_copd = $fields->pm_COPD;
            $riskform->pmh_asthma = $fields->pm_asthma;
            $riskform->pmh_allergies = $fields->pm_allergies;
            $riskform->pmh_specify_allergies = $fields->pm_allergies_details;
            $riskform->pmh_mn_and_s_disorder = $fields->pm_mnsad;
            $riskform->pmh_specify_mn_and_s_disorder = $fields->pm_mnsad_details;
            $riskform->pmh_vision_problems = $fields->pm_vision;
            $riskform->pmh_previous_surgical = $fields->pm_psh;
            $riskform->pmh_specify_previous_surgical = $fields->pm_psh_details;
            $riskform->pmh_thyroid_disorders = $fields->pm_thyroid;
            $riskform->pmh_kidney_disorders = $fields->pm_kidney;

            //FAMILY HISTORY
            $riskform->fmh_hypertension = $fields->fmh_hypertension;
            $riskform->fmh_side_hypertension = $fields->fmh_side_hypertension;
            $riskform->fmh_stroke = $fields->fmh_stroke;
            $riskform->fmh_side_stroke = $fields->fmh_side_stroke;
            $riskform->fmh_heart_disease = $fields->fmh_heart_disease;
            $riskform->fmh_side_heartDisease = $fields->fmh_side_heart_disease;
            $riskform->fmh_diabetes_mellitus = $fields->fmh_diabetes;
            $riskform->fmh_side_diabetes = $fields->fmh_side_diabetes;
            $riskform->fmh_asthma = $fields->fmh_asthma;
            $riskform->fmh_side_asthma = $fields->fmh_side_asthma;
            $riskform->fmh_cancer = $fields->fmh_cancer;
            $riskform->fmh_side_cancer = $fields->fmh_side_cancer;
            $riskform->fmh_kidney_disease = $fields->fmh_kidney;
            $riskform->fmh_side_kidney_disease = $fields->fmh_side_kidney_disease;
            $riskform->fmh_first_degree_relative = $fields->fmh_degree;
            $riskform->fmh_side_coronary_disease = $fields->fmh_side_coronary_disease;
            $riskform->fmh_having_tuberculosis_5_years = $fields->fmh_famtb;
            $riskform->fmh_side_tuberculosis = $fields->fmh_side_famtb;
            $riskform->fmh_mn_and_s_disorder = $fields->fmh_mnsad;
            $riskform->fmh_side_m_and_s_disorder = $fields->fmh_side_mnsad;
            $riskform->fmh_copd = $fields->fmh_copd;

            // NCD RISK FACTORS
            $tobaccoUsed = $fields->tobaccoUse;
            $tobaccoUseLimited = array_slice($tobaccoUsed, 0, 2);
            $riskform->rf_tobacco_use = implode(', ', $tobaccoUseLimited);
            $riskform->rf_alcohol_intake = $fields->ncd_alcohol;
            $riskform->rf_alcohol_binge_drinker = $fields->ncd_alcoholBinge;
            $riskform->rf_physical_activity = $fields->ncd_physical;
            $riskform->rf_nutrition_dietary = $fields->ncd_nutrition;
            $riskform->rf_weight = $fields->rf_weight;
            $riskform->rf_height = $fields->rf_height;
            $riskform->rf_body_mass = $fields->rf_BMI;
            $riskform->rf_waist_circumference = $fields->rf_waist;

            //RISK SCREENING
            // Hypertension/Diabetes/Hypercholestrolemia/Renal Diseases
            $dmSymptoms = $fields->dm_symptoms;

            $riskform->rs_systolic_t1 = $fields->systolic_t1;
            $riskform->rs_diastolic_t1 = $fields->diastolic_t1;
            $riskform->rs_systolic_t2 = $fields->systolic_t2;
            $riskform->rs_diastolic_t2 = $fields->diastolic_t2;
            $riskform->rs_blood_sugar_fbs = $fields->fbs_result;
            $riskform->rs_blood_sugar_rbs = $fields->rbs_result;
            $riskform->rs_blood_sugar_date_taken = $fields->bloodSugar_date_taken;
            $riskform->rs_blood_sugar_symptoms = implode(', ', $dmSymptoms);
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
            $riskform->rs_chronic_respiratory_disease = implode(', ', $symptoms); // Store as a string

            // For PEFR checkboxes, similarly store the selected labels as a comma-separated string
            $pefr = [];
            if ($fields->has('pefr_above_20_percent')) {
                $pefr[] = '20% change from baseline (consider Probable Asthma)';
            }
            if ($fields->has('pefr_below_20_percent')) {
                $pefr[] = '20% change from baseline (consider Probable COPD)';
            }

            // Convert the array into a comma-separated string for PEFR
            $riskform->rs_if_yes_any_symptoms = implode(', ', $pefr); // Store as a string
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
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later'], 500);
        }
    }

    // update risk profile
    public function updateRiskProfile(Request $request)
    {
        $fields = $request->input('fields');

        // check authentication if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Define validation rules
        $rules = [
            'fields.profile_id' => 'required|integer',
            'fields.fname' => 'required|string|max:255',
            'fields.mname' => 'nullable|string|max:255',
            'fields.lname' => 'required|string|max:255',
            'fields.suffix' => 'nullable|string|max:10',
            'fields.sex' => 'required|string|max:1',
            'fields.dateofbirth' => 'required|date',
            'fields.age' => 'required|integer|min:0|max:150',
            'fields.contact' => 'required|string|max:20',
            'fields.province_risk' => 'required|integer',
            'fields.municipal' => 'required|integer',
            'fields.barangay' => 'required|integer',
            'fields.sitio' => 'nullable|string|max:255',
            'fields.street' => 'nullable|string|max:255',
            'fields.purok' => 'nullable|string|max:255',
            'fields.phic_id' => 'nullable|string|max:20',
            'fields.civil_status' => 'required|string|max:20',
            'fields.religion' => 'required|string|max:50',
            'fields.other_religion' => 'nullable|string|max:50',
            'fields.pwd_id' => 'nullable|string|max:20',
            'fields.citizenship' => 'required|string|max:50',
            'fields.other_citizenship' => 'nullable|string|max:50',
            'fields.indigenous_person' => 'required|boolean',
            'fields.employment_status' => 'required|string|max:50',
            'fields.facility_id_updated' => 'required|integer',
        ];

        // Validate the request
        $validator = Validator::make($fields, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Find the existing RiskProfile
        $riskprofile = RiskProfile::find($fields['profile_id']);

        if (!$riskprofile) {
            return response()->json(['error' => 'Profile not found.'], 404);
        }

        try {
            // Update the RiskProfile with new data
            $riskprofile->update($fields);

            return response()->json(['message' => 'Profile successfully updated.'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later'], 500);
        }
    }

    // update risk form
    public function updateRiskForm(Request $request)
    {
        $fields = $request->input('fields');

        // check authentication if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Define validation rules
        $rules = [
            'fields.risk_profile_id' => 'required|integer',
            'fields.chest_pain' => 'required|boolean',
            'fields.difficulty_breathing' => 'required|boolean',
            'fields.loss_of_consciousness' => 'required|boolean',
            'fields.slurred_speech' => 'required|boolean',
            'fields.facial_asymmetry' => 'required|boolean',
            'fields.weakness_numbness' => 'required|boolean',
            'fields.disoriented' => 'required|boolean',
            'fields.chest_retractions' => 'required|boolean',
            'fields.seizures' => 'required|boolean',
            'fields.self_harm' => 'required|boolean',
            'fields.agitated_behavior' => 'required|boolean',
            'fields.eye_injury' => 'required|boolean',
            'fields.severe_injuries' => 'required|boolean',
            'fields.physician_name' => 'required|string|max:255',
            'fields.reason' => 'required|string|max:255',
            'fields.facility' => 'required|string|max:255',
            'fields.pm_hypertension' => 'required|boolean',
            'fields.pm_heartDisease' => 'required|boolean',
            'fields.pm_diabetes' => 'required|boolean',
            'fields.pm_diabetes_details' => 'nullable|string|max:255',
            'fields.pm_cancer' => 'required|boolean',
            'fields.pm_cancer_details' => 'nullable|string|max:255',
            'fields.pm_COPD' => 'required|boolean',
            'fields.pm_asthma' => 'required|boolean',
            'fields.pm_allergies' => 'required|boolean',
            'fields.pm_allergies_details' => 'nullable|string|max:255',
            'fields.pm_mnsad' => 'required|boolean',
            'fields.pm_mnsad_details' => 'nullable|string|max:255',
            'fields.pm_vision' => 'required|boolean',
            'fields.pm_psh' => 'required|boolean',
            'fields.pm_psh_details' => 'nullable|string|max:255',
            'fields.pm_thyroid' => 'required|boolean',
            'fields.pm_kidney' => 'required|boolean',

            'fields.fmh_hypertension' => 'required|boolean',
            'fields.fmh_side_hypertension' => 'required|boolean',
            'fields.fmh_stroke' => 'required|boolean',
            'fields.fmh_side_stroke' => 'required|boolean',
            'fields.fmh_heart_disease' => 'required|boolean',
            'fields.fmh_side_heart_disease' => 'required|boolean',
            'fields.fmh_diabetes' => 'required|boolean',
            'fields.fmh_side_diabetes' => 'required|boolean',
            'fields.fmh_asthma' => 'required|boolean',
            'fields.fmh_side_asthma' => 'required|boolean',
            'fields.fmh_cancer' => 'required|boolean',
            'fields.fmh_side_cancer' => 'required|boolean',
            'fields.fmh_kidney_disease' => 'required|boolean',
            'fields.fmh_side_kidney_disease' => 'required|boolean',
            'fields.fmh_degree' => 'required|boolean',
            'fields.fmh_side_coronary_disease' => 'required|boolean',
            'fields.fmh_famtb' => 'required|boolean',
            'fields.fmh_side_famtb' => 'required|boolean',
            'fields.fmh_mnsad' => 'required|boolean',
            'fields.fmh_side_mnsad' => 'required|boolean',
            'fields.fmh_copd' => 'required|boolean',
            'fields.fmh_side_copd' => 'required|boolean',

            'fields.tobaccoUse' => 'required|array|min:1',
            'fields.ncd_alcohol' => 'required|boolean',
            'fields.ncd_alcoholBinge' => 'required|boolean',
            'fields.ncd_physical' => 'required|boolean',
            'fields.ncd_nutrition' => 'required|boolean',
            'fields.rf_weight' => 'required|numeric',
            'fields.rf_height' => 'required|numeric',
            'fields.rf_BMI' => 'required|numeric',
            'fields.rf_waist' => 'required|numeric',
            'fields.dm_symptoms' => 'required|array|min:1',
            'fields.systolic_t1' => 'required|numeric',
            'fields.diastolic_t1' => 'required|numeric',
            'fields.systolic_t2' => 'required|numeric',
            'fields.diastolic_t2' => 'required|numeric',
            'fields.fbs_result' => 'required|numeric',
            'fields.rbs_result' => 'required|numeric',
            'fields.bloodSugar_date_taken' => 'required|date',
            'fields.lipid_cholesterol' => 'required|numeric',
            'fields.lipid_hdl' => 'required|numeric',
            'fields.lipid_ldl' => 'required|numeric',
            'fields.lipid_vldl' => 'required|numeric',
            'fields.lipid_triglyceride' => 'required|numeric',
            'fields.lipid_date_taken' => 'required|date',
            'fields.uri_protein' => 'required|numeric',
            'fields.uri_protein_date_taken' => 'required|date',
            'fields.uri_ketones' => 'required|numeric',
            'fields.uri_ketones_date_taken' => 'required|date',
            'fields.symptom_breathlessness' => 'required|boolean',
            'fields.symptom_sputum_production' => 'required|boolean',
            'fields.symptom_chronic_cough' => 'required|boolean',
            'fields.symptom_chest_tightness' => 'required|boolean',
            'fields.symptom_wheezing' => 'required|boolean',
            'fields.pefr_above_20_percent' => 'required|boolean',
            'fields.pefr_below_20_percent' => 'required|boolean',
            'fields.anti_hypertensives' => 'required|string|max:255',
            'fields.anti_hypertensives_specify' => 'nullable|string|max:255',
            'fields.anti_diabetes' => 'required|string|max:255',
            'fields.anti_diabetes_type' => 'nullable|string|max:255',
            'fields.anti_diabetes_specify' => 'nullable|string|max:255',
            'fields.follow_up_date' => 'required|date',
            'fields.remarks' => 'nullable|string|max:1000',
        ];

        // Validate the request
        $validator = Validator::make($fields, $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Find the existing RiskFormAssesment
        $riskform = RiskFormAssesment::where('risk_profile_id', $fields['risk_profile_id'])->first();

        if (!$riskform) {
            return response()->json(['error' => 'Risk form not found.'], 404);
        }

        try {
            // Update the RiskFormAssesment with new data
            $riskform->update($fields);

            return response()->json(['message' => 'Risk form successfully updated.'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later'], 500);
        }
    }

    // delete risk profile
    public function deleteRiskProfile(Request $request)
    {
        $fields = $request->input('fields');

        $riskProfileId = $fields->risk_profile_id;

        // check authentication if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // get user
        $user = Auth::user();

        if (!$riskProfileId) {
            return response()->json(['error' => 'Profile ID is required.'], 400);
        }

        if ($user['user_priv'] != 1) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        if (!$riskProfileId) {
            return response()->json(['error' => 'Profile ID is required.'], 400);
        }

        try {
            $riskProfile = RiskProfile::find($riskProfileId);

            if (!$riskProfile) {
                return response()->json(['error' => 'Risk profile not found.'], 404);
            }

            $riskProfile->delete();

            return response()->json(['message' => 'Risk profile successfully deleted.'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later'], 500);
        }
    }

    // delete risk form
    public function deleteRiskForm(Request $request)
    {
        $fields = $request->input('fields');

        $riskProfileId = $fields->risk_profile_id;

        // check authentication if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // get user
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'No user is logged in.'], 401);
        }

        if ($user['user_priv'] != 1) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        if (!$riskProfileId) {
            return response()->json(['error' => 'Risk profile ID is required.'], 400);
        }

        try {
            $riskForm = RiskFormAssesment::where('risk_profile_id', $riskProfileId)->first();

            if (!$riskForm) {
                return response()->json(['error' => 'Risk form not found.'], 404);
            }

            $riskForm->delete();

            return response()->json(['message' => 'Risk form successfully deleted.'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong. Please try again later'], 500);
        }
    }
}
