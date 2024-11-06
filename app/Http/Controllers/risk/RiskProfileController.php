<?php

namespace App\Http\Controllers\risk;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facility;
use App\Barangay;
use App\Muncity;
use App\Province;
use App\Profile;
use App\RiskFormAssesment;


class RiskProfileController extends Controller     
{
    //
    
    public function getMunicipal($provinceid){

      $muncity = Muncity::where('province_id', $provinceid)
        ->select('id','province_id','description')
        ->whereNotIn('id',['63','76','80'])
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
        //$user = Auth::user();
        $facilities = Facility::all();
        $facility = Facility::select('id','name','address','hospital_type')
        ->where('id', $user->facility_id)    
        ->get();
          $facilities = null;

          foreach($facility as $fact){
              $facilities = $fact;
          }

        $riskform = new RiskFormAssesment();  

         // Health assessment checkbox fields
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
              $riskForm->fbs_result = $req->input('fbs_result', '');
              $riskForm->rbs_result = $req->input('rbs_result', '');
              $riskForm->date_taken_fbs_rbs = $req->input('date_taken_fbs_rbs', '');

              



         // Save the data
         $riskform->save();
        // Redirect after saving
        return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');
    }
}
