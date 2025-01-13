<?php

namespace App\Http\Controllers\TsekapV2\RiskAssessmentForm;

use Exception;

use App\RiskProfile;
use App\RiskFormAssessment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;

class DataController extends Controller
{
    public function retrievePatientRiskProfile(Request $request)
    {
        // Validate the request using the Validator facade
        $validator = Validator::make($request->all(), [
            'fields' => 'required|array',
            'fields.filter' => 'required|string',
            'fields.keyword' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $fields = $request->input('fields');

        $filter = isset($fields['filter']) ? $fields['filter'] : "fname";
        $keyword = isset($fields['keyword']) ? $fields['keyword'] : null; // Older ternary syntax

        // Debugging: Log the keyword
        \Log::info('Keyword:', ['keyword' => $keyword]);
        \Log::info('Filter:', ['filter' => $filter]);

        // Base query for risk profiles with INNER JOIN
        $query = RiskProfile::select(
            'risk_profile.id',
            'risk_profile.fname',
            'risk_profile.mname',
            'risk_profile.lname',
            'risk_profile.dob',
            'risk_profile.sex',
            'risk_profile.civil_status',
            'risk_profile.barangay_id',
            'risk_profile.municipal_id',
            'risk_profile.province_id',
            'risk_profile.facility_id_updated',
            'risk_profile.offline_entry',
            'risk_profile.created_at',
            'risk_profile.updated_at',
            'muncity.description as municipal_name',
            'province.description as province_name'
        )
            ->join('muncity', 'risk_profile.municipal_id', '=', 'muncity.id') // Corrected column name
            ->join('province', 'risk_profile.province_id', '=', 'province.id');

        // Apply user privilege filters
        if ($user->user_priv === 3) {
            $query->where('risk_profile.province_id', $user->province);
        }
        // } elseif ($user->user_priv === 6) {
        //     $query->where('risk_profile.facility_id_updated', $user->facility_id);
        // }

        // Apply keyword filter for fname, lname, or dob (OR condition for each field)
        if ($keyword) {
            if ($filter === 'fname') {
                $query->where('risk_profile.fname', 'like', "%$keyword%");
            } elseif ($filter === 'lname') {
                $query->where('risk_profile.lname', 'like', "%$keyword%");
            } elseif ($filter === 'dob') {
                $query->where('risk_profile.dob', 'like', "%$keyword%");
            } else {
                $query->where(function ($q) use ($keyword) {
                    $q->where('risk_profile.fname', 'like', "%$keyword%")
                        ->orWhere('risk_profile.lname', 'like', "%$keyword%")
                        ->orWhere('risk_profile.dob', 'like', "%$keyword%");
                });
            }
        }

        // Debugging: Log the query instance
        \Log::info('Query Instance:', [
            'bindings' => $query->getBindings(),
        ]);

        // Paginate and return results
        return response()->json($query->simplePaginate(15), 200);
    }

    public function retrievePatientRiskAssessment(Request $request)
    {
        // Validate the request using the Validator facade
        $validator = Validator::make($request->all(), [
            'fields' => 'required|array',
            'fields.profile_id' => 'required|number',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        // check authentication if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        $fields = $request->input('fields');
        $id = $fields['profile_id'];

        // Building the query
        $query = RiskFormAssessment::select(
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
            'offline_entry',
            'created_at',
            'updated_at'
        );

        if ($id) {
            $query->where('risk_profile_id', $id);
        }

        return response()->json($query->simplePaginate(15), 200);
    }

    public function addRiskProfile(Request $request)
    {
        $fields = $request->input('fields');
    
        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Define validation rules
        $rules = [
			'fields' => 'required|array',
            'fields.profile_id' => 'integer',
            'fields.lname' => 'required|string|max:255',
            'fields.fname' => 'required|string|max:255',
            'fields.mname' => 'string|max:255',
            'fields.suffix' => 'string|max:10',
            'fields.sex' => 'required|string|max:1',
            'fields.dob' => 'required|date',
            'fields.age' => 'required|integer|min:0|max:150',
            'fields.civil_status' => 'required|string|max:20',
            'fields.religion' => 'required|string|max:50',
            'fields.other_religion' => 'string|max:50',
            'fields.contact' => 'required|string|max:20',
            'fields.province_id' => 'required|integer',
            'fields.muncity_id' => 'required|integer',
            'fields.barangay_id' => 'required|integer',
            'fields.street' => 'string|max:255',
            'fields.purok' => 'string|max:255',
            'fields.sitio' => 'string|max:255',
            'fields.phic_id' => 'string|max:20',
            'fields.pwd_id' => 'string|max:20',
            'fields.citizenship' => 'required|string|max:50',
            'fields.other_citizenship' => 'string|max:50',
            'fields.indigenous_person' => 'required|string|max:8',
            'fields.employment_status' => 'required|string|max:50',
            'fields.facility_id_updated' => 'required|integer',
            'fields.offline_entry' => 'boolean',
        ];
    
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        // Offline entry check
        if (empty($fields['offline_entry']) || $fields['offline_entry'] == false) {
            if (!empty($fields['profile_id'])) {
                return response()->json(['error' => 'Malformed parameter. Please recheck request.'], 403);
            }
        }
    
        // Check for duplicates
        $existingRiskProfile = RiskProfile::where('profile_id', $fields['profile_id'])
            ->where('fname', $fields['fname'])
            ->where('lname', $fields['lname'])
            ->where('mname', $fields['mname'] ? $fields['mname'] : null)
            ->where('dob', $fields['dob'])
            ->first();
    
        if ($existingRiskProfile) {
            return response()->json(['error' => 'Duplicate in entered data. Please recheck.'], 409);
        }
    
        // Save the record
        try {
            $riskProfile = new RiskProfile($fields);
            $riskProfile->save();
    
            return response()->json([
                'message' => 'Entry successfully saved.',
                'id' => $riskProfile->id
            ], 200);
        } catch (Exception $e) {
            // Log the exception for debugging
            \Log::error('RiskProfile saving failed: ' . $e->getMessage());
    
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
        }
    }
    

    public function addRiskForm(Request $request)
    {
        $fields = $request->input('fields');
    
        // Check authentication if user is logged in
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Define validation rules
        $rules = [
            'fields' => 'required|array',
            'fields.risk_profile_id' => 'integer',
    
            // ar
            'fields.ar_chest_pain' => 'required|string|max:8',
            'fields.ar_difficulty_breathing' => 'required|string|max:8',
            'fields.ar_loss_of_consciousness' => 'required|string|max:8',
            'fields.ar_slurred_speech' => 'required|string|max:8',
            'fields.ar_facial_asymmetry' => 'required|string|max:8',
            'fields.ar_weakness_numbness' => 'required|string|max:8',
            'fields.ar_disoriented' => 'required|string|max:8',
            'fields.ar_chest_retractions' => 'required|string|max:8',
            'fields.ar_seizure_convulsion' => 'required|string|max:8',
            'fields.ar_act_self_harm_suicide' => 'required|string|max:8',
            'fields.ar_agitated_behavior' => 'required|string|max:8',
            'fields.ar_eye_injury' => 'required|string|max:8',
            'fields.ar_severe_injuries' => 'required|string|max:8',
            'fields.ar_refer_physician_name' => 'string|max:255',
            'fields.ar_refer_reason' => 'string|max:255',
            'fields.ar_refer_facility' => 'string|max:255',
    
            // pmh
            'fields.pmh_hypertension' => 'required|string|max:8',
            'fields.pmh_heart_disease' => 'required|string|max:8',
            'fields.pmh_diabetes' => 'required|string|max:8',
            'fields.pmh_specify_diabetes' => 'string|max:255',
            'fields.pmh_cancer' => 'required|string|max:8',
            'fields.pmh_specify_cancer' => 'string|max:255',
            'fields.pmh_copd' => 'required|string|max:8',
            'fields.pmh_asthma' => 'required|string|max:8',
            'fields.pmh_allergies' => 'required|string|max:8',
            'fields.pmh_specify_allergies' => 'string|max:255',
            'fields.pmh_mn_and_s_disorder' => 'required|string|max:8',
            'fields.pmh_specify_mn_and_s_disorder' => 'string|max:255',
            'fields.pmh_vision_problems' => 'required|string|max:8',
            'fields.pmh_previous_surgical' => 'required|string|max:8',
            'fields.pmh_specify_previous_surgical' => 'string|max:255',
            'fields.pmh_thyroid_disorders' => 'required|string|max:8',
            'fields.pmh_kidney_disorders' => 'required|string|max:8',
    
            // fmh
            'fields.fmh_hypertension' => 'required|string|max:20',
            'fields.fmh_stroke' => 'required|string|max:20',
            'fields.fmh_heart_disease' => 'required|string|max:20',
            'fields.fmh_diabetes_mellitus' => 'required|string|max:20',
            'fields.fmh_asthma' => 'required|string|max:20',
            'fields.fmh_cancer' => 'required|string|max:20',
            'fields.fmh_kidney_disease' => 'required|string|max:20',
            'fields.fmh_first_degree_relative' => 'required|string|max:20',
            'fields.fmh_having_tuberculosis_5_years' => 'required|string|max:20',
            'fields.fmh_mn_and_s_disorder' => 'required|string|max:20',
            'fields.fmh_copd' => 'required|string|max:20',
    
            // rf
            'fields.rf_tobacco_use' => 'required|string|max:255',
            'fields.rf_alcohol_intake' => 'required|string|max:8',
            'fields.rf_alcohol_binge_drinker' => 'required|string|max:8',
            'fields.rf_physical_activity' => 'required|string|max:8',
            'fields.rf_nutrition_dietary' => 'required|string|max:8',
            'fields.rf_weight' => 'required|numeric',
            'fields.rf_height' => 'required|numeric',
            'fields.rf_body_mass' => 'required|numeric',
            'fields.rf_waist_circumference' => 'required|numeric',
    
            // rs
            'fields.rs_systolic_t1' => 'required|numeric',
            'fields.rs_diastolic_t1' => 'required|numeric',
            'fields.rs_systolic_t2' => 'required|numeric',
            'fields.rs_diastolic_t2' => 'required|numeric',
            'fields.rs_blood_sugar_fbs' => 'numeric',
            'fields.rs_blood_sugar_rbs' => 'numeric',
            'fields.rs_blood_sugar_date_taken' => 'date',
            'fields.rs_blood_sugar_symptoms' => 'string|max:255',
            'fields.rs_lipid_cholesterol' => 'numeric',
            'fields.rs_lipid_hdl' => 'numeric',
            'fields.rs_lipid_ldl' => 'numeric',
            'fields.rs_lipid_vldl' => 'numeric',
            'fields.rs_lipid_triglyceride' => 'numeric',
            'fields.rs_lipid_date_taken' => 'date',
            'fields.rs_urine_protein' => 'numeric',
            'fields.rs_urine_protein_date_taken' => 'date',
            'fields.rs_urine_ketones' => 'numeric',
            'fields.rs_urine_ketones_date_taken' => 'date',
            'fields.rs_chronic_respiratory_disease' => 'string|max:255',
            'fields.rs_if_yes_any_symptoms' => 'string|max:255',
    
            // mngm
            'fields.mngm_med_hypertension' => 'string|max:8',
            'fields.mngm_med_hypertension_specify' => 'string|max:255',
            'fields.mngm_med_diabetes' => 'string|max:8',
            'fields.mngm_med_diabetes_options' => 'string|max:50',
            'fields.mngm_med_diabetes_specify' => 'string|max:255',
            'fields.mngm_date_follow_up' => 'date',
            'fields.mngm_remarks' => 'string|max:255',
    
            // offline entry field
            'fields.offline_entry' => 'required|boolean',
        ];
    
        // Validate the request
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
    
        try {
            $riskform = new RiskFormAssessment();
    
            // Dynamically populate the model with validated data
            foreach ($fields as $key => $value) {
                if (Schema::hasColumn($riskform->getTable(), $key)) {
                    $riskform->$key = $value;
                }
            }
    
            // Save the data
            $riskform->save();
    
            return response()->json(['message' => 'Entry successfully saved.'], 200);
        } catch (Exception $e) {
            // Log the error for debugging
            \Log::error('Error saving RiskFormAssessment: ' . $e->getMessage(), ['trace' => $e->getTrace()]);
    
            return response()->json(['error' => 'Something went wrong. Please try again later.'], 500);
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
            'fields' => 'required|array',
            'fields.profile_id' => 'integer',
            'fields.lname' => 'required|string|max:255',
            'fields.fname' => 'required|string|max:255',
            'fields.mname' => 'string|max:255',
            'fields.suffix' => 'string|max:10',
            'fields.sex' => 'required|string|max:1',
            'fields.dob' => 'required|date',
            'fields.age' => 'required|integer|min:0|max:150',
            'fields.civil_status' => 'required|string|max:20',
            'fields.religion' => 'required|string|max:50',
            'fields.other_religion' => 'string|max:50',
            'fields.contact' => 'required|string|max:20',
            'fields.province_id' => 'required|integer',
            'fields.muncity_id' => 'required|integer',
            'fields.barangay_id' => 'required|integer',
            'fields.street' => 'string|max:255',
            'fields.purok' => 'string|max:255',
            'fields.sitio' => 'string|max:255',
            'fields.phic_id' => 'string|max:20',
            'fields.pwd_id' => 'string|max:20',
            'fields.citizenship' => 'required|string|max:50',
            'fields.other_citizenship' => 'string|max:50',
            'fields.indigenous_person' => 'required|string|max:8',
            'fields.employment_status' => 'required|string|max:50',
            'fields.facility_id_updated' => 'required|integer',
            'fields.offline_entry' => 'boolean',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

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
            'fields.risk_profile_id' => 'integer',
            // ar
            'fields.ar_chest_pain' => 'required|string|max:8',
            'fields.ar_difficulty_breathing' => 'required|string|max:8',
            'fields.ar_loss_of_consciousness' => 'required|string|max:8',
            'fields.ar_slurred_speech' => 'required|string|max:8',
            'fields.ar_facial_asymmetry' => 'required|string|max:8',
            'fields.ar_weakness_numbness' => 'required|string|max:8',
            'fields.ar_disoriented' => 'required|string|max:8',
            'fields.ar_chest_retractions' => 'required|string|max:8',
            'fields.ar_seizure_convulsion' => 'required|string|max:8',
            'fields.ar_act_self_harm_suicide' => 'required|string|max:8',
            'fields.ar_agitated_behavior' => 'required|string|max:8',
            'fields.ar_eye_injury' => 'required|string|max:8',
            'fields.ar_severe_injuries' => 'required|string|max:8',
            'fields.ar_refer_physician_name' => 'string|max:255',
            'fields.ar_refer_reason' => 'string|max:255',
            'fields.ar_refer_facility' => 'string|max:255',

            // pmh
            'fields.pmh_hypertension' => 'required|string|max:8',
            'fields.pmh_heart_disease' => 'required|string|max:8',
            'fields.pmh_diabetes' => 'required|string|max:8',
            'fields.pmh_specify_diabetes' => 'string|max:255',
            'fields.pmh_cancer' => 'required|string|max:8',
            'fields.pmh_specify_cancer' => 'string|max:255',
            'fields.pmh_copd' => 'required|string|max:8',
            'fields.pmh_asthma' => 'required|string|max:8',
            'fields.pmh_allergies' => 'required|string|max:8',
            'fields.pmh_specify_allergies' => 'string|max:255',
            'fields.pmh_mn_and_s_disorder' => 'required|string|max:8',
            'fields.pmh_specify_mn_and_s_disorder' => 'string|max:255',
            'fields.pmh_vision_problems' => 'required|string|max:8',
            'fields.pmh_previous_surgical' => 'required|string|max:8',
            'fields.pmh_specify_previous_surgical' => 'string|max:255',
            'fields.pmh_thyroid_disorders' => 'required|string|max:8',
            'fields.pmh_kidney_disorders' => 'required|string|max:8',

            // fmh
            'fields.fmh_hypertension' => 'required|string|max:20',
            'fields.fmh_stroke' => 'required|string|max:20',
            'fields.fmh_heart_disease' => 'required|string|max:20',
            'fields.fmh_diabetes_mellitus' => 'required|string|max:20',
            'fields.fmh_asthma' => 'required|string|max:20',
            'fields.fmh_cancer' => 'required|string|max:20',
            'fields.fmh_kidney_disease' => 'required|string|max:20',
            'fields.fmh_first_degree_relative' => 'required|string|max:20',
            'fields.fmh_having_tuberculosis_5_years' => 'required|string|max:20',
            'fields.fmh_mn_and_s_disorder' => 'required|string|max:20',
            'fields.fmh_copd' => 'required|string|max:20',

            // rf
            'fields.rf_tobacco_use' => 'required|string|max:255',
            'fields.rf_alcohol_intake' => 'required|string|max:8',
            'fields.rf_alcohol_binge_drinker' => 'required|string|max:8',
            'fields.rf_physical_activity' => 'required|string|max:8',
            'fields.rf_nutrition_dietary' => 'required|string|max:8',
            'fields.rf_weight' => 'required|numeric',
            'fields.rf_height' => 'required|numeric',
            'fields.rf_body_mass' => 'required|numeric',
            'fields.rf_waist_circumference' => 'required|numeric',

            // rs
            'fields.rs_systolic_t1' => 'required|numeric',
            'fields.rs_diastolic_t1' => 'required|numeric',
            'fields.rs_systolic_t2' => 'required|numeric',
            'fields.rs_diastolic_t2' => 'required|numeric',
            'fields.rs_blood_sugar_fbs' => 'required|numeric',
            'fields.rs_blood_sugar_rbs' => 'required|numeric',
            'fields.rs_blood_sugar_date_taken' => 'required|date',
            'fields.rs_blood_sugar_symptoms' => 'required|string|max:255',
            'fields.rs_lipid_cholesterol' => 'required|numeric',
            'fields.rs_lipid_hdl' => 'required|numeric',
            'fields.rs_lipid_ldl' => 'required|numeric',
            'fields.rs_lipid_vldl' => 'required|numeric',
            'fields.rs_lipid_triglyceride' => 'required|numeric',
            'fields.rs_lipid_date_taken' => 'required|date',
            'fields.rs_urine_protein' => 'required|numeric',
            'fields.rs_urine_protein_date_taken' => 'date',
            'fields.rs_urine_ketones' => 'required|numeric',
            'fields.rs_urine_ketones_date_taken' => 'date',
            'fields.rs_chronic_respiratory_disease' => 'required|string|max:255',
            'fields.rs_if_yes_any_symptoms' => 'required|string|max:255',

            //mngm
            'fields.mngm_med_hypertension' => 'required|string|max:8',
            'fields.mngm_med_hypertension_specify' => 'string|max:255',
            'fields.mngm_med_diabetes' => 'required|string|max:8',
            'fields.mngm_med_diabetes_options' => 'string|max:50',
            'fields.mngm_med_diabetes_specify' => 'string|max:255',
            'fields.mngm_date_follow_up' => 'required|date',
            'fields.mngm_remarks' => 'string|max:255',

            // offline entry field
            'fields.offline_entry' => 'required|boolean'
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Find the existing RiskFormAssessment
        $riskform = RiskFormAssessment::where('risk_profile_id', $fields['risk_profile_id'])->first();

        if (!$riskform) {
            return response()->json(['error' => 'Risk form not found.'], 404);
        }

        try {
            // Update the RiskFormAssessment with new data
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
            $riskForm = RiskFormAssessment::where('risk_profile_id', $riskProfileId)->first();

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
