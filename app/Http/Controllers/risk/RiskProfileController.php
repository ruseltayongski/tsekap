<?php

namespace App\Http\Controllers\risk;

use App\RiskProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Facilities;
use App\UserHealthFacility;
use App\Barangay;
use App\Muncity;
use App\RiskFormAssessment;

class RiskProfileController extends Controller
{
    private function explodeString($string)
    {
        return explode(", ", $string);
    }

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
    
        // Check for duplicate in the RiskProfile table, excluding 'mname'
        $existingRiskProfile = RiskProfile::where('profile_id', $request->profile_id)
            ->where('fname', $request->fname)
            ->where('lname', $request->lname)
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
        $riskprofile->dob = $request->dateofbirth;
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
        $riskprofile->phic_id = $request->phic_id ? $request->phic_id : null;
        $riskprofile->pwd_id = $request->pwd_id ? $request->pwd_id : null;
        $riskprofile->citizenship = $request->citizenship;
        $riskprofile->other_citizenship = $request->other_citizenship ? $request->other_citizenship : null;
        $riskprofile->indigenous_person = $request->indigenous_person;
        $riskprofile->employment_status = $request->employment_status;
        $riskprofile->facility_id_updated = $request->facility_id_updated;
        $riskprofile->encoded_by = $request->encoded_by;
        $riskprofile->offline_entry = false;
    
        // Save the profile
        $riskprofile->save();
    
        // Proceed with RiskFormAssessment entry
        $riskform = new RiskFormAssessment();
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
        
        // Save the data
        $riskform->save();
        
        return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');
    }    

    public function updateRiskPForm(Request $req)
    {
        $user = Auth::user();

        $id = $req->profile_id;

        // Retrieve the existing risk profile by ID
        $riskprofile = RiskProfile::find($id);

        \Log::info('RiskProfile: ' . json_encode($riskprofile));

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
        $riskprofile->dob = $req->dateofbirth;
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
        $riskform = RiskFormAssessment::where('risk_profile_id', "=", $id)->first();

        if (!$riskform) {
            return redirect()->back()->with('error', 'Associated risk form not found.');
        }

        \Log::info('RiskFormAssessment: ' . json_encode($riskform));

        // Update the RiskFormAssessment data
        $riskform->ar_chest_pain = $req->ar_chest_pain;
        $riskform->ar_difficulty_breathing = $req->ar_difficulty_breathing;
        // (Repeat for all fields in RiskFormAssessment...)
        $riskform->ar_chest_pain = $req->ar_chest_pain;
        $riskform->ar_difficulty_breathing = $req->ar_difficulty_breathing;
        $riskform->ar_loss_of_consciousness = $req->ar_loss_of_consciousness;
        $riskform->ar_slurred_speech = $req->ar_slurred_speech;
        $riskform->ar_facial_asymmetry = $req->ar_facial_asymmetry;
        $riskform->ar_weakness_numbness = $req->ar_weakness_numbness;
        $riskform->ar_disoriented = $req->ar_disoriented;
        $riskform->ar_chest_retractions = $req->ar_chest_retractions;
        $riskform->ar_seizure_convulsion = $req->ar_seizure_convulsion;
        $riskform->ar_act_self_harm_suicide = $req->ar_act_self_harm_suicide;
        $riskform->ar_agitated_behavior = $req->ar_agitated_behavior;
        $riskform->ar_eye_injury = $req->ar_eye_injury;
        $riskform->ar_severe_injuries = $req->ar_severe_injuries;
        $riskform->ar_refer_physician_name = $req->ar_refer_physician_name;
        $riskform->ar_refer_reason = $req->ar_refer_reason;
        $riskform->ar_refer_facility = $req->ar_refer_facility;

        //PAST MEDICAL HISTORY 
        $riskform->pmh_hypertension = $req->pmh_hypertension;
        $riskform->pmh_heart_disease = $req->pmh_heart_disease;
        $riskform->pmh_diabetes = $req->pmh_diabetes;
        $riskform->pmh_specify_diabetes = $req->pmh_diabetes_details;
        $riskform->pmh_cancer = $req->pmh_cancer;
        $riskform->pmh_specify_cancer = $req->pmh_cancer_details;
        $riskform->pmh_copd = $req->pmh_COPD;
        $riskform->pmh_asthma = $req->pmh_asthma;
        $riskform->pmh_allergies = $req->pmh_allergies;
        $riskform->pmh_specify_allergies = $req->pmh_allergies_details;
        $riskform->pmh_mn_and_s_disorder = $req->pmh_mnsad;
        $riskform->pmh_specify_mn_and_s_disorder = $req->pmh_mnsad_details;
        $riskform->pmh_vision_problems = $req->pmh_vision;
        $riskform->pmh_previous_surgical = $req->pmh_psh;
        $riskform->pmh_specify_previous_surgical = $req->pmh_psh_details;
        $riskform->pmh_thyroid_disorders = $req->pmh_thyroid;
        $riskform->pmh_kidney_disorders = $req->pmh_kidney;

        //FAMILY HISTORY
        $riskform->fmh_hypertension = $req->fmh_hypertension;
        $riskform->fmh_stroke = $req->fmh_stroke;
        $riskform->fmh_heart_disease = $req->fmh_heart_disease;
        $riskform->fmh_diabetes_mellitus = $req->fmh_diabetes_mellitus;
        $riskform->fmh_asthma = $req->fmh_asthma;
        $riskform->fmh_cancer = $req->fmh_cancer;
        $riskform->fmh_kidney_disease = $req->fmh_kidney;
        $riskform->fmh_first_degree_relative = $req->fmh_first_degree;
        $riskform->fmh_having_tuberculosis_5_years = $req->fmh_famtb;
        $riskform->fmh_mn_and_s_disorder = $req->fmh_mnsad;
        $riskform->fmh_copd = $req->fmh_copd;

        // NCD RISK FACTORS 
        $tobaccoUsed = $req->tobaccoUse;
        $tobaccoUseLimited = array_slice($tobaccoUsed, 0, 2);
        $riskform->rf_tobacco_use = implode(', ', $tobaccoUseLimited);
        $riskform->rf_alcohol_intake = $req->ncd_alcohol;
        $riskform->rf_alcohol_binge_drinker = $req->ncd_alcohol_binge;
        $riskform->rf_physical_activity = $req->ncd_physical;
        $riskform->rf_nutrition_dietary = $req->ncd_nutrition;
        $riskform->rf_weight = $req->rf_weight;
        $riskform->rf_height = $req->f_height;
        $riskform->rf_body_mass = $req->rf_bmi;
        $riskform->rf_waist_circumference = $req->rf_waist;

        //RISK SCREENING
        // Hypertension/Diabetes/Hypercholestrolemia/Renal Diseases

        $dmSymptoms = $req->input('dm_symptoms', []);

        $riskform->rs_systolic_t1 = $req->systolic_t1;
        $riskform->rs_diastolic_t1 = $req->diastolic_t1;
        $riskform->rs_systolic_t2 = $req->systolic_t2;
        $riskform->rs_diastolic_t2 = $req->diastolic_t2;
        $riskform->rs_blood_sugar_fbs = $req->fbs_result;
        $riskform->rs_blood_sugar_rbs = $req->rbs_result;
        $riskform->rs_blood_sugar_date_taken = $req->blood_sugar_date_taken;
        $riskform->rs_blood_sugar_symptoms = implode(', ', $dmSymptoms);
        $riskform->rs_lipid_cholesterol = $req->lipid_cholesterol;
        $riskform->rs_lipid_hdl = $req->lipid_hdl;
        $riskform->rs_lipid_ldl = $req->lipid_ldl;
        $riskform->rs_lipid_vldl = $req->lipid_vldl;
        $riskform->rs_lipid_triglyceride = $req->lipid_triglyceride;
        $riskform->rs_lipid_date_taken = $req->lipid_date_take;
        $riskform->rs_urine_protein = $req->uri_protein;
        $riskform->rs_urine_protein_date_taken = $req->uri_protein_date_taken;
        $riskform->rs_urine_ketones = $req->uri_ketones;
        $riskform->rs_urine_ketones_date_taken = $req->uri_ketones_date_taken;

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
        $riskform->mngm_med_hypertension = $req->anti_hypertensives;
        $riskform->mngm_med_hypertension_specify = $req->anti_hypertensives_specify;

        // Anti-Diabetes: Store selected option and any specify text, and type
        $riskform->mngm_med_diabetes = $req->anti_diabetes;
        $riskform->mngm_med_diabetes_options = $req->anti_diabetes_type;
        $riskform->mngm_med_diabetes_specify = $req->anti_diabetes_specify;

        // Follow-up Date
        $riskform->mngm_date_follow_up = $req->follow_up_date;

        // Remarks (Text area)
        $riskform->mngm_remarks = $req->remarks;
        $riskform->offline_entry = false;

        // Save the data
        $riskform->save();

        // Redirect after saving
        // return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');
        return redirect()->route('patientRisk')->with('success', 'Patient Successfully Added');
    }

    private function getHealthFacilityForUser($user)
    {
        $userHealthFacilityMapping = UserHealthFacility::where('user_id', $user->id)->first();

        if ($userHealthFacilityMapping) {
            return Facilities::select('id', 'name', 'address', 'hospital_type')
                ->where('id', $userHealthFacilityMapping->facility_id)
                ->first();
        }
        return null;
    }

    public function PatientRiskProfileAndFormSubList($profile_id)
    {
        // Authenticate user
        $user = Auth::user();

        // Retrieve the existing risk profile by ID
        $riskprofile = RiskProfile::find($profile_id);

        if (!$riskprofile) {
            return redirect()->back()->with('error', 'Risk profile not found.');
        }

        // Retrieve the associated RiskFormAssessment
        $riskform = RiskFormAssessment::where('risk_profile_id', $profile_id)->first();

        if (!$riskform) {
            return redirect()->back()->with('error', 'Associated risk form not found.');
        }

        // Log the data for debugging
        \Log::info("Risk profile: {$riskprofile}");
        \Log::info("Risk Form: {$riskform}");

        // Structure the profile object with riskForm as a nested object
        $profile = [
            'id' => $riskprofile->id,
            'fname' => $riskprofile->fname, // Replace with actual field names
            'mname' => $riskprofile->mname,
            'lname' => $riskprofile->lname,
            'suffix' => $riskprofile->suffix,
            'sex' => $riskprofile->sex,
            'dob' => $riskprofile->dob,
            'age' => $riskprofile->age,
            'civil_status' => $riskprofile->civil_status,
            'religion' => $riskprofile->religion,
            'other_religion' => $riskprofile->other_religion,
            'contact' => $riskprofile->contact,
            'province_id' => $riskprofile->province_id,
            'municipal_id' => $riskprofile->municipal_id,
            'barangay_id' => $riskprofile->barangay_id,
            'street' => $riskprofile->street,
            'purok' => $riskprofile->purok,
            'sitio' => $riskprofile->sitio,
            'phic_id' => $riskprofile->phic_id,
            'pwd_id' => $riskprofile->pwd_id,
            'citizenship' => $riskprofile->citizenship,
            'other_citizenship' => $riskprofile->other_citizenship,
            'indigenous_person' => $riskprofile->indigenous_person,
            'employment_status' => $riskprofile->employment_status,
            'facility_id_updated' => $riskprofile->facility_id_updated,
            'offline_entry' => $riskprofile->offline_entry,
            'encoded_by' => $riskprofile->encoded_by,
            'created_at' => $riskprofile->created_at,
            'updated_at' => $riskprofile->updated_at,
            'riskForm' => $riskform
        ];

        \Log::info('Profile: ' . json_encode($profile));

        // Return the structured data to the view
        return view('risk.sublistRiskAssesment', compact('profile'));
    }


    public function PatientRiskFormList(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->input('keyword');  
    
        $facility = $this->getHealthFacilityForUser($user);
    
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
    
        switch ($user->user_priv) {
            case 1:
            // No filters applied
                break;
            case 6: // Facility view
            case 10: // DSOs view
                $this->applyFilters($query, $user, $keyword);
                $query->where('facility_id_updated', $facility->id);
            break;
            case 7: // Region view
                $this->applyFilters($query, $user, $keyword);
            break;
            case 3: // Provincial view
                $this->applyFilters($query, $user, $keyword);
                $query->where('province_id', $user->province);
            break;
            default:
            // Default empty pagination if no condition is met
                $query->where('id', 0);
            break;
        }
    
        $riskprofiles = $query->simplePaginate(15);
    
        // Log the query results
        if ($riskprofiles->isEmpty()) {
            \Log::info('No risk profiles found', [
                'user_id' => $user->id,
                'user_priv' => $user->user_priv,
                'keyword' => $keyword,
            ]);
        } else {
            \Log::info('Risk profiles found', [
                'user_id' => $user->id,
                'user_priv' => $user->user_priv,
                'keyword' => $keyword,
                'results_count' => $riskprofiles->count(),
            ]);
        }
    
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