<?php
namespace App\Http\Controllers\risk;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facility;
use App\Barangay;
use App\Muncity;
use App\Province;
use App\RiskProfile;
use App\RiskFormAssesment;
use App\Profile;

class RiskProfileController extends Controller     
{
    //
    public function getMunicipal($provinceid){

      $muncity = Muncity::where('province_id', $provinceid)
        ->select('id','province_id','description')
        ->get(); 
        //63 is Cebu City Capital, 76 is Lapu-Lapu City, Mandaue City
      
      return response()->json($muncity);
    }

    public function getBarangay($muncity_id){
        $barangay = Barangay::where('muncity_id',$muncity_id)
            ->select('id','muncity_id','description')
            ->get();
        return response()->json($barangay);
    }

    public function SubmitRiskPForm(Request $req)
    {
        $user = Auth::user();

        $facilities = Facility::all();
        $facility = Facility::select('id','name','address','hospital_type')
        ->where('id', $user->facility_id)    
        ->get();
        $facilities = null;

        foreach($facility as $fact){
            $facilities = $fact;
        }

          // Define the fields to check for duplication
        $duplicateCheck = [
            'fname' => $req->fname,
            'lname' => $req->lname,
            'mname' => $req->mname,
            'dob' => $req->dateofbirth
        ];

        // Check for duplicate in the RiskProfile table
        $existingRiskProfile = RiskProfile::where($duplicateCheck)->first();

        if ($existingRiskProfile) {
        // Redirect with an error message if a duplicate is found
            return redirect()->back()->with('error', 'Duplicate risk profile exists with the same data.');
        }

        $riskprofile = new RiskProfile();

        // Assign all the necessary values
        $riskprofile->profile_id = $req->profile_id? $req->profile_id : null;
        $riskprofile->fname = $req->fname;
        $riskprofile->mname = $req->mname? $req->mname : null ;
        $riskprofile->lname = $req->lname;
        $riskprofile->suffix = $req->suffix? $req->suffix : null;
        $riskprofile->sex = $req->sex;
        $riskprofile->dob = $req->dateofbirth;
        $riskprofile->age = $req->age;
        $riskprofile->province_id = $req->province;
        $riskprofile->municipal_id = $req->municipal;
        $riskprofile->barangay_id = $req->barangay;
        $riskprofile->sitio = $req->sitio? $req->sitio : null;
        $riskprofile->street = $req->street? $req->street : null;
        $riskprofile->purok = $req->purok? $req->purok : null;
        $riskprofile->phic_id = $req->phic_id? $req->phic_id : null; // Ensure you use the correct field name here
        $riskprofile->civil_status = $req->civil_status;
        $riskprofile->religion = $req->religion;
        $riskprofile->other_religion = $req->other_religion ? $req -> other_religion : null;
        $riskprofile->pwd_id = $req->pwd_id? $req->pwd_id : null;
        $riskprofile->ethnicity = $req->ethnicity;
        $riskprofile->other_ethnicity = $req -> other_ethnicity ? $req -> other_ethnicity : null;
        $riskprofile->indigenous_person = $req->indigenous_person;
        $riskprofile->employment_status = $req->employment_status;
        $riskprofile->facility_id_updated = $req->facility_id_updated; // Ensure this is not null
    
        // Save the profile
        $riskprofile->save();
        $riskform = new RiskFormAssesment();

        // Health assessment checkbox fields
        $riskform->risk_profile_id = $riskprofile->id;
        $riskform->ar_chestpain = $req->input('chest_pain', 'No');
        $riskform->ar_diffBreath = $req->input('difficulty_breathing', 'No');
        $riskform->ar_lossOfConsciousness = $req->input('loss_of_consciousness', 'No');
        $riskform->ar_slurredSpeech = $req->input('slurred_speech', 'No');
        $riskform->ar_facialAsymmetry = $req->input('facial_asymmetry', 'No');
        $riskform->ar_weaknessNumbness = $req->input('weakness_numbness', 'No');
        $riskform->ar_disoriented = $req->input('disoriented', 'No');
        $riskform->ar_chestRetraction = $req->input('chest_retractions', 'No');
        $riskform->ar_seizureConvulsion = $req->input('seizures', 'No');
        $riskform->ar_actSelfHarmSuicide = $req->input('self_harm', 'No');
        $riskform->ar_agitatedBehaivior = $req->input('agitated_behavior', 'No');
        $riskform->ar_eyeInjury = $req->input('eye_injury', 'No');
        $riskform->ar_severeInjuries = $req->input('severe_injuries', 'No');
        $riskform->ar_refer_physicianName = $req->input('physician_name');
        $riskform->ar_refer_reason = $req->input('reason');
        $riskform->ar_refer_facility = $req->input('facility');


        //PAST MEDICAL HISTORY 
        $riskform->pmh_hypertension = $req->input('pm_hypertension', 'No');
        $riskform->pmh_heartDisease = $req->input('pm_heartDisease', 'No');
        $riskform->pmh_diabetes = $req->input('pm_diabetes', 'No');
        $riskform->pmh_specify_diabetes = $req->input('pm_diabetes_details', '');
        $riskform->pmh_cancer = $req->input('pm_cancer', 'No');
        $riskform->pmh_specify_cancer = $req->input('pm_cancer_details', '');
        $riskform->pmh_COPD = $req->input('pm_COPD', 'No');
        $riskform->pmh_asthma = $req->input('pm_asthma', 'No');
        $riskform->pmh_allergies = $req->input('pm_allergies', 'No');
        $riskform->pmh_specify_allergies = $req->input('pm_allergies_details', '');
        $riskform->pmh_MNandSDisorder = $req->input('pm_mnsad', 'No');
        $riskform->pmh_specify_MNandSDisorder = $req->input('pm_mnsad_details', '');
        $riskform->pmh_visionProblems = $req->input('pm_vision', 'No');
        $riskform->pmh_previous_Surgical = $req->input('pm_psh', 'No');
        $riskform->pmh_thyroidDisorders = $req->input('pm_thyroid', 'No');
        $riskform->pmh_kidneyDisorders = $req->input('pm_kidney', 'No');
        
        //FAMILY HISTORY
        $riskform->fm_hypertension = $req->input('fm_hypertension','No');
        $riskform->fm_stroke = $req->input('fm_stroke','No');
        $riskform->fm_heartDisease = $req->input('fm_heart','No');
        $riskform->fm_diabetesMel = $req->input('fm_diabetes','No');
        $riskform->fm_asthma = $req->input('fm_asthma','No');
        $riskform->fm_cancer = $req->input('fm_cancer','No');
        $riskform->fm_kidneyDisease = $req->input('fm_kidney','No');
        $riskform->fm_firstDegreRelative = $req->input('fm_degree','No');
        $riskform->fm_havingTB5years = $req->input('fm_famtb','No');
        $riskform->fm_MNandSDisorder = $req->input('fm_mnsad','No');
        $riskform->fm_COPD = $req->input('fm_cop','No');

        // NCD RISK FACTORS 
        $tobaccoUsed = $req->input('tobaccoUse', []); 
        $tobaccoUseLimited = array_slice($tobaccoUsed, 0, 2); 
        $riskform->rf_tobbacoUse = implode(', ', $tobaccoUseLimited); 
        $riskform->rf_alcoholIntake = $req->input('ncd_alcohol', 'No'); 
        $riskform->rf_alcoholBingeDrinker = $req->input('ncd_alcoholBinge', 'No');
        $riskform->rf_physicalActivity = $req->input('ncd_physical', 'No'); 
        $riskform->rf_nutritionDietary = $req->input('ncd_nutrition', 'No'); 
        $riskform->rf_weight = $req->input('rf_weight', '');
        $riskform->rf_height = $req->input('rf_height', '');
        $riskform->rf_bodyMass = $req->input('rf_BMI', '');
        $riskform->rf_waistCircum = $req->input('rf_waist', '');
        $riskform->rf_bloodPressure = $req->input('rf_bloodPressure', '');

        //RISK SCREENING
        // Hypertension/Diabetes/Hypercholestrolemia/Renal Diseases

        $dmSymptoms = $req->input('dm_symptoms', []);

        $riskform->rs_bloodSugar_fbs = $req->input('fbs_result', ' ');
        $riskform->rs_bloodSugar_rbs = $req->input('rbs_result', ' ');
        $riskform->rs_bloodSugar_date_taken = $req->input('bloodSugar_date_taken', '');
        $riskform->rs_bloodSugar_symptoms = implode(', ', $dmSymptoms);
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
            $symptoms[] = 'Breathlessness (or a \'need for air\')';
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
        $riskform->rs_Chronic_Respiratory_Disease = implode(', ', $symptoms);  // Store as a string

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
    

        // Save the data
        $riskform->save();
        // Redirect after saving
        return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');
    }
}