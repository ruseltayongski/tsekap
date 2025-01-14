<?php
namespace App\Http\Controllers\risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Facility;
use App\Barangay;
use App\Muncity;
use App\Province;
use App\RiskProfile;
use App\RiskFormAssessment;

class RiskProfileController extends Controller     
{
    public function getMunicipal($provinceid){
        $muncity = Muncity::where('province_id', $provinceid)
            ->select('id','province_id','description')
            ->get();
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

        // Check for duplicate in the RiskProfile table
        $existingRiskProfile = RiskProfile::where('fname', $req->fname)
            ->where('lname', $req->lname)
            ->where('mname', $req->mname)
            ->where('dob', $req->dob)
            ->first();

        if ($existingRiskProfile) {
        // Redirect with an error message if a duplicate is found
            return redirect()->back()->with('error', 'Duplicate risk profile exists with the same data.');
        }

        $riskprofile = new RiskProfile();

        // Assign all the necessary values
        $riskprofile->profile_id = $req-> profile_id ? $req->profile_id : null;
        $riskprofile->lname = $req->lname;
        $riskprofile->fname = $req->fname;
        $riskprofile->mname = $req->mname? $req->mname : null ;
        $riskprofile->suffix = $req->suffix? $req->suffix : null;
        $riskprofile->sex = $req->sex;
        $riskprofile->dob = $req->dob;
        $riskprofile->age = $req->age;
        $riskprofile->civil_status = $req->civil_status; 
        $riskprofile->religion = $req->religion;
        $riskprofile->other_religion = $req->other_religion ? $req -> other_religion : null; 
        $riskprofile->contact = $req->contact;
        $riskprofile->province_id = $req->province;
        $riskprofile->municipal_id = $req->municipal;
        $riskprofile->barangay_id = $req->barangay;
        $riskprofile->street = $req->street? $req->street : null;
        $riskprofile->purok = $req->purok? $req->purok : null;
        $riskprofile->sitio = $req->sitio? $req->sitio : null;
        $riskprofile->phic_id = $req->phic_id? $req->phic_id : null; // Ensure you use the correct field name here
        $riskprofile->pwd_id = $req->pwd_id? $req->pwd_id : null;
        $riskprofile->citizenship = $req->citizenship;
        $riskprofile->other_citizenship = $req -> other_citizenship ? $req -> other_citizenship : null;
        $riskprofile->indigenous_person = $req->indigenous_person;
        $riskprofile->employment_status = $req->employment_status;
        $riskprofile->facility_id_updated = $req->facility_id_updated; // Ensure this is not null
    
        // Save the profile
        $riskprofile->save();
        $riskform = new RiskFormAssessment();

        // Health assessment checkbox fields
        $riskform->risk_profile_id = $riskprofile->id;
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
        //$riskform->fmh_side_hypertension = $req->input('fmh_side_hypertension','No');
        $riskform->fmh_stroke = $req->input('fmh_stroke','No');
        $riskform->fmh_heart_disease = $req->input('fmh_heart_disease','No');
        $riskform->fmh_diabetes_mellitus = $req->input('fmh_diabetes_mellitus','No');
        $riskform->fmh_asthma = $req->input('fmh_asthma','No');
        $riskform->fmh_cancer = $req->input('fmh_cancer','No');
        $riskform->fmh_kidney_disease = $req->input('fmh_kidney','No');
        $riskform->fmh_first_degree_relative = $req->input('fmh_first_degree','No');
        $riskform->fmh_having_tuberculosis_5_years = $req->input('fmh_famtb','No');
        $riskform->fmh_mn_and_s_disorder = $req->input('fmh_mnsad','No');
        $riskform->fmh_copd = $req->input('fmh_copd','No');

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
    

        // Save the data
        $riskform->save();
        // Redirect after saving
        return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');
    }

    public function PatientRiskFormList(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->input('keyword');
    
        $query = RiskProfile::select(
            'id', 'fname', 'mname', 'lname', 'dob', 'sex', 'civil_status', 
            'barangay_id', 'municipal_id', 'province_id', 'facility_id_updated', 'created_at'
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
    
        if ($request->ajax()) {
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
    
    public function SublistRiskPatient($id){

        $user = Auth::user();
        $facility = Facility::select('id','name','address','hospital_type')->get();

            $selectedMuncity = Muncity::select('id','description')
            ->get();
        $province = Province::select('id','description')->get();

        $province_selectedMun = $province->merge($selectedMuncity);

         $profile = RiskProfile::select('id', 'fname', 'mname', 'lname', 'dob', 'suffix', 'sex',  'age',
                                        'civil_status','religion','other_religion','contact','municipal_id', 'province_id', 
                                         'barangay_id','street','purok','sitio','phic_id', 'pwd_id','citizenship','other_citizenship',
                                         'indigenous_person','employment_status', 'facility_id_updated','created_at')
             ->with([
            'riskForm' => function ($query) {
                $query->select('id','risk_profile_id',
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
                    //'fmh_side_hypertension',
                    'fmh_stroke',
                    //'fmh_side_stroke',
                    'fmh_heart_disease',
                    //'fmh_side_heart_disease',
                    'fmh_diabetes_mellitus',
                    //'fmh_side_diabetes_mellitus',
                    'fmh_asthma',
                    //'fmh_side_asthma',
                    'fmh_cancer',
                    //'fmh_side_cancer',
                    'fmh_kidney_disease',
                    //'fmh_side_kidney_disease',
                    'fmh_first_degree_relative',
                    //'fmh_side_coronary_disease',
                    'fmh_having_tuberculosis_5_years',
                    //'fmh_side_tuberculosis', 
                    'fmh_mn_and_s_disorder',
                    //'fmh_side_mn_and_s_disorder',
                    'fmh_copd',
                    //'fmh_side_copd',
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
                    'mngm_remarks'
                ); 
            }
        ])->find($id);

        $tobaccoUseArray = explode(', ', $profile->riskForm->rf_tobacco_use ? $profile->riskForm->rf_tobacco_use : []);
     
        return view('risk.sublistRiskAssesment',[
            'profile' => $profile,
            'facility' => $facility,
            'province' => $province_selectedMun,
        ]);
   
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