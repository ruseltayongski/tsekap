<?php

namespace App\Http\Controllers\risk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Barangay;
use App\Muncity;
use App\RiskProfile;
use App\RiskFormAssessment;

class RiskProfileController extends Controller
{
    public function getMunicipal($provinceid)
    {
        $muncity = Muncity::where('province_id', $provinceid)
            ->select('id', 'province_id', 'description')
            ->get();
        return response()->json($muncity);
    }

    public function getBarangay($muncity_id)
    {
        $barangay = Barangay::where('muncity_id', $muncity_id)
            ->select('id', 'muncity_id', 'description')
            ->get();
        return response()->json($barangay);
    }

    public function SubmitRiskPForm(Request $request)
    {
        $user = Auth::user();

        // Check for duplicate in the RiskProfile table
        $existingRiskProfile = RiskProfile::where('profile_id', $request->profile_id)
            ->where('fname', $request->fname)
            ->where('lname', $request->lname)
            ->where('mname', $request->mname)
            ->where('dob', $request->dob)
            ->first();

        if ($existingRiskProfile) {
            // Redirect with an error message if a duplicate is found
            return redirect()->back()->with('error', 'Duplicate risk profile exists with the same data.');
        }

        $riskprofile = new RiskProfile();

        // Assign all the necessary values
        $riskprofile->profile_id = $request->profile_id ? $request->profile_id : null;
        $riskprofile->lname = $request->lname;
        $riskprofile->fname = $request->fname;
        $riskprofile->mname = $request->mname ? $request->mname : null;
        $riskprofile->suffix = $request->suffix ? $request->suffix : null;
        $riskprofile->sex = $request->sex;
        $riskprofile->dob = $request->dob;
        $riskprofile->age = $request->age;
        $riskprofile->civil_status = $request->civil_status;
        $riskprofile->religion = $request->religion;
        $riskprofile->other_religion = $request->other_religion ? $request->other_religion : null;
        $riskprofile->contact = $request->contact;
        $riskprofile->province_id = $request->province;
        $riskprofile->municipal_id = $request->municipal;
        $riskprofile->barangay_id = $request->barangay;
        $riskprofile->street = $request->street ? $request->street : null;
        $riskprofile->purok = $request->purok ? $request->purok : null;
        $riskprofile->sitio = $request->sitio ? $request->sitio : null;
        $riskprofile->phic_id = $request->phic_id ? $request->phic_id : null; // Ensure you use the correct field name here
        $riskprofile->pwd_id = $request->pwd_id ? $request->pwd_id : null;
        $riskprofile->citizenship = $request->citizenship;
        $riskprofile->other_citizenship = $request->other_citizenship ? $request->other_citizenship : null;
        $riskprofile->indigenous_person = $request->indigenous_person;
        $riskprofile->employment_status = $request->employment_status;
        $riskprofile->facility_id_updated = $request->facility_id_updated; // Ensure this is not null
        $riskprofile->encoded_by = $request->encoded_by;
        $riskprofile->offline_entry = false;

        // Save the profile
        $riskprofile->save();
        $riskform = new RiskFormAssessment();

        // Health assessment checkbox fields
        $riskform->risk_profile_id = $riskprofile->id;
        $riskform->ar_chest_pain = $request->input('ar_chest_pain', 'No');
        $riskform->ar_difficulty_breathing = $request->input('ar_difficulty_breathing', 'No');
        $riskform->ar_loss_of_consciousness = $request->input('ar_loss_of_consciousness', 'No');
        $riskform->ar_slurred_speech = $request->input('ar_slurred_speech', 'No');
        $riskform->ar_facial_asymmetry = $request->input('ar_facial_asymmetry', 'No');
        $riskform->ar_weakness_numbness = $request->input('ar_weakness_numbness', 'No');
        $riskform->ar_disoriented = $request->input('ar_disoriented', 'No');
        $riskform->ar_chest_retractions = $request->input('ar_chest_retractions', 'No');
        $riskform->ar_seizure_convulsion = $request->input('ar_seizure_convulsion', 'No');
        $riskform->ar_act_self_harm_suicide = $request->input('ar_act_self_harm_suicide', 'No');
        $riskform->ar_agitated_behavior = $request->input('ar_agitated_behavior', 'No');
        $riskform->ar_eye_injury = $request->input('ar_eye_injury', 'No');
        $riskform->ar_severe_injuries = $request->input('ar_severe_injuries', 'No');
        $riskform->ar_refer_physician_name = $request->input('ar_refer_physician_name');
        $riskform->ar_refer_reason = $request->input('ar_refer_reason');
        $riskform->ar_refer_facility = $request->input('ar_refer_facility');

        //PAST MEDICAL HISTORY 
        $riskform->pmh_hypertension = $request->input('pmh_hypertension', 'No');
        $riskform->pmh_heart_disease = $request->input('pmh_heart_disease', 'No');
        $riskform->pmh_diabetes = $request->input('pmh_diabetes', 'No');
        $riskform->pmh_specify_diabetes = $request->input('pmh_diabetes_details', '');
        $riskform->pmh_cancer = $request->input('pmh_cancer', 'No');
        $riskform->pmh_specify_cancer = $request->input('pmh_cancer_details', '');
        $riskform->pmh_copd = $request->input('pmh_COPD', 'No');
        $riskform->pmh_asthma = $request->input('pmh_asthma', 'No');
        $riskform->pmh_allergies = $request->input('pmh_allergies', 'No');
        $riskform->pmh_specify_allergies = $request->input('pmh_allergies_details', '');
        $riskform->pmh_mn_and_s_disorder = $request->input('pmh_mnsad', 'No');
        $riskform->pmh_specify_mn_and_s_disorder = $request->input('pmh_mnsad_details', '');
        $riskform->pmh_vision_problems = $request->input('pmh_vision', 'No');
        $riskform->pmh_previous_surgical = $request->input('pmh_psh', 'No');
        $riskform->pmh_specify_previous_surgical = $request->input('pmh_psh_details', 'No');
        $riskform->pmh_thyroid_disorders = $request->input('pmh_thyroid', 'No');
        $riskform->pmh_kidney_disorders = $request->input('pmh_kidney', 'No');

        //FAMILY HISTORY
        //$riskform->fmh_side_hypertension = $request->input('fmh_side_hypertension','No');
        $riskform->fmh_stroke = $request->input('fmh_stroke', 'No');
        $riskform->fmh_heart_disease = $request->input('fmh_heart_disease', 'No');
        $riskform->fmh_diabetes_mellitus = $request->input('fmh_diabetes_mellitus', 'No');
        $riskform->fmh_asthma = $request->input('fmh_asthma', 'No');
        $riskform->fmh_cancer = $request->input('fmh_cancer', 'No');
        $riskform->fmh_kidney_disease = $request->input('fmh_kidney', 'No');
        $riskform->fmh_first_degree_relative = $request->input('fmh_first_degree', 'No');
        $riskform->fmh_having_tuberculosis_5_years = $request->input('fmh_famtb', 'No');
        $riskform->fmh_mn_and_s_disorder = $request->input('fmh_mnsad', 'No');
        $riskform->fmh_copd = $request->input('fmh_copd', 'No');

        // NCD RISK FACTORS 
        $tobaccoUsed = $request->input('tobaccoUse', []);
        $tobaccoUseLimited = array_slice($tobaccoUsed, 0, 2);
        $riskform->rf_tobacco_use = implode(', ', $tobaccoUseLimited);
        $riskform->rf_alcohol_intake = $request->input('ncd_alcohol', 'No');
        $riskform->rf_alcohol_binge_drinker = $request->input('ncd_alcohol_binge', 'No');
        $riskform->rf_physical_activity = $request->input('ncd_physical', 'No');
        $riskform->rf_nutrition_dietary = $request->input('ncd_nutrition', 'No');
        $riskform->rf_weight = $request->input('rf_weight', '');
        $riskform->rf_height = $request->input('rf_height', '');
        $riskform->rf_body_mass = $request->input('rf_bmi', '');
        $riskform->rf_waist_circumference = $request->input('rf_waist', '');

        //RISK SCREENING
        // Hypertension/Diabetes/Hypercholestrolemia/Renal Diseases

        $dmSymptoms = $request->input('dm_symptoms', []);

        $riskform->rs_systolic_t1 = $request->input('systolic_t1', ' ');
        $riskform->rs_diastolic_t1 = $request->input('diastolic_t1', ' ');
        $riskform->rs_systolic_t2 = $request->input('systolic_t2', ' ');
        $riskform->rs_diastolic_t2 = $request->input('diastolic_t2', ' ');
        $riskform->rs_blood_sugar_fbs = $request->input('fbs_result', ' ');
        $riskform->rs_blood_sugar_rbs = $request->input('rbs_result', ' ');
        $riskform->rs_blood_sugar_date_taken = $request->input('blood_sugar_date_taken', '');
        $riskform->rs_blood_sugar_symptoms = implode(', ', $dmSymptoms);
        $riskform->rs_lipid_cholesterol = $request->input('lipid_cholesterol', '');
        $riskform->rs_lipid_hdl = $request->input('lipid_hdl', '');
        $riskform->rs_lipid_ldl = $request->input('lipid_ldl', '');
        $riskform->rs_lipid_vldl = $request->input('lipid_vldl', '');
        $riskform->rs_lipid_triglyceride = $request->input('lipid_triglyceride', '');
        $riskform->rs_lipid_date_taken = $request->input('lipid_date_taken', date('Y-m-d'));
        $riskform->rs_urine_protein = $request->input('uri_protein', '');
        $riskform->rs_urine_protein_date_taken = $request->input('uri_protein_date_taken', date('Y-m-d'));
        $riskform->rs_urine_ketones = $request->input('uri_ketones', '');
        $riskform->rs_urine_ketones_date_taken = $request->input('uri_ketones_date_taken', date('Y-m-d'));

        $symptoms = [];

        // Check each checkbox and add the label to the array if selected
        if ($request->has('symptom_breathlessness')) {
            $symptoms[] = 'Breathlessness';
        }
        if ($request->has('symptom_sputum_production')) {
            $symptoms[] = 'Sputum (mucous) production';
        }
        if ($request->has('symptom_chronic_cough')) {
            $symptoms[] = 'Chronic cough';
        }
        if ($request->has('symptom_chest_tightness')) {
            $symptoms[] = 'Chest tightness';
        }
        if ($request->has('symptom_wheezing')) {
            $symptoms[] = 'Wheezing';
        }

        // Convert the array into a comma-separated string
        $riskform->rs_chronic_respiratory_disease = implode(', ', $symptoms);  // Store as a string

        // For PEFR checkboxes, similarly store the selected labels as a comma-separated string
        $pefr = [];
        if ($request->has('pefr_above_20_percent')) {
            $pefr[] = '20% change from baseline (consider Probable Asthma)';
        }
        if ($request->has('pefr_below_20_percent')) {
            $pefr[] = '20% change from baseline (consider Probable COPD)';
        }

        // Convert the array into a comma-separated string for PEFR
        $riskform->rs_if_yes_any_symptoms = implode(', ', $pefr);  // Store as a string
        // Anti-Hypertensives: Store selected option and any specify text
        $riskform->mngm_med_hypertension = $request->input('anti_hypertensives');
        $riskform->mngm_med_hypertension_specify = $request->input('anti_hypertensives_specify');

        // Anti-Diabetes: Store selected option and any specify text, and type
        $riskform->mngm_med_diabetes = $request->input('anti_diabetes');
        $riskform->mngm_med_diabetes_options = $request->input('anti_diabetes_type');
        $riskform->mngm_med_diabetes_specify = $request->input('anti_diabetes_specify');

        // Follow-up Date
        $riskform->mngm_date_follow_up = $request->input('follow_up_date');

        // Remarks (Text area)
        $riskform->mngm_remarks = $request->input('remarks');
        $riskform->offline_entry = false;

        // Save the data
        $riskform->save();
        // Redirect after saving
        return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');
    }

