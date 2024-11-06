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
use App\Resunature_injury_bodyparts;
use App\Resuexternal_injury_preAdmission;
use App\ResuTransport;
use App\ResuSafetyTransport;
use App\ResuSafety;
use App\ResuInpatient;
use App\ResuErOpdBhsRhu;
use App\ResuProfileInjury;

class PatientInjuryController extends Controller     
{
    //
    public function PatientInjured(Request $request){ 
        $user = Auth::user();
     
        $keyword = $request->input('keyword');
     
        $query = ResuProfileInjury::select('id','fname', 'mname', 'lname', 'dob' , 'sex', 'barangay_id', 'muncity_id', 'province_id', 'report_facilityId','name_of_encoder')
        // $query =Profile::select('id','fname', 'mname', 'lname', 'dob' , 'sex', 'barangay_id', 'muncity_id', 'province_id', 'report_facilityId','name_of_encoder')   
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
                    $query->select('id','muncity_id', 'description');
                },
                'preadmission' => function($query){
                    $query->select('id','profile_id','POIProvince_id','POImuncity_id','POIBarangay_id','POIPurok','dateInjury','timeInjury');
                },
            ])
            ->whereNotNull('report_facilityId')
            ->orderby('id', 'desc');

             $user_facility = ResuReportFacility::where('facility_id',  $user->facility_id)->first();
             
            if($user->user_priv == 6){ // for facility view
                if(!empty($keyword)){ //search functionality
                        $query->where('report_facilityId', $user->facility_id)
                    ->where(function ($q) use ($keyword){
                        $q->where('fname', 'like', "%$keyword%")
                            ->orWhere('lname', 'like', "%$keyword%")
                            ->orWhereHas('province', function ($q) use ($keyword){
                                $q->where('description','like', "%$keyword%");
                            })
                            ->orWhereHas('muncity', function ($q) use ($keyword){
                                $q->where('description', 'like', "%$keyword%");
                            });
                    });
                }
                $profiles = $query->where('report_facilityId', $user->facility_id)->simplePaginate(15);
                
            }else if($user->user_priv == 7){ //Region view
                if(!empty($keyword)){ //search functionality
                    $query->where(function ($q) use ($keyword){
                        $q->where('fname', 'like', "%$keyword%")
                            ->orWhere('lname', 'like', "%$keyword%")
                            
                            ->orWhereHas('province', function ($q) use ($keyword){
                                $q->where('description', 'like', "%$keyword%");
                            })
                            ->orWhereHas('muncity', function ($q) use ($keyword){
                                $q->where('description', 'like', "%$keyword%");
                            });
                    });
                }
                $profiles = $query->simplePaginate(15);
             
            }else if($user->user_priv == 3){ //provincial

                if(!empty($keyword)){ //search functionality
                        $query->where('province_id', $user->province)
                        ->whereNotIn('province_id',['63','76','80'])    
                    ->where(function ($q) use ($keyword){
                        $q->where('fname', 'like', "%$keyword%")
                            ->orWhere('lname', 'like', "%$keyword%")
                            ->orWhereHas('muncity', function ($q) use ($keyword){
                                $q->where('description', 'like', "%$keyword%");
                            });
                    });
                }

               $profiles = $query->where('province_id', $user->province)
                    ->whereNotIn('province_id',['63','76','80'])
                    ->simplePaginate(15);

            }else if($user->user_priv == 8){ // HUC

                $profiles = $query->where('muncity_id', $user->muncity)
                    ->simplePaginate(15);
            }
            else{
                $profiles = $query->simplePaginate(15);
            }
            
             if ($request->ajax()) { // for populate table search
                 return view('resu.manage_patient_injury.Partialprofile_table', compact('profiles','user'))->render();
            //     return view('resu.manage_patient_injury.Partialprofile_table', compact('profiles','user'))->render();
             }
            
        return view('resu.manage_patient_injury.list_patient', [
            'user_priv' => $user,
            'profile' => $profiles,
        
        ]);
    }

    public function PatientForm(){

        $user = Auth::user();

        $selectedMuncity = Muncity::select('id','description')
            ->whereIn('id', ['63','76','80'])
            ->get();

        $facility = Facility::select('id','name','address','hospital_type')
            ->where('id', $user->facility_id)    
            ->get();
        $facilities = null;

        foreach($facility as $fact){
            $facilities = $fact;
        }
        // $province = Province::select('id', 'description')->get();
        // $safety = ResuSafety::all();
        // $province_SelectedMuncity = $province->merge($selectedMuncity);

        $province = Province::select('id', 'description')->get();
        $safety = ResuSafety::all();

        $province_SelectedMuncity = $province->merge($selectedMuncity);

        return view('resu.manage_patient_injury.patient_form',[
                'facility' => $facilities,
            'province' => $province_SelectedMuncity,
            'muncity' => $muncity,
            'barangay' => $barangay,
            'safety' => $safety,
            'user' => $user,
        ]);
    }

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

    public function SubmitPatientInjury(Request $request){  //added patient
        $user = Auth::user();
        // $reportFact =   ResuReportFacility::select('id','facility_id')->get();
        // $fact_id = null;
        // foreach ($reportFact  as $key => $fact) {
        //     $fact_id = $fact->facility_id;
        // }

        // $validatedData = $request->validate([
        //     'lname' => 'required|string|max:255',
        //     // Other fields...
        // ], [
        //     'lname.required' => 'Last name is required.',
        //     'fname.required' => 'First name is required.',
        //     'mname.required' => 'Middle name is required.',
        // ]);

        $facility = ResuReportFacility::where('facility_id', $request->facility_id)->first();
        if(!$facility){
            $facility = new ResuReportFacility();
        }
        $facility->facility_id = $request->facility_id;
        $facility->facilityName = $request->facilityname;
       // $facility->facility_id = $request->facilityname; 
        $facility->typeOfdru = $request->typedru;
        $facility->Addressfacility = $request->addressfacility;
        $facility->typeofpatient = $request->typePatient;
        $facility->reportfacility = $request->facility_id;
        $facility->save();

        $profile = new ResuProfileInjury();
        // $profile = new Profile();
        $unique_id = $request->fname.''.$request->mname.''.$request->lname.''.$request->suffix.''.$request->barangay.''.$user->muncity;
        $profile->unique_id = $unique_id;
        $profile->Hospital_caseno = $request->hospital_no;
        $profile->fname = $request->fname;
        $profile->mname = $request->mname;
        $profile->lname = $request->lname;
        $profile->sex = $request->sex;
        $profile->dob = $request->dateBirth;
        $profile->province_id = $request->province;
        $profile->muncity_id = $request->municipal;
        $profile->barangay_id = $request->barangay;
        $profile->phicID = $request->phil_no;
        $profile->type_of_patient = $request->typePatient;
        $profile->name_of_encoder = $user->fname.' '.$user->lname;
        $profile->report_facilityId = $request->facility_id;

        // $profile->nameof_encoder = $user->
        $profile->save();

        $pre_admission = new ResuPreadmission();
        $pre_admission->profile_id = $profile->id;
        $pre_admission->POIProvince_id = $request->provinceInjury;
        $pre_admission->POImuncity_id = $request->municipal_injury;
        $pre_admission->POIBarangay_id = $request->barangay_injury;
        $pre_admission->POIPurok = $request->purok_injury;
        $pre_admission->dateInjury = $request->date_injury;
        $pre_admission->timeInjury = $request->time_injury;
        $pre_admission->dateConsult = $request->date_consult;
        $pre_admission->timeConsult = $request->time_consult;
        $pre_admission->injury_intent = $request->injury_intent;
        $pre_admission->first_aid = $request->firstAidGive;
        $pre_admission->what = $request->druWhat;
        $pre_admission->bywhom = $request->druByWhom;
        $pre_admission->multipleInjury = $request->multiple_injured;

        $pre_admission->save();

        if($request->InjuredBurn || $request->burnside) {
            $nature = new ResuNature_Preadmission();
            $nature->Pre_admission_id = $pre_admission->id;
            $nature->natureInjury_id = $request->InjuredBurn;
            $nature->subtype = $request->Degree; 
            $nature->details = $request->burnDetail;

            $nature->save();

            $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id , $request->input('burn_body_parts', []));
        }
    
        if($request->fractureNature) {
            $nature = new ResuNature_Preadmission();
            $nature->Pre_admission_id = $pre_admission->id;
            $nature->natureInjury_id = $request->fractureNature;
            $nature->subtype = $request->fracttype;
            $nature->details = $request->fracture_detail;
          
            $nature->save();
            $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id , $request->input('fracture_bodyparts', []));
        }
    
        if($request->Others_nature_injured) {
            $nature = new ResuNature_Preadmission();
            $nature->Pre_admission_id = $pre_admission->id;
            $nature->natureInjury_id = $request->Others_nature_injured;
            $nature->details = $request->other_nature_datails;
            $nature->save();

            $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id ,$request->input('body_parts_others', []));
        }

        $injuredcount = $request->input('injured_count');

        for($i = 1; $i <= $injuredcount; $i++){
            if($request->has('nature' . $i) || $request->has('nature_details' . $i) || $request->has('sideInjured' . $i)){
                $nature = new ResuNature_Preadmission();
                $nature->Pre_admission_id = $pre_admission->id; // Update this as needed
                $nature->natureInjury_id = $request->input('nature' . $i);
                $nature->details = $request->input('nature_details' . $i);
              
                $nature->save();
        
                $this->SaveBodyParts($nature->natureInjury_id, $nature->Pre_admission_id ,$request->input('body_parts_injured' . $i, []));
            }
        }

        //save selected external Injuries
        $this->SelectedExternalSaveInjury($request, $pre_admission->id);
        //-------------------------------------------------------------------------//
        //for Transport form 
            $this->TransportVehicle($request, $pre_admission->id);

        //Hospital/Facility Data
        $hospital_data = $request->hospital_data;
        $hospital_dataSecond = $request->hospital_data_second;
        if($hospital_dataSecond){
            $inpatient = new ResuInpatient();
            $inpatient->hospitalfacility_id = $hospital_dataSecond;
            $inpatient->profile_id = $profile->id;
            $inpatient->complete_Diagnose = $request->final_diagnose;
            $inpatient->Disposition = $request->disposition1;
            if($request->trans_facility_hos_details2){
                $inpatient->details = $request->trans_facility_hos_details2;
            }else{
                $inpatient->details = $request->disposition_others_details;
            }
            $inpatient->outcome = $request->Outcome1;
            $inpatient->icd10Code_nature = $request->icd10_nature1;
            $inpatient->icd10Code_external = $request->icd10_external1;

            $inpatient->save();
        }elseif($hospital_data){
            $erOpd = new ResuErOpdBhsRhu();

            $erOpd->hospitalfacility_id = $hospital_data;
            $erOpd->profile_id = $profile->id;
            $erOpd->transferred_facility = $request->Transferred;
            $erOpd->referred_facility = $request->Referred;
            $erOpd->originating_hospital = $request->name_orig;
            $erOpd->status_facility = $request->reashingFact;
            $eropd->Ifalive = $request->ifAlive;
            $erOpd->mode_transport_facility = $request->mode_transport;
            $erOpd->other_details = $request->mode_others_details;
            $erOpd->initial_impression = $request->Initial_Impression;
            $erOpd->icd10Code_nature = $request->icd10_nature;
            $erOpd->icd10Code_external = $request->icd10_external;
            $erOpd->disposition = $request->disposition;
            $erOpd->details = $request->trans_facility_hos_details;
            $erOpd->outcome = $request->outcome;

            $erOpd->save();
        }
        // else{
        //     return "Invalid Hosiptal Id";
        // }
        
        return redirect()->route('patientInjury')->with('success', 'Patient Successfully Added');
        // return view('resu.manage_patient_injury.list_patient', [
        //     'user_priv' => $user,
        //     'profile' => $profiles,
        //     //'facility' => $facility,
        // ]);
    }   

    //sub sub category bodyparts
    private function SaveBodyParts($natureId,$pre_admiss_id,$bodyParts)
    {
        $bodyPartsData = [];
        foreach($bodyParts as $bodypart){
            $bodyPartsData[] = [
                'preadmission_id' => $pre_admiss_id,
                'nature_injury_id' => $natureId,
                'bodyparts_id' => $bodypart
            ];
        }
        Resunature_injury_bodyparts::insert($bodyPartsData);

   }

    private function SelectedExternalSaveInjury($request, $pre_admission_id){

        if($request->ex_burn){
            $external = new Resuexternal_injury_preAdmission();
            $external->Pre_admission_id = $pre_admission_id;
            $external->externalinjury_id = $request->ex_burn;
            $external->subtype = $request->burn_type;
            $external->details = $request->exburnDetails;
            $external->save();
        }
        
        if($request->exDrowning){
            $external = new Resuexternal_injury_preAdmission();
            $external->Pre_admission_id = $pre_admission_id;
            $external->externalinjury_id = $request->exDrowning;
            $external->subtype = $request->drowningType;
            $external->details = $request->exdrowning_Details;
            $external->save();
        }

        if($request->externalTransport){
            $external = new Resuexternal_injury_preAdmission();
            $external->Pre_admission_id = $pre_admission_id;
            $external->externalinjury_id = $request->externalTransport;
            $external->details = $request->transport_details;
            $external->save();
        }

        $external_count = $request->input('external_count');

        for($i = 1; $i <= $external_count; $i++){
            if($request->has('external' . $i) || $request->has('external_details')){
                $external = new Resuexternal_injury_preAdmission();
                $external->Pre_admission_id = $pre_admission_id;
                $external->externalinjury_id = $request->input('external' . $i);
                $external->details = $request->input('external_details' . $i);
                $external->save();
            }
        }
    }

    //saving for transport vehicle
    private function TransportVehicle($request, $pre_admission_id){
        $external_injury_pread_id = $request->externalTransport;
        if($external_injury_pread_id){
            $transport = new ResuTransport();
            $transport->Pre_admission_id = $pre_admission_id;
            $transport->transport_accident_id = $request->transport_accident_id;

            $transport->Vehicular_acc_type = $request->transport_collision;

            $transport->other_collision = $request->Othercollision;
            $transport->other_collision_details = $request->other_collision_details;

            $transport->xternal_injury_pread_id = $external_injury_pread_id;

            $transport->PatientVehicle = $request->Patient_vehicle;
            $transport->Pvother_detail = $request->Patient_vehicle_others;

            $transport->positionPatient = $request->position_patient;
            $transport->ppother_detail = $request->position_other_details;

            $transport->pofOccurence = $request->Occurrence;
            $transport->workplace_occurence_specify = $request->workplace_occ_specify;
            $transport->pofOccurence_others = $request->Occurrence_others;
    
            $transport->activity_patient = $request->activity_patient;
            $transport->AP_others = $request->activity_patient_other;

            $transport->risk_factors = $request->risk_factors;
            $transport->rf_others = $request->rf_others;

            if($request->has('safe')){
                $safet_values = $request->input('safe');
                $safety_ids = [];
                foreach($safet_values as $safety_value){    
                    $safety_ids[] = $safety_value;
                    if($safety_value == $request->safety_others_id){
                        $transport->safety_others = $request->safeothers_details;
                    } 
                }
                $transport->safety =  !empty($safety_ids) ? implode('-',  $safety_ids) : '';
            } 

            $transport->save(); 
        }else{
            return "Invalid Transport Id";
        }

    } 
    public function SublistPatient($profile_id){

        $user = Auth::user();
        $facility = Facility::select('id','name','address','hospital_type')->get();
        $listsafety = ResuSafety::all();

        // $profile = Profile::with(['reportfacility', 'preadmission'])->find($profile_id);

        // $profile = Profile::with(['reportfacility', 
        // 'preadmission.natureInjuryPreadmissions.bodyParts',
        // 'preadmission.externalPreadmissions.transport.Allsafety',
        // 'resuInpatient',
        // 'resuEropdbhsrhu'
        // ])->find($profile_id);

        $selectedMuncity = Muncity::select('id','description')
            ->whereIn('id', ['63','76','80'])
            ->get();
        $province = Province::select('id','description')->get();

        $province_selectedMun = $province->merge($selectedMuncity);

         $profile = ResuProfileInjury::select('id', 'fname', 'mname', 'lname', 'dob', 'phicID', 'sex', 'barangay_id', 'muncity_id', 'province_id', 'Hospital_caseNo', 'type_of_patient','report_facilityId')
        // $profile = Profile::select('id', 'fname', 'mname', 'lname', 'dob', 'phicID', 'sex', 'barangay_id', 'muncity_id', 'province_id', 'Hospital_caseNo', 'type_of_patient','report_facilityId')
             ->with([
            'preadmission' => function ($query) { //sub list manage patient injury
                $query->select('id', 'profile_id','POIProvince_id','POImuncity_id','POImuncity_id','POIBarangay_id','POIPurok','dateInjury','dateInjury','timeInjury','dateConsult',
                'timeConsult','injury_intent','first_aid','what','bywhom','multipleInjury'); // Limit columns
            },
            'preadmission.natureInjuryPreadmissions' => function ($query) {
                $query->select('id', 'Pre_admission_id','natureInjury_id','subtype','details','side'); // Limit columns
            },
            'preadmission.natureInjuryPreadmissions.bodyParts' => function ($query) {
                $query->select('id', 'preadmission_id','nature_injury_id','bodyparts_id'); // Limit columns
            },
            'preadmission.externalPreadmissions' => function ($query) {
                $query->select('id', 'Pre_admission_id','externalinjury_id','subtype','details'); // Limit columns
            },
            'preadmission.externalPreadmissions.transport' => function ($query) {
                $query->select('id', 'Pre_admission_id','transport_accident_id','Vehicular_acc_type','xternal_injury_pread_id','other_collision','other_collision_details','PatientVehicle','PvOther_detail',
                'positionPatient','ppother_detail','pofOccurence','workplace_occurence_specify','pofOccurence_others','activity_patient','AP_others','risk_factors','rf_others','safety','safety_others'); // Limit columns
            },
            'resuInpatient' => function ($query){
                $query->select('id','hospitalfacility_id','profile_id','complete_Diagnose','Disposition','details','Outcome','icd10Code_nature','icd10Code_external');
            },
            'resuEropdbhsrhu' => function ($query){
                $query->select('id','hospitalfacility_id','profile_id','transferred_facility','referred_facility','originating_hospital','status_facility','Ifalive','mode_transport_facility','other_details',
                'initial_impression','icd10Code_nature','icd10Code_external','disposition','details','outcome');
            }, 'province', 'muncity','barangay'

        ])->find($profile_id);
      //  dd($profile->preadmission);
        
        $transportData = [];
        $safe_details = [];
        foreach($profile->preadmission->externalPreadmissions as $transport){
            foreach($transport->transport as $trans){
                $transportData = $trans;
            }
        }
        
        $hospitalData = [];
      
        if($profile->resuInpatient){
            $hospitalData = $profile->resuInpatient;
        }else{
            $hospitalData = $profile->resuEropdbhsrhu;
        }
        $safety = explode('-',$transportData->safety);
        $safety_id = array_map('intval', $safety);  
     
        return view('resu.manage_patient_injury.sub_list_patient',[
            'profile' => $profile,
            'facility' => $facility,
            'province' => $province_selectedMun,
            // 'selectedMuncity' => $selectedMuncity,
            'list_safety' => $listsafety,
            'trans' => $transportData,
            'hospitalData' => $hospitalData,
            'transport_Id' => $get_transportId,
            'safe_ids' =>  $safety_id,
           
        ]);
   
    } 

    public function UpdatePatientInjury(Request $request){
        $user = Auth::user();
        $facility = ResuReportFacility::find($request->report_facilityId);  
        // if ($user->userpriv == 7) {
        //     return redirect()->route('patientInjury')
        //         ->with('error', 'You do not have permission to update this record.');
        // }
        
        if(!$facility){
            $facility = new ResuReportFacility();
        }
        $facility->facility_id = $request->facility_id;
       // $facility->facility_id = $request->facilityname; 
        $facility->typeOfdru = $request->typedru;
        $facility->Addressfacility = $request->addressfacility;
        $facility->reportfacility = $request->facility_id;
        $facility->typeofpatient = $request->typePatient;
        $facility->facilityName = $request->facilityname;
        $facility->save();
        
         $profile = ResuProfileInjury::find($request->profile_id_update);
      //  $profile = Profile::find($request->profile_id_update);

        if($profile){
          
            $unique_id = $request->fname.''.$request->mname.''.$request->lname.''.$request->suffix.''.$request->barangay.''.$user->muncity;
            $profile->unique_id = $unique_id;
            $profile->Hospital_caseno = $request->hospital_no;

            if ($request->reportfacilityId) {
                $profile->report_facilityId = $facility->facility_id;
            }
            $profile->fname = $request->fname;
            $profile->mname = $request->mname;
            $profile->lname = $request->lname;
            $profile->sex = $request->sex;
            $profile->dob = $request->dateBirth;
            $profile->province_id = $request->province;
            $profile->muncity_id = $request->municipal;
            $profile->barangay_id = $request->barangay;
            $profile->phicID = $request->phil_no;
            $profile->type_of_patient = $request->typePatient;
            $profile->name_of_encoder = $user->fname.''.$user->lname;
            $profile->save();
        }
        //dd($request->all());
        $pre_admission = ResuPreadmission::find($request->preadmission_id);
        if(!$pre_admission){
           $pre_admission = new ResuPreadmission();
        }
        $pre_admission->profile_id = $request->profile_id_update;
        $pre_admission->POIProvince_id = $request->provinceInjury;
        $pre_admission->POImuncity_id = $request->municipal_injury;
        $pre_admission->POIBarangay_id = $request->barangay_injury;
        $pre_admission->POIPurok = $request->purok_injury;
        $pre_admission->dateInjury = $request->date_injury;
        $pre_admission->timeInjury = $request->time_injury;
        $pre_admission->dateConsult = $request->date_consult;
        $pre_admission->timeConsult = $request->time_consult;
        $pre_admission->injury_intent = $request->injury_intent;
        $pre_admission->first_aid = $request->firstAidGive;
        $pre_admission->what = $request->druWhat;
        $pre_admission->bywhom = $request->druByWhom;
        $pre_admission->multipleInjury = $request->multiple_injured;
        $pre_admission->save();

        if($request->InjuredBurn){
            $nature = ResuNature_Preadmission::where('Pre_admission_id', $request->preadmission_id_update)
                    ->where('natureInjury_id', $request->InjuredBurn)
                    ->first();
           
            if(!$nature){
                $nature = new ResuNature_Preadmission();
            }
            if($request->preadmission_id_update){
                $nature->Pre_admission_id = $request->preadmission_id_update;
            }else{
                $nature->Pre_admission_id = $pre_admission->id;
            }
            $nature->natureInjury_id = $request->InjuredBurn;
            $nature->subtype = $request->Degree;
            $nature->details = $request->burnDetail;
            $nature->side = $request->burnside;

            $nature->save();
            
            $this->UpdateBodyParts($nature->natureInjury_id, $nature->Pre_admission_id, $request->input('burn_body_parts', []));
        }
       
        if($request->fractureNature) {
            $nature = ResuNature_Preadmission::where('Pre_admission_id', $request->preadmission_id_update)
                    ->where('natureInjury_id', $request->fractureNature)
                    ->first();
            
            if(!$nature){
                $nature = new ResuNature_Preadmission();
            }
            if($request->preadmission_id_update){
                $nature->Pre_admission_id = $request->preadmission_id_update;
            }else{
                $nature->Pre_admission_id = $pre_admission->id;
            }
            $nature->natureInjury_id = $request->fractureNature;
            $nature->subtype = $request->fracttype;
            $nature->details = $request->fracture_detail;
            $nature->side = $request->fracture_side;
    
            $nature->save();
            $this->UpdateBodyParts($nature->natureInjury_id, $nature->Pre_admission_id, $request->input('fracture_bodyparts', []));
        }

        if($request->Others_nature_injured){
            $nature = ResuNature_Preadmission::where('Pre_admission_id', $request->preadmission_id_update)
                ->where('natureInjury_id', $request->Others_nature_injured)
                ->first();

            if(!$nature){
                $nature = new ResuNature_Preadmission();
               
            }
            if($request->preadmission_id_update){
                $nature->Pre_admission_id = $request->preadmission_id_update;
            }else{
                $nature->Pre_admission_id = $pre_admission->id;
            }
            $nature->natureInjury_id = $request->Others_nature_injured;
            $nature->details = $request->other_nature_details;
            $nature->side = $request->side_others;
            $nature->save();

                $this->UpdateBodyParts($nature->natureInjury_id, $nature->Pre_admission_id, $request->input('body_parts_others', []));
        }

        $injuredcount = $request->input('injured_count');
        // $currentNatureInjuries = ResuNature_Preadmission::where('Pre_admission_id', $request->preadmission_id_update)
        //     ->pluck('natureInjury_id')
        //     ->toArray();

        for($i = 1; $i <= $injuredcount; $i++){
            if($request->has('nature' . $i) || $request->has('nature_details' . $i) || $request->has('sideInjured' . $i)){
            $nature = ResuNature_Preadmission::where('Pre_admission_id', $request->preadmission_id_update)
                    ->where('natureInjury_id', $request->input('nature'. $i))
                ->first();

                if(!$nature){
                    $nature = new ResuNature_Preadmission();
                }
                if($request->preadmission_id_update){
                $nature->Pre_admission_id = $request->preadmission_id_update;
                }else{
                    $nature->Pre_admission_id = $pre_admission->id;
                }
                $nature->natureInjury_id = $request->input('nature' . $i);
                $nature->details = $request->input('nature_details' . $i);
                $nature->side = $request->input('sideInjured' . $i);
                $nature->save();

                $this->UpdateBodyParts($nature->natureInjury_id, $nature->Pre_admission_id, $request->input('body_parts_injured' . $i, []));
            }
        }


        //external update
        if($request->ex_burn){
            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $request->preadmission_id_update)
                ->where('externalinjury_id', $request->ex_burn)
                ->first();
            if(!$external){
                $external = new Resuexternal_injury_preAdmission();
            }
            if($request->preadmission_id_update){
                $external->Pre_admission_id = $request->preadmission_id_update;
            }else{
                $external->Pre_admission_id = $pre_admission->id;
            }
            $external->externalinjury_id = $request->ex_burn;
            $external->subtype = $request->burn_type;
            $external->details = $request->exburnDetails;
            $external->save();
        }

        if($request->exDrowning){
            $external =  Resuexternal_injury_preAdmission::where('Pre_admission_id', $request->preadmission_id_update)
                ->where('externalinjury_id', $request->exDrowning)
                ->first();
            if(!$external){
                $external = new Resuexternal_injury_preAdmission();
            }
            if($request->preadmission_id_update){
                $external->Pre_admission_id = $request->preadmission_id_update;
            }else{
                $external->Pre_admission_id = $pre_admission->id;
            }
            $external->externalinjury_id = $request->exDrowning;
            $external->subtype = $request->drowningType;
            $external->details = $request->exdrowning_Details;
            $external->save();
        }

        if($request->externalTransport){
            $external =  Resuexternal_injury_preAdmission::where('Pre_admission_id', $request->preadmission_id_update)
                ->where('externalinjury_id', $request->externalTransport)
                ->first();
            
            if(!$external){
                $external = new Resuexternal_injury_preAdmission();
            }
            if($request->preadmission_id_update){
                $external->Pre_admission_id = $request->preadmission_id_update;
            }else{
                $external->Pre_admission_id = $pre_admission->id;
            }
            $external->externalinjury_id = $request->externalTransport;
            $external->details = $request->transport_details;
            $external->save();
        }

        $external_count = $request->external_count;
        for($i = 1; $i <= $external_count; $i++){
            if($request->has('external' . $i) || $request->has('external_details' . $i)){
                $externals = Resuexternal_injury_preAdmission::where('Pre_admission_id', $request->preadmission_id_update)
                    ->where('externalinjury_id', $request->input('external' . $i))
                    ->first();
                if(!$externals){
                    $externals = new Resuexternal_injury_preAdmission();
                }
                if($request->preadmission_id_update){
                    $externals->Pre_admission_id = $request->preadmission_id_update;
                }else{
                    $externals->Pre_admission_id = $pre_admission->id;
                }
                $externals->externalinjury_id = $request->input('external' . $i); 
                $externals->details = $request->input('external_details' . $i);
                $externals->save();
            }
        }
        //end update if external

        //for Transpart
        $this->UpdateTransport($request->externalTransport, $request, $pre_admission->id);

        //ResuInpatient
        if($request->hospital_data_second){
            $inpatient = ResuInpatient::where('id', $request->inPatient_id)
                ->first();
            if(!$inpatient){
                $inpatient = new ResuInpatient();

                $inpatient->hospitalfacility_id = $request->hospital_data_second;
                $inpatient->profile_id = $request->profile_id_update;
            }
            $inpatient->complete_Diagnose = $request->final_diagnose;
            $inpatient->Disposition = $request->disposition1;

            if(trim($request->disposition1) == 'Others'){
                $inpatient->details = $request->disposition_others_details;

            }elseif(trim($request->disposition1) == 'Transferred to Another facility/hospital'){
                $inpatient->details = $request->trans_facility_hos_details2;

            }else{
                $inpatient->details = null;
            }
            $inpatient->Outcome = $request->Outcome1;
            $inpatient->icd10Code_nature = $request->icd10_nature1;
            $inpatient->icd10Code_external = $request->icd10_external1;

            $inpatient->save();
        }else if($request->hospital_data){
            $Eropd = ResuErOpdBhsRhu::where('id', $request->Eropd_id)
                ->first();
            if(!$Eropd){
                $Eropd = new ResuErOpdBhsRhu();
                $Eropd->hospitalfacility_id = $request->hospital_data;
                $Eropd->profile_id = $request->profile_id_update;
            }
            $Eropd->hospitalfacility_id = $request->hospital_data;
            $Eropd->profile_id = $request->profile_id;
            $Eropd->transferred_facility = $request->Transferred;
            $Eropd->referred_facility = $request->Referred;
            $Eropd->originating_hospital = $request->name_orig;
            $Eropd->status_facility = $request->reashingFact;
            $Eropd->Ifalive = $request->ifAlive;
            $Eropd->mode_transport_facility = $request->mode_transport;
            $Eropd->other_details = $request->mode_others_details;
            if(trim($Eropd->mode_transport_facility) == "Others"){
            }else{
                $Eropd->other_details = null;
            }
            $Eropd->initial_impression = $request->Initial_Impression;
            $Eropd->icd10Code_nature = $request->icd10_nature;
            $Eropd->icd10Code_external = $request->icd10_external;
            $Eropd->disposition = $request->disposition;
            $Eropd->details = $request->trans_facility_hos_details;
            if(trim($Eropd->disposition) == "Transferred to Another facility/hospital"){
            }else{
                $Eropd->details = null;
            }
            $Eropd->outcome = $request->outcome;
            $Eropd->save();
       
        }
        return redirect()->route('patientInjury')
                 ->with('success', 'Patient injury record updated successfully');
    }


    private function UpdateBodyParts($natureInjury_id, $pre_admission_id, $Allbodyparts){
        $existing_bodyparts = Resunature_injury_bodyparts::where('preadmission_id', $pre_admission_id)
                ->where('nature_injury_id', $natureInjury_id)
                ->pluck('bodyparts_id')
                ->toArray();
        //dd($natureInjury_id,$pre_admission_id,  $Allbodyparts);
        $bodyPartsData = [];
        $processBodyParts = [];

        foreach($Allbodyparts as $bodyparts){
            if(!in_array($bodyparts, $existing_bodyparts)){
                $bodyPartsData[] = [
                'preadmission_id' => $pre_admission_id,
                'nature_injury_id' => $natureInjury_id,
                'bodyparts_id' => $bodyparts
                ];
            }
            $processedBodyParts[] = $bodyparts;
        }
            // Insert new body parts
            if (!empty($bodyPartsData)) {
                Resunature_injury_bodyparts::insert($bodyPartsData);
            }

            // Delete body parts that are no longer associated
            Resunature_injury_bodyparts::where('preadmission_id', $pre_admission_id)
            ->where('nature_injury_id', $natureInjury_id)
            ->whereNotIn('bodyparts_id', $processedBodyParts)
            ->delete();
    }

    private function UpdateTransport($transport_id, $request, $pre_admission_id){
   
        if($transport_id){

            $transport = ResuTransport::where('Pre_admission_id', $request->preadmission_id_update)
                ->first();
            if(!$transport){
             
                $transport = new ResuTransport();
            }
            $transport->transport_accident_id = $request->transport_accident_id;
            $transport->Vehicular_acc_type = $request->transport_collision;
            $transport->other_collision = $request->Othercollision;
            $transport->other_collision_details = $request->other_collision_details;

            if(trim($transport->other_collision) == "Others"){
            }else{
                $transport->other_collision_details = null;
            }
            if($request->preadmission_id_update){
                $transport->Pre_admission_id = $request->preadmission_id_update;
            }else{
                $transport->Pre_admission_id = $pre_admission_id;
            }
                $transport->xternal_injury_pread_id = $transport_id;
                $transport->PatientVehicle = $request->Patient_vehicle;
                $transport->PvOther_detail = $request->Patient_vehicle_others;
                if(trim($transport->PatientVehicle) == "others"){
                }else{
                    $transport->PvOther_detail = null;
                }
                $transport->positionPatient = $request->position_patient;
                $transport->ppother_detail = $request->position_other_details;
                if(trim($transport->positionPatient) == 'Others'){

                }else{
                    $transport->ppother_detail = null;
                }
                $transport->pofOccurence =$request->Occurrence;
                $transport->workplace_occurence_specify  = $request->workplace_occ_specify;
                $transport->pofOccurence_others = $request->Occurrence_others;

                if(trim($transport->pofOccurence) == "workplace"){
                
                }else{
                    $transport->workplace_occurence_specify = null;
                }
                if(trim($transport->pofOccurence) == 'Others'){
                }else{
                    $transport->pofOccurence_others = null;
                }


                $transport->activity_patient = $request->activity_patient;
                $transport->AP_others = $request->activity_patient_other;
                if(trim($transport->activity_patient) == "Others"){

                }else{
                    $transport->AP_others = null;
                }
                $transport->risk_factors = $request->risk_factors;
                $transport->rf_others = $request->rf_others;                
                if(trim($transport->risk_factors) == 'Others'){

                }else{
                    $transport->rf_others = null;
                }
              
                
                if($request->has('categsafe') || $request->has('safety_others_id')){
                    $safet_values = $request->input('categsafe', []);
                    $safety_ids = [];
        
                    foreach($safet_values as $safety_value){
                        $safety_ids[] = $safety_value;
                        if($safety_value == $request->safety_others_id) {
                            $transport->safety_others = $request->safeothers_details;
                        }
                    } 
                    $transport->safety = !empty($safety_ids) ? implode('-', $safety_ids) : '';

                } else {
                    return 'No safety data provided.';
                }

                $transport->save();

         }      

    }

    public function Deletenature(Request $req){

        $natureId = $req->input('nature_id');
        $preadmissionId = $req->input('preadmission_id');
        $category = $req->input('category');

        if($category == 'nature'){
            $nature_pread = ResuNature_Preadmission::where('Pre_admission_id', $preadmissionId )
            ->where('natureInjury_id', $natureId)
            ->first();

            if ($nature_pread) {
                $nature_pread->delete();
                // return response()->json(['message' => 'Nature deleted successfully']);
            }

            Resunature_injury_bodyparts::where('preadmission_id', $preadmissionId)
                ->where('nature_injury_id', $natureId)
                ->forceDelete();
        }else if($category == 'external'){
            $external_injured = Resuexternal_injury_preAdmission::where('Pre_admission_id', $preadmissionId)
            ->where('externalinjury_id', $natureId)
            ->first();

            if($external_injured){
                $external_injured->delete();
            } 
        }elseif($category == 'safety'){
            $transport_id = ResuTransport::where('Pre_admission_id', $preadmissionId)->pluck('id');
        
            $safetyTrans = ResuSafetyTransport::where('Transport_safety_id', $transport_id)
                ->where('safety_id', $natureId)
                ->first();
    
            if($safetyTrans){
                $safetyTrans->delete();
            }
        }elseif($category == "department"){
            
        }elseif($category == "in-patient"){

        }
        return response()->json($transport_id);

    }
    
}
