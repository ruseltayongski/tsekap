<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facility;
use App\Barangay;
use App\Muncity;
use App\Province;
use App\ResuReportFacility;
use App\Profile;
use App\ResuPreadmission;
use App\ResuNature_Preadmission;
class PatientInjuryController extends Controller
{
    //
    public function PatientInjured(){
        $user = Auth::user();

        return view('resu.manage_patient_injury.list_patient', [
            'user_priv' => $user
        ]);
    }

    public function PatientForm(){

        $facility = Facility::all();
        $province = Province::all();
        $barangay = Barangay::all();
     
        return view('resu.manage_patient_injury.patient_form',[
            'facility' => $facility,
            'province' => $province,
            'muncity' => $muncity,
            'barangay' => $barangay
        ]);
    }

    public function getMunicipal($provinceid){

      $muncity = Muncity::where('province_id', $provinceid)->get();
      
      return response()->json($muncity);
    }

    public function getBarangay($muncity_id){
        $barangay = Barangay::where('muncity_id',$muncity_id)->get();
        return response()->json($barangay);
    }

    public function SubmitPatientInjury(Request $request){
        $user = Auth::user();
        // $facility = new ResuReportFacility();

        // $facility->reportfacility = $request->facilityname;
        // $facility->typeOfdru = $request->typedru;
        // $facility->Addressfacility = $request->addressfacility;
        // $facility->typeofpatient = $request->typePatient;
        // $facility->save();

        // $profile = new Profile();
        // $unique_id = $request->fname.''.$request->mname.''.$request->lname.''.$request->suffix.''.$request->barangay.''.$user->muncity;
        // $profile->unique_id = $unique_id;
        // $profile->Hospital_caseno = $request->hospital_no;
        // $profile->report_facilityId = $facility->id;
        // $profile->fname = $request->fname;
        // $profile->mname = $request->mname;
        // $profile->lname = $request->lname;
        // $profile->sex = $request->sex;
        // $profile->dob = $request->dateBirth;
        // $profile->province_id = $request->province;
        // $profile->muncity_id = $request->municipal;
        // $profile->barangay_id = $request->barangay;
        // $profile->phicID = $request->phil_no;
        // $profile->save();

        // $pre_admission = new ResuPreadmission();
        // $pre_admission->profile_id = $profile->id;
        // $pre_admission->POIProvince_id = $request->provinceInjury;
        // $pre_admission->POImuncity_id = $request->municipal_injury;
        // $pre_admission->POIBarangay_id = $request->barangay_injury;
        // $pre_admission->POIPurok = $request->purok_injury;
        // $pre_admission->dateInjury = $request->date_injury;
        // $pre_admission->timeInjury = $request->time_injury;
        // $pre_admission->dateConsult = $request->date_consult;
        // $pre_admission->timeConsult = $request->time_consult;
        // $pre_admission->injury_intent = $request->injury_intent;
        // $pre_admission->first_aid = $request->firstAidGive;
        // $pre_admission->what = $request->druWhat;
        // $pre_admission->bywhom = $request->druByWhom;
        // $pre_admission->multipleInjury = $request->multiple_injured;

        // $pre_admission->save();

        // $nature = new ResuNature_Preadmission();
        // if($nature->natureInjury_id == $request->InjuredBurn){
        //     $nature->Pre_admission_id = 1;
        //     $nature->natureInjury_id = $request->InjuredBurn;
        //     $nature->subtype = $request->Degree; 
        //     $nature->details = $request->burnDetail;
        //     $nature->side = $request->burnside;
        //     $nature->save();
        // }elseif($nature->natureInjury_id == $request->fractureNature){
        //     $nature->Pre_admission_id = 1;
        //     $nature->natureInjury_id = $request->fractureNature;
        //     $nature->subtype = $request->fracttype;
        //     if($request->fracture_open_detail){
        //         $nature->details = $request->fracture_open_detail;
        //         $nature->side = $request->opentype_side;
        //     }else{
        //         $nature->details = $request->fracture_close_detail;
        //         $nature->side = $request->closetype_side;
        //     }
        //     $nature->save();
        // }elseif($nature->natureInjury_id == $request->Others_nature_injured){
        //         $nature->Pre_admission_id = 1;
        //         $nature->natureInjury_id = $request->Others_nature_injured;
        //         $nature->details = $request->other_nature_datails;
        //         $nature->side = $request->side_others;
        //         $nature->save();
        // }else{
        //     foreach($request->nature as $natures){
        //         $nature->Pre_admission_id = 1;
        //         $nature->natureInjury_id = $natures['id'];
        //         $nature->details = $natures['details'];
        //         $nature->save();
        //     }
        //     foreach($request->sideInjured as $side){
        //         $nature->side = $side['id'];
        //         $nature->save();
        //     }
        // }
       
        //  return $request->all();

        if($request->InjuredBurn || $request->burnside) {
            $nature = new ResuNature_Preadmission();
            $nature->Pre_admission_id = 1;
            $nature->natureInjury_id = $request->InjuredBurn;
            $nature->subtype = $request->Degree; 
            $nature->details = $request->burnDetail;
            $nature->side = $request->burnside;
            $nature->save();
        }
    
        if($request->fractureNature) {
            $nature = new ResuNature_Preadmission();
            $nature->Pre_admission_id = 1;
            $nature->natureInjury_id = $request->fractureNature;
            $nature->subtype = $request->fracttype;
            if($request->fracture_open_detail){
                $nature->details = $request->fracture_open_detail;
                $nature->side = $request->opentype_side;
            }else{
                $nature->details = $request->fracture_close_detail;
                $nature->side = $request->closetype_side;
            }
            $nature->save();
        }
    
        if($request->Others_nature_injured) {
            $nature = new ResuNature_Preadmission();
            $nature->Pre_admission_id = 1;
            $nature->natureInjury_id = $request->Others_nature_injured;
            $nature->details = $request->other_nature_datails;
            $nature->side = $request->side_others;
            $nature->save();
        }
   
        if($request->nature) {
            foreach($request->nature as $key => $natures){
                $nature = new ResuNature_Preadmission();
                $nature->Pre_admission_id = 1;
                $nature->natureInjury_id = $natures['id'];
                $nature->details = $natures['details'];
    
                // Use dynamic key to access corresponding side
                $sideKey = 'sideInjured' . $key;
                if(isset($request->$sideKey)){
                    $nature->side = $request->$sideKey['id'];
                }else{
                    $nature->side = null;
                }
                $nature->save();
            }
        }
       
        
    }   
}