    public function updateRiskPForm(Request $req, $id)
    {
        $user = Auth::user();

        // Retrieve the existing risk profile by ID
        $riskprofile = RiskProfile::find($id);

        if (!$riskprofile) {
            return redirect()->back()->with('error', 'Risk profile not found.');
        }

        // Check for duplicates in the RiskProfile table (excluding the current record)
        $existingRiskProfile = RiskProfile::where('fname', $req->fname)
            ->where('lname', $req->lname)
            ->where('mname', $req->mname)
            ->where('dob', $req->dob)
            ->where('id', '!=', $id) // Exclude the current record
            ->first();

        if ($existingRiskProfile) {
            return redirect()->back()->with('error', 'Duplicate risk profile exists with the same data.');
        }

        // Update the RiskProfile data
        $riskprofile->profile_id = $req->profile_id ? $req->profile_id : null;
        $riskprofile->lname = $req->lname;
        $riskprofile->fname = $req->fname;
        $riskprofile->mname = $req->mname ? $req->mname : null;
        $riskprofile->suffix = $req->suffix ? $req->suffix : null;
        $riskprofile->sex = $req->sex;
        $riskprofile->dob = $req->dob;
        $riskprofile->age = $req->age;
        $riskprofile->civil_status = $req->civil_status;
        $riskprofile->religion = $req->religion;
        $riskprofile->other_religion = $req->other_religion ? $req->other_religion : null;
        $riskprofile->contact = $req->contact;
        $riskprofile->province_id = $req->province;
        $riskprofile->municipal_id = $req->municipal;
        $riskprofile->barangay_id = $req->barangay;
        $riskprofile->street = $req->street ? $req->street : null;
        $riskprofile->purok = $req->purok ? $req->purok : null;
        $riskprofile->sitio = $req->sitio ? $req->sitio : null;
        $riskprofile->phic_id = $req->phic_id ? $req->phic_id : null;
        $riskprofile->pwd_id = $req->pwd_id ? $req->pwd_id : null;
        $riskprofile->citizenship = $req->citizenship;
        $riskprofile->other_citizenship = $req->other_citizenship ? $req->other_citizenship : null;
        $riskprofile->indigenous_person = $req->indigenous_person;
        $riskprofile->employment_status = $req->employment_status;
        $riskprofile->facility_id_updated = $req->facility_id_updated; // Ensure this is not null
        $riskprofile->encoded_by = $req->encoded_by;

        $riskprofile->offline_entry = false;
        
        // Save the updated RiskProfile
        $riskprofile->save();

        // Retrieve the associated RiskFormAssessment
        $riskform = RiskFormAssessment::where('risk_profile_id', $id)->first();

        if (!$riskform) {
            return redirect()->back()->with('error', 'Associated risk form not found.');
        }

        // Update the RiskFormAssessment data
        $riskform->ar_chest_pain = $req->input('ar_chest_pain', 'No');
        $riskform->ar_difficulty_breathing = $req->input('ar_difficulty_breathing', 'No');
        // (Repeat for all fields in RiskFormAssessment...)
        $riskform->ar_chest_pain = $req->input('ar_chest_pain', 'No');
        $riskform->ar_difficulty_breathing = $req->input('ar_difficulty_breathing', 'No');
        $riskform->ar_loss_of_consciousness = $req->input('ar_loss_of_consciousness', 'No');
        $riskform->ar_slurred_speech = $req->input('ar_slurred_speech', 'No');
        $riskform->ar_facial_asymmetry = $req->input('ar_facial_asymmetry', 'No');
        $riskform->ar_weakness_numbness = $req->input('ar_weakness_numbness', 'No');
        $riskform->ar_disoriented = $req->input('ar_disoriented', 'No');
        $riskform->ar_chest_retractions = $req->input('ar_chest_retractions', 'No');
        $riskform->ar_seizure_convulsion = $req->input('ar_seizure_convulsion', 'No');
        $riskform->ar_act_self_harm_suicide = $req->input('ar_act_self_harm_suicide', 'No');
        $riskform->ar_agitated_behavior = $req->input('ar_agitated_behavior', 'No');
        $riskform->ar_eye_injury = $req->input('ar_eye_injury', 'No');
        $riskform->ar_severe_injuries = $req->input('ar_severe_injuries', 'No');
        $riskform->ar_refer_physician_name = $req->input('ar_refer_physician_name');
        $riskform->ar_refer_reason = $req->input('ar_refer_reason');
        $riskform->ar_refer_facility = $req->input('ar_refer_facility');

        //PAST MEDICAL HISTORY 
        $riskform->pmh_hypertension = $req->input('pmh_hypertension', 'No');
        $riskform->pmh_heart_disease = $req->input('pmh_heart_disease', 'No');
        $riskform->pmh_diabetes = $req->input('pmh_diabetes', 'No');
        $riskform->pmh_specify_diabetes = $req->input('pmh_diabetes_details', '');
        $riskform->pmh_cancer = $req->input('pmh_cancer', 'No');
        $riskform->pmh_specify_cancer = $req->input('pmh_cancer_details', '');
        $riskform->pmh_copd = $req->input('pmh_COPD', 'No');
        $riskform->pmh_asthma = $req->input('pmh_asthma', 'No');
        $riskform->pmh_allergies = $req->input('pmh_allergies', 'No');
        $riskform->pmh_specify_allergies = $req->input('pmh_allergies_details', '');
        $riskform->pmh_mn_and_s_disorder = $req->input('pmh_mnsad', 'No');
        $riskform->pmh_specify_mn_and_s_disorder = $req->input('pmh_mnsad_details', '');
        $riskform->pmh_vision_problems = $req->input('pmh_vision', 'No');
        $riskform->pmh_previous_surgical = $req->input('pmh_psh', 'No');
        $riskform->pmh_specify_previous_surgical = $req->input('pmh_psh_details', 'No');
        $riskform->pmh_thyroid_disorders = $req->input('pmh_thyroid', 'No');
        $riskform->pmh_kidney_disorders = $req->input('pmh_kidney', 'No');

        //FAMILY HISTORY
        $riskform->fmh_side_hypertension = $req->input('fmh_side_hypertension', 'No');
        $riskform->fmh_stroke = $req->input('fmh_stroke', 'No');
        $riskform->fmh_heart_disease = $req->input('fmh_heart_disease', 'No');
        $riskform->fmh_diabetes_mellitus = $req->input('fmh_diabetes_mellitus', 'No');
        $riskform->fmh_asthma = $req->input('fmh_asthma', 'No');
        $riskform->fmh_cancer = $req->input('fmh_cancer', 'No');
        $riskform->fmh_kidney_disease = $req->input('fmh_kidney', 'No');
        $riskform->fmh_first_degree_relative = $req->input('fmh_first_degree', 'No');
        $riskform->fmh_having_tuberculosis_5_years = $req->input('fmh_famtb', 'No');
        $riskform->fmh_mn_and_s_disorder = $req->input('fmh_mnsad', 'No');
        $riskform->fmh_copd = $req->input('fmh_copd', 'No');

        // NCD RISK FACTORS 
        $tobaccoUsed = $req->input('tobaccoUse', []);
        $tobaccoUseLimited = array_slice($tobaccoUsed, 0, 2);
        $riskform->rf_tobacco_use = implode(', ', $tobaccoUseLimited);
        $riskform->rf_alcohol_intake = $req->input('ncd_alcohol', 'No');
        $riskform->rf_alcohol_binge_drinker = $req->input('ncd_alcohol_binge', 'No');
        $riskform->rf_physical_activity = $req->input('ncd_physical', 'No');
        $riskform->rf_nutrition_dietary = $req->input('ncd_nutrition', 'No');
        $riskform->rf_weight = $req->input('rf_weight', '');
        $riskform->rf_height = $req->input('rf_height', '');
        $riskform->rf_body_mass = $req->input('rf_bmi', '');
        $riskform->rf_waist_circumference = $req->input('rf_waist', '');

        //RISK SCREENING
        // Hypertension/Diabetes/Hypercholestrolemia/Renal Diseases

        $dmSymptoms = $req->input('dm_symptoms', []);

        $riskform->rs_systolic_t1 = $req->input('systolic_t1', ' ');
        $riskform->rs_diastolic_t1 = $req->input('diastolic_t1', ' ');
        $riskform->rs_systolic_t2 = $req->input('systolic_t2', ' ');
        $riskform->rs_diastolic_t2 = $req->input('diastolic_t2', ' ');
        $riskform->rs_blood_sugar_fbs = $req->input('fbs_result', ' ');
        $riskform->rs_blood_sugar_rbs = $req->input('rbs_result', ' ');
        $riskform->rs_blood_sugar_date_taken = $req->input('blood_sugar_date_taken', '');
        $riskform->rs_blood_sugar_symptoms = implode(', ', $dmSymptoms);
        $riskform->rs_lipid_cholesterol = $req->input('lipid_cholesterol', '');
        $riskform->rs_lipid_hdl = $req->input('lipid_hdl', '');
        $riskform->rs_lipid_ldl = $req->input('lipid_ldl', '');
        $riskform->rs_lipid_vldl = $req->input('lipid_vldl', '');
        $riskform->rs_lipid_triglyceride = $req->input('lipid_triglyceride', '');
        $riskform->rs_lipid_date_taken = $req->input('lipid_date_taken', date('Y-m-d'));
        $riskform->rs_urine_protein = $req->input('uri_protein', '');
        $riskform->rs_urine_protein_date_taken = $req->input('uri_protein_date_taken', date('Y-m-d'));
        $riskform->rs_urine_ketones = $req->input('uri_ketones', '');
        $riskform->rs_urine_ketones_date_taken = $req->input('uri_ketones_date_taken', date('Y-m-d'));

        $symptoms = [];

        // Check each checkbox and add the label to the array if selected
        if ($req->has('symptom_breathlessness')) {
            $symptoms[] = 'Breathlessness';
        }
        if ($req->has('symptom_sputum_production')) {
            $symptoms[] = 'Sputum (mucous) production';
        }
        if ($req->has('symptom_chronic_cough')) {
            $symptoms[] = 'Chronic cough';
        }
        if ($req->has('symptom_chest_tightness')) {
            $symptoms[] = 'Chest tightness';
        }
        if ($req->has('symptom_wheezing')) {
            $symptoms[] = 'Wheezing';
        }

        // Convert the array into a comma-separated string
        $riskform->rs_chronic_respiratory_disease = implode(', ', $symptoms);  // Store as a string

        // For PEFR checkboxes, similarly store the selected labels as a comma-separated string
        $pefr = [];
        if ($req->has('pefr_above_20_percent')) {
            $pefr[] = '20% change from baseline (consider Probable Asthma)';
        }
        if ($req->has('pefr_below_20_percent')) {
            $pefr[] = '20% change from baseline (consider Probable COPD)';
        }

        // Convert the array into a comma-separated string for PEFR
        $riskform->rs_if_yes_any_symptoms = implode(', ', $pefr);  // Store as a string
        // Anti-Hypertensives: Store selected option and any specify text
        $riskform->mngm_med_hypertension = $req->input('anti_hypertensives');
        $riskform->mngm_med_hypertension_specify = $req->input('anti_hypertensives_specify');

        // Anti-Diabetes: Store selected option and any specify text, and type
        $riskform->mngm_med_diabetes = $req->input('anti_diabetes');
        $riskform->mngm_med_diabetes_options = $req->input('anti_diabetes_type');
        $riskform->mngm_med_diabetes_specify = $req->input('anti_diabetes_specify');

        // Follow-up Date
        $riskform->mngm_date_follow_up = $req->input('follow_up_date');

        // Remarks (Text area)
        $riskform->mngm_remarks = $req->input('remarks');
        $riskform->offline_entry = false;

        // Save the data
        $riskform->save();

        // Redirect after saving
        return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');
    }

    public function PatientRiskFormList(Request $requestuest)
    {
        $user = Auth::user();
        $keyword = $requestuest->input('keyword');

        $query = RiskProfile::select(
            'id',
            'fname',
            'mname',
            'lname',
            'dob',
            'sex',
            'civil_status',
            'barangay_id',
            'municipal_id',
            'province_id',
            'facility_id_updated',
            'created_at'
        )->with([
                    'facility' => function ($query) {
                        $query->select('id', 'name');
                    },
                    'province' => function ($query) {
                        $query->select('id', 'description');
                    },
                    'muncity' => function ($query) {
                        $query->select('id', 'province_id', 'description');
                    },
                    'barangay' => function ($query) {
                        $query->select('id', 'muncity_id', 'description');
                    },
                ])->orderBy('id', 'desc');

        if ($user->user_priv == 6) { // Facility view
            $this->applyFilters($query, $user, $keyword);
            $query->where('facility_id_updated', $user->facility_id);
        } elseif ($user->user_priv == 10) { // DSOs view
            $this->applyFilters($query, $user, $keyword);
            $query->where('facility_id_updated', $user->facility_id);
        } elseif ($user->user_priv == 7) { // Region view
            $this->applyFilters($query, $user, $keyword);
        } elseif ($user->user_priv == 3) { // Provincial view
            $this->applyFilters($query, $user, $keyword);
            $query->where('province_id', $user->province);
        } else {
            // Default empty pagination if no condition is met
            $query->where('id', 0);
        }

        $riskprofiles = $query->simplePaginate(15);

        if ($requestuest->ajax()) {
            return view('risk.riskprofilelist', compact('riskprofiles', 'user'))->render();
        }

        return view('risk.risklist', [
            'user_priv' => $user,
            'riskprofiles' => $riskprofiles,
        ]);
    }

    private function applyFilters($query, $user, $keyword)
    {
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
    }

    public function destroy($id)
    {
        try {
            // Find the profile by ID
            $profile = RiskProfile::findOrFail($id);

            // Delete the profile
            $profile->delete();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Risk profile deleted successfully!');
        } catch (\Exception $e) {
            // Handle error and redirect back with an error message
            return redirect()->back()->with('error', 'Failed to delete risk profile: ' . $e->getMessage());
        }
    }
}