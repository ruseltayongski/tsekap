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
          $riskform->physician_name = $req->input('physician_name');
          $riskform->reason = $req->input('reason');
          $riskform->facility = $req->input('facility');
         // Save the data
         $riskform->save();
        // Redirect after saving
        return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');
    }
}
