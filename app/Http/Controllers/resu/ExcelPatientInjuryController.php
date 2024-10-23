<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use DB;
use App\ResuReportFacility;
use App\Profile;
use App\ResuProfileInjury;
use App\ResuPreadmission;
use App\ResuNature_Preadmission;
use App\ResuNatureInjury;
use App\ResuExternalInjury;
use App\Resuexternal_injury_preAdmission;
use App\ResuTransportAccident;
use App\ResuTransport;
use App\ResuSafetyTransport;
use App\ResuSafety;
use App\ResuInpatient;
use App\ResuErOpdBhsRhu;
use App\ResuHospitalFacility;
use App\Province;
use App\Barangay;
use App\Muncity;
use App\Facility;
use App\Resunature_injury_bodyparts;
use Log;
use Carbon\Carbon;


class ExcelPatientInjuryController extends Controller
{
    //
    public function ViewImport(){
        return view('resu.importExcel.excelPatientInjury');
    }
    private $maxDistance = 3;

    private function findclosematch($items, $sheetValue, $maxDistance){
        $closestId = null;
        $sheetValue = strtolower(trim($sheetValue));

        foreach($items as $item){
            $distance = levenshtein(strtolower(trim($item->description)), $sheetValue);
            
            if($distance <= $maxDistance){
                $closestId = $item->id;
                break;
            }
        }
        return $closestId;

    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('file');
        
        Excel::load($file, function($reader) {
            $reader->each(function($sheet) {

                    $province = Province::select('id', 'description')->get();
                    $muncity = Muncity::select('id', 'description')->get();
                    $barangay = Barangay::select('id', 'description')->get();

                    $provinceId = $this->findclosematch($province,$sheet['permanent_province'], $this->maxDistance);
                    $muncityId = $this->findclosematch($muncity, $sheet['permanent_muncity'], $this->maxDistance);
                    $barangay_id = $this->findclosematch($barangay, $sheet['permanent_barangay'], $this->maxDistance);
                    
                    $provinceId_injury = $this->findclosematch($province, $sheet['place_of_injury_province'], $this->maxDistance);
                    $muncityId_injury = $this->findclosematch($muncity, $sheet['place_of_injury_muncity'], $this->maxDistance);
                    $barangayId_injury = $this->findclosematch($barangay, $sheet['place_of_injury_barangay'], $this->maxDistance);
                 
                    $facilities = Facility::select('id','name')->get();
                    $facility_id = null;
                    $report_selected_id = null;
                    $other_facility = null;

                    $facility_name = strtolower(trim($sheet['nameofreportingfacility']));
                    
                    foreach($facilities as $fact){
                        $report_factname = strtolower(trim($fact->name));
                        if($report_factname == $facility_name){
                            $facility_id = $fact->id;
                            break; // exit loop once a match is found
                        } else {
                            $other_facility = $facility_name;
                        }
                    }
                    
                    $reportfacility = ResuReportFacility::where('facility_id', $facility_id)->first();
                    $existingfact = ResuReportFacility::where('others', $other_facility)->first();
                
                    if (!$reportfacility) {
                        $reportfacility = new ResuReportFacility();
                        $reportfacility->facility_id = $facility_id;
                    }
           
                    if ($existingfact) {
                        
                    } else {

                        if (!$facility_id && $other_facility ) {
                            $reportfacility = new ResuReportFacility();
                            $reportfacility->others = $other_facility;
                        }
                    }
        
                    $reportfacility->typeOfdru = $sheet['typeofdru'];
                    $reportfacility->Addressfacility = $sheet['addressofdru'];
                    $reportfacility->save();
                    
                    $facilityIdToUse = $existingfact->id ?? $reportfacility->id;

                    $unique_id = $sheet['firstname'] . '' . $sheet['middlename'] . '' . $sheet['lastname'] . '' . $barangay_id . '' . $muncityId;
                    $existingProfile = Profile::where('unique_id', $unique_id)->first();
        
                    if ($existingProfile) {
                        $profile = $existingProfile;
                    } else {
                        $profile = new Profile();
                        $profile->unique_id = $unique_id;
                    }

                    // Update profile details
                    $selectedProfile = [
                        'Hospital_caseno' => $sheet['hospitalcaseno'],
                        'report_facilityId' =>  $facilityIdToUse , 
                        'fname' => $sheet['firstname'],
                        'mname' => $sheet['middlename'] ?? '',
                        'lname' => $sheet['lastname'],
                        'sex' => $sheet['sex'],
                        'dob' => \Carbon\Carbon::parse($sheet['dateofbirth']),
                        'province_id' => $provinceId ?? '',
                        'muncity_id' => $muncityId ?? '',
                        'barangay_id' => $barangay_id ?? '',
                        'phicID' => $sheet['philhealthnumber'] ?? '',
                        'nameof_encoder' => $sheet['nameofencoder'] ?? '',
                        'designation' => $sheet['designationofencoder'] ?? '',
                        'contact' => $sheet['contactnumberofencoder'] ?? '',
                        'typeofpatient' => $sheet['typeofpatient'] ?? '',
                        
                    ];

                    $profile->fill($selectedProfile);
                    $profile->save();
                    

                    $dateAndtime = \Carbon\Carbon::parse($sheet['date_and_time_of_injury']);
                    $dateInjury= $dateAndtime->format('d/m/y');
                    $timeInjury = $dateAndtime->format('h:i:s a');

                    $dateAndtimeConsult = \Carbon\Carbon::parse($sheet['date_and_time_of_injury']);
                    $dateconsult = $dateAndtimeConsult->format('d/m/y');
                    $timeconsult = $dateAndtimeConsult->format('h:i:s a');

                    $pre_admission = ResuPreadmission::where('profile_id', $existingProfile->id)->first();
                    if($pre_admission){
                       
                    }else{
                        $pre_admission = new ResuPreadmission();
                        $pre_admission->profile_id = $profile->id;
                    }
                        $pre_admission->POIProvince_id = $provinceId_injury ?? '';
                        $pre_admission->POImuncity_id = $muncityId_injury ?? '';
                        $pre_admission->POIBarangay_id = $barangayId_injury ?? '';
                        $pre_admission->POIPurok = $sheet['purok'];
                        $pre_admission->dateInjury = $dateInjury;
                        $pre_admission->timeInjury = $timeInjury;
                        $pre_admission->dateConsult = $dateconsult;
                        $pre_admission->timeConsult = $timeconsult;
                        $pre_admission->injury_intent = $sheet['injuryintent'];
                        $pre_admission->first_aid = $sheet['firstaidgiven'];
                        $pre_admission->what = $sheet['whatfirstaidwasgiven'];
                        $pre_admission->bywhom = $sheet['whogavethefirstaid'];
                        $pre_admission->multipleInjury = $sheet['multipleinjury'];
                        $pre_admission->save();
                   

                    $abrasion = null;
                    $avulsion = null;
                    $burn = null;
                    $concussion = null;
                    $contusion = null;
                    $fracture = null;
                    $openwound = null;
                    $traumaAmputation = null;
                    $Others = null;

                    if($sheet['abrasion'] == 1){
                        $abrasion = strtolower(trim("abrasion"));
                    }
                    if($sheet['avulsion'] == 1){
                        $avulsions = strtolower(trim("avulsion"));
                    }
                    if($sheet['burn'] == 1){
                        $burn = strtolower("burn");
                    }
                    if($sheet['concussion'] == 1){
                        $concussion = strtolower(trim("concussion"));
                    }
                    if($sheet['contusion'] == 1){
                        $contusion = strtolower(trim("contusion"));
                    }
                    if($sheet['fracture'] == 1){
                        $fracture = strtolower(trim("fracture"));
                    }
                    if($sheet['openwound'] == 1){
                        $openwound = strtolower(trim("Open Wound"));
                    }
                    if($sheet['traumaticamputation'] == 1){
                        $traumaAmputation = strtolower(trim("Traumatic Amputation"));
                    }
                    if($sheet['others'] == 1){
                        $Others = strtolower(trim("Others"));
                    }
                   // dd(compact('abrasion', 'avulsion', 'burn', 'concussion', 'contusion', 'fracture', 'openwound', 'traumaAmputation', 'Others'));

                   $nature_injury = ResuNatureInjury::select('id', 'name')->get();

                    $nature_id_abrasion = null;
                    $nature_id_avulsion = null;
                    $nature_id_burn = null;
                    $nature_id_concussion = null;
                    $nature_id_contusion = null;
                    $nature_id_fracture = null;
                    $nature_id_openwound = null;
                    $nature_id_traumatic = null;
                    $nature_id_others = null;
                    foreach($nature_injury as $nature){
                        $NatureName = strtolower(trim($nature->name));
                       if($NatureName == $abrasion){
                        $nature_id_abrasion = $nature->id;
                       }
                       if( $NatureName == $avulsion){
                        $nature_id_avulsion = $nature->id;
                       }
                       if($NatureName ==  $burn){
                        $nature_id_burn = $nature->id;
                       }
                       if($NatureName == $concussion){
                        $nature_id_concussion = $nature->id;
                       }
                       if($NatureName == $contusion){
                        $nature_id_contusion = $nature->id;
                       }
                       if($NatureName == $fracture){
                        $nature_id_fracture = $nature->id;
                       }
                       if($NatureName == $openwound){
                        $nature_id_openwound = $nature->id;
                       }  
                       if($NatureName == $traumaAmputation){
                        $nature_id_traumatic = $nature->id;
                       }
                       if($NatureName == $Others){
                        $nature_id_others = $nature->id;
                       }                  
                    }
                    // Debugging: Check initial assignment
                    // dd(compact('openwound','nature_id_abrasion', 'nature_id_avulsion', 'nature_id_burn', 'nature_id_concussion', 'nature_id_contusion', 'nature_id_fracture', 'nature_id_openwound', 'nature_id_traumatic', 'nature_id_others'));
                    $details = [
                        'abrasion' => $sheet['abrasion_details'],
                        'avulsion' => $sheet['avulsion_details'],
                        'burn' => $sheet['burn_details'],
                        'burnsite' => $sheet['burnsite'],
                        'concussion' => $sheet['concussion_details'],
                        'contusion' => $sheet['contusion_details'],
                        'fracture' => $sheet['fracture_details'],
                        'fracturetype' => $sheet['fracturetype_details'],
                        'open_wounds' => $sheet['openwound_details'],
                        'traumaticamputation' => $sheet['traumaticamputation_details'],
                        'others' => $sheet['other_details']
                    ];
                    
                    // Save nature_Pread records with only the natures_id and details
                    if ($nature_id_abrasion) {
                        $nature_Pread = ResuNature_Preadmission::where('Pre_admission_id', $pre_admission->id)
                            ->where('natureInjury_id', $nature_id_abrasion)->first();
                        if($nature_Pread){
                         
                        }else{
                            $nature_Pread = new ResuNature_Preadmission();
                        }
                        $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $nature_Pread->natureInjury_id = $nature_id_abrasion;
                        $nature_Pread->details = $details['abrasion'];
                        $nature_Pread->save();
                    }
                    if ($nature_id_avulsion) {
                        $nature_Pread = ResuNature_Preadmission::where('Pre_admission_id', $pre_admission->id)
                            ->where('natureInjury_id', $nature_id_avulsion)->first();
                        if($nature_Pread){

                        }else{
                            $nature_Pread = new ResuNature_Preadmission();
                        }
                        $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $nature_Pread->natureInjury_id = $nature_id_avulsion;
                        $nature_Pread->details = $details['avulsion'];
                        $nature_Pread->save();
                    }
                    if ($nature_id_burn) {
                        $nature_Pread = ResuNature_Preadmission::where('Pre_admission_id', $pre_admission->id)
                            ->where('natureInjury_id', $nature_id_burn)->first();
                        if($nature_Pread){

                        }else{
                            $nature_Pread = new ResuNature_Preadmission();
                        }
                        $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $nature_Pread->natureInjury_id = $nature_id_burn;
                        $nature_Pread->details = $details['burn'] . ' ' .  $details['burnsite'];
                        $nature_Pread->save();
                    }
                    if ($nature_id_concussion) {
                        $nature_Pread = ResuNature_Preadmission::where('Pre_admission_id', $pre_admission->id)
                            ->where('natureInjury_id', $nature_id_concussion)->first();
                        if($nature_Pread){

                        }else{
                            $nature_Pread = new ResuNature_Preadmission();
                        }
                        $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $nature_Pread->natureInjury_id = $nature_id_concussion;
                        $nature_Pread->details = $details['concussion'];
                        $nature_Pread->save();
                    }
                    if ($nature_id_contusion) {
                        $nature_Pread = ResuNature_Preadmission::where('Pre_admission_id', $pre_admission->id)
                             ->where('natureInjury_id', $nature_id_contusion)->first();
                        if($nature_Pread){

                        }else{
                            $nature_Pread = new ResuNature_Preadmission();
                        }
                       
                        $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $nature_Pread->natureInjury_id = $nature_id_contusion;
                        $nature_Pread->details = $details['contusion'];
                        $nature_Pread->save();
                    }
                    if ($nature_id_fracture) {
                        $nature_Pread = ResuNature_Preadmission::where('Pre_admission_id', $pre_admission->id)
                            ->where('natureInjury_id', $nature_id_fracture)->first();
                        if($nature_Pread){
                            
                        }else{
                            $nature_Pread = new ResuNature_Preadmission();
                        }
                        
                        $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $nature_Pread->natureInjury_id = $nature_id_fracture;
                        $nature_Pread->details = $details['fracture'] . ' ' . $details['fracturetype'];
                        $nature_Pread->save();
                    }
                    if ($nature_id_openwound) {
                        $nature_Pread = ResuNature_Preadmission::where('Pre_admission_id', $pre_admission->id)
                            ->where('natureInjury_id', $nature_id_openwound)->first();
                        if($nature_Pread){

                        }else{
                            $nature_Pread = new ResuNature_Preadmission();
                        }

                        $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $nature_Pread->natureInjury_id = $nature_id_openwound;
                        $nature_Pread->details = $details['open_wounds'];
                        $nature_Pread->save();
                    }
                    if ($nature_id_traumatic) {
                        $nature_Pread = ResuNature_Preadmission::where('Pre_admission_id', $pre_admission->id)
                            ->where('natureInjury_id', $nature_id_traumatic)->first();
                        if($nature_Pread){

                        }else{
                            $nature_Pread = new ResuNature_Preadmission();
                        }
                        $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $nature_Pread->natureInjury_id = $nature_id_traumatic;
                        $nature_Pread->details = $details['traumaticamputation'];
                        $nature_Pread->save();
                    }
                    if ($nature_id_others) {
                        $nature_Pread = ResuNature_Preadmission::where('Pre_admission_id', $pre_admission->id)
                            ->where('natureInjury_id', $nature_id_others)->first();
                        if($nature_Pread){

                        }else{
                            $nature_Pread = new ResuNature_Preadmission();
                        }
                        $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $nature_Pread->natureInjury_id = $nature_id_others;
                        $nature_Pread->details = $details['others'];
                        $nature_Pread->save();
                    }

                    //external Injury
                    $bite_stings = null;
                    $externalBurns = null;
                    $chemicalSub = null;
                    $contactObject  = null;
                    $drowning = null;
                    $exposureNature = null;
                    $fall = null;
                    $firecreacker = null;
                    $sexualAbuse = null;
                    $gunshot = null;
                    $strangulation = null;
                    $mauling_assult = null;
                    $transport = null;
                    $external_others = null;

                    $external = ResuExternalInjury::select('id','name')->get();
                    
                    if($sheet['bites_stings'] == 1){
                        $bite_stings = strtolower(trim("Bites/stings/Specify animal/insect"));
                    }
                    if($sheet['externalburns'] == 1){
                        $externalBurns = strtolower(trim('Burns'));
                    }
                    if($sheet['chemicalsubstance'] == 1){
                        $chemicalSub = strtolower(trim("Chemical/Substance, specify"));
                    }
                    if($sheet['contact_objects'] == 1){
                        $contactObject = strtolower(trim("Contact with sharp Objects, specify object"));
                    }
                    if($sheet['drowning'] == 1){
                        $drowning = strtolower(trim("drowning"));
                    }
                    if($sheet['exposure_nature'] == 1){
                        $exposureNature = strtolower(trim("Exposure to forces of nature"));
                    }
                    if($sheet['externalfall'] == 1){
                        $fall = strtolower(trim("fall"));
                    }
                    if($sheet['firecracker'] == 1){
                        $firecreacker = strtolower(trim("Firecracker, specify type/s"));
                    }
                    if($sheet['externalsexualabuse'] == 1){
                        $sexualAbuse = strtolower(trim("Sexual Assault/Sexual Abure/Rape (Alleged)"));
                    }
                    if($sheet['external_gunshot'] == 1){
                        $gunshot = strtolower(trim("Gunshot, Specify Weapon"));
                    }
                    if($sheet['external_strangulation'] == 1){
                        $strangulation = strtolower(trim("Hanging/Strangulation"));
                    }
                    if($sheet['external_assault'] == 1){
                        $mauling_assult = strtolower(trim("Mauling/Assault"));
                    }
                    if($sheet['externaltransport'] == 1){
                        $transport = strtolower(trim("Transport/Vehicular Accident"));
                    }
                    if($sheet['external_others'] == 1){
                        $external_others = strtolower(trim("others"));
                    }

                //    dd(compact('bite_stings', 'externalBurns', 'chemicalSub', 'contactObject', 'drowning', 'exposureNature', 'fall', 'firecreacker ', 
                //    'sexualAbuse','gunshot','strangulation','assult','transport','external_others'));
                    $exId_bites = null;
                    $exId_burns = null;
                    $exId_chemical = null;
                    $exId_contact = null;
                    $exId_drowning = null;
                    $exId_exposure = null;
                    $exId_fall = null;
                    $exId_firecracker = null;
                    $exId_sexaulAbure = null;
                    $exId_gunshot = null;
                    $exId_strangulation = null;
                    $exId_maulingAssault = null;
                    $exId_transport = null;
                    $exId_others = null;
                    foreach($external as $ex){
                        $externalName = strtolower(trim($ex->name));

                        if($externalName == $bite_stings){
                            $exId_bites = $ex->id;
                        }
                        if($externalName == $externalBurns){
                            $exId_burns = $ex->id;
                        }
                        if($externalName == $chemicalSub){
                            $exId_chemical = $ex->id;
                        }
                        if($externalName == $contactObject){
                            $exId_contact = $ex->id;
                        }
                        if($externalName == $drowning){
                            $exId_drowning = $ex->id;
                        }
                        if($externalName == $exposureNature){
                            $exId_exposure = $ex->id;
                        }

                        if($externalName == $fall){
                            $exId_fall = $ex->id;
                        }
                        if($externalName == $firecreacker){
                            $exId_firecracker = $ex->id;
                        }

                        if($externalName ==  $sexualAbuse){
                            $exId_sexaulAbure = $ex->id;
                        }
                        if($externalName ==  $gunshot){
                            $exId_gunshot = $ex->id;
                        }
                        if($externalName == $strangulation){
                            $exId_strangulation = $ex->id;
                        }
                        if($externalName ==  $mauling_assult){
                            $exId_maulingAssault = $ex->id;
                        }
                        if($externalName ==  $transport){
                            $exId_transport = $ex->id;
                        }
                        if($externalName == $external_others){
                            $exId_others = $ex->id;
                        }
                    }

                    // dd(compact('exId_bites', 'exId_burns', 'exId_chemical', 'exId_contact', 'exId_drowning', 'exId_exposure', 'exId_fall', 'exId_firecracker', 
                    // 'exId_sexaulAssult','exId_gunshot','exId_strangulation','exId_transport','exId_others'));

                        $ex_details = [
                            'bite' => $sheet['bite_sting_details'],
                            'burn' => $sheet['external_burns_details'],
                            'chemical' => $sheet['chemicalsubstance_details'],
                            'object' => $sheet['contact_objects_details'],
                            'drowning' => $sheet['externaldrowningdetails'],
                            'exposure' => $sheet['exposure_details'],
                            'fall' => $sheet['fall_details'],
                            'firecreacker' => $sheet['firecracker_details'],
                            'gunshot' => $sheet['gunshot_details'],
                            'strangulation' => $sheet['strangulation_details'],
                            'mauling_assault' => $sheet['maulingassault_details'],
                            'transport' => $sheet['transport_details'],
                            'others_det' => $sheet['externalothers_details'],
                        ];

                        if($exId_bites){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_bites)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_bites;
                            $external->details = $ex_details['bite'];
                            $external->save();
                        }
                        if($exId_burns){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_burns)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_burns;
                            $external->details = $ex_details['burn'];
                            $external->save();
                        }
                        if($exId_chemical){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_chemical)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_chemical;
                            $external->details = $ex_details['chemical'];
                            $external->save();
                        }
                        if($exId_contact){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_contact)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_contact;
                            $external->details = $ex_details['object'];
                            $external->save();
                        }
                        if($exId_drowning){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_drowning)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_drowning;
                            $external->details = $ex_details['drowning'];
                            $external->save();
                        }

                        if($exId_exposure){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_exposure)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_exposure;
                            $external->details = $ex_details['exposure'];
                            $external->save();
                        }
                        if($exId_fall){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_fall)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_fall;
                            $external->details = $ex_details['fall'];
                            $external->save();
                        }
                        

                        if($exId_firecracker){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_firecracker)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_firecracker;
                            $external->details = $ex_details['firecreacker'];
                            $external->save();
                        }

                        if($exId_sexaulAbure){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_sexaulAbure)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_sexaulAbure;
                            $external->save();
                        }

                        if($exId_gunshot){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_gunshot)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_gunshot;
                            $external->details = $ex_details['gunshot'];
                            $external->save();
                        }

                        if($exId_strangulation){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_strangulation)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_strangulation;
                            $external->details = $ex_details['strangulation'];
                            $external->save();
                        }

                        if($exId_maulingAssault){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_maulingAssault)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_maulingAssault;
                            $external->details = $ex_details['mauling_assault'];
                            $external->save();
                        }

                        if($exId_transport){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_transport)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_transport;
                            $external->details = $ex_details['transport'];
                            $external->save();
                            $this->ImportTransport($sheet,$pre_admission->id, $external->id);
                        }

                        if($exId_others){
                            $external = Resuexternal_injury_preAdmission::where('Pre_admission_id', $pre_admission->id)
                                ->where('externalinjury_id', $exId_others)->first();
                            if($external){

                            }else{
                                $external = new Resuexternal_injury_preAdmission();
                            }

                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_others;
                            $external->details = $ex_details['others_det'];
                            $external->save();
                        }

                        $this->ImportTypePatient($sheet, $profile->id, $existingProfile->id);
            });
        });
    }

    private function ImportTransport($sheet, $pre_admission_id, $transport_id){

        if($transport_id){

            $transport_acc_type = ResuTransportAccident::select('id', 'description')->get();

            $transport_acc_id = null;

            foreach($transport_acc_type as $acc_type){
                if(strtolower(trim($acc_type->description)) == strtolower(trim($sheet['transportvehicularaccidents_type']))){
                    $transport_acc_id = $acc_type->id;
                }
            }
            
            $OF_Alcohol_liquor = null;
            $OF_usingMobile = null;
            $OF_incident_sleepy = null;
            $OF_smoking = null;
            $OF_Others = null;

            if($sheet['otherriskfactors_incident_alcohol_liquor'] == 1){
                $OF_Alcohol_liquor = "Alcohol/liquor";
            }
            if($sheet['otherRiskfactors_incident_usingmobilephone'] == 1){
                $OF_usingMobile = "Using Mobile Phone";
            }
            if($sheet['Otherriskfactors_incident_sleepy'] == 1){
                
                $OF_incident_sleepy = "Sleepy";
            
            }
            if($sheet['otherriskfactors_the_incident_smoking'] == 1){
                $OF_smoking = "Smooking";
            }
            if($sheet['otherriskfactors_incident_others'] == 1){
                $OF_Others = "Others";
            }

            $transport = ResuTransport::where('Pre_admission_id', $pre_admission_id)->first();

            if($transport){

            }else{
                $transport = new ResuTransport();
            }

            $transport->Pre_admission_id = $pre_admission_id;
            $transport->transport_accident_id = $transport_acc_id;
            $transport->Vehicular_acc_type = $sheet['vehicularaccidenttype'];
            $transport->PatientVehicle = $sheet['vehiclesinvolved_patientvehicle'];
            $transport->PvOther_detail = $sheet['patientvehicle_others_details'];
            $transport->other_collision = $sheet['vehicles_involved_othervehicle_objectinvolved'];
            $transport->other_collision_details = $sheet['other_vehicleobjectinvolved_details'];
            $transport->positionPatient = $sheet['positionofpatient'];
            $transport->ppother_detail = $sheet['pop_others_details'];
            $transport->pofOccurence = $sheet['placeofoccurrence'];
            $transport->workplace_occurence_specify = $sheet['occurrence_workplace_specify'];
            $transport->pofoccurence_others = $sheet['occurence_others_details'];
            $transport->activity_patient = $sheet['activity_ofthe_patienttime_ofincident'];
            $transport->AP_others = $sheet['others_activity_patient_incident_details'];
            $transport->risk_factors = $sheet['otherriskfactors_timeofthe_incident'];
            if($OF_Alcohol_liquor){
                $transport->risk_factors = $OF_Alcohol_liquor;
            }elseif($OF_usingMobile){
                $transport->risk_factors = $OF_usingMobile;
            }elseif($OF_incident_sleepy){
                $transport->risk_factors = $OF_incident_sleepy;
            }elseif($OF_smoking){
                $transport->risk_factors = $OF_smoking;
            }elseif($OF_Others){
                $transport->risk_factors = $OF_Others;
                $transport->rf_others = $sheet['risk_factors_others_details'];
            }
            

            $safety_none = null;
            $safety_childseat = null;
            $safety_aribag = null;
            $safety_lifeVest = null;
            $safety_helmet = null;
            $safety_seatbelt = null;
            $safety_unknown = null;
            $safety_others = null;

            if($sheet['safety_none'] == 1){
                $safety_none = strtolower(trim("None"));
            }
            if($sheet['safety_childseat'] == 1){
                $safety_childseat = strtolower(trim("Childseat"));
            }
            if($sheet['safety_airbag'] == 1){
                $safety_aribag = strtolower(trim("Airbag"));
            }
            if($sheet['safety_lifevest_lifejacket_flotationdevice'] == 1){
                $safety_lifeVest = strtolower(trim("Lifevest/Lifejacket/flotation device"));
            }
            if($sheet['safety_helmet'] == 1){
                $safety_helmet = strtolower(trim("Helmet"));
            }
            if($sheet['safety_seatbelt'] == 1){
                $safety_seatbelt = strtolower(trim("Seatbelt"));
            }
            if($sheet['safety_unknown'] == 1){
                $safety_unknown = strtolower(trim("Unknown"));
            }
            if($sheet['safety_others'] == 1){
                $safety_others = strtolower(trim("Others"));
            }

            $safeId_none = null;
            $safeId_childeseat = null;
            $safeId_aribag = null;
            $safeId_lifevest = null;
            $safeId_helmet = null;
            $safaId_seatbelt = null;
            $safeId_unknown = null;
            $safeId_others = null;

            $safety = ResuSafety::select('id','name')->get();

            foreach($safety as $safe){

                $safename = strtolower(trim($safe->name));

                if($safename == $safety_none){
                    $safeId_none = $safe->id;
                }
                if($safename == $safety_childseat){
                    $safeId_childeseat = $safe->id;
                }
                if($safename == $safety_aribag){
                    $safeId_aribag = $safe->id;
                }
                if($safename == $safety_lifeVest){
                    $safeId_lifevest = $safe->id;
                }
                if($safename == $safety_helmet){
                    $safeId_helmet = $safe->id;
                }
                if($safename == $safety_seatbelt){
                    $safaId_seatbelt = $safe->id;
                }
                if($safename == $safety_unknown){
                    $safeId_unknown = $safe->id;
                }
                if($safename == $safety_others){
                    $safeId_others = $safe->id;
                }
            }
   
            $transport->safety = implode('-', [
                $safeId_none,
                $safeId_childeseat,
                $safeId_aribag,
                $safeId_lifevest,
                $safeId_helmet,
                $safaId_seatbelt,
                $safeId_unknown,
                $safeId_others,
            ]);

            $transport->save();
        }

    }

    private function ImportTypePatient($sheet, $profile_id, $existingProfile_id){

        $typeOfPatient = ResuHospitalFacility::select('id','category_name')->get();
        $type_patientId = null;
        
        foreach($typeOfPatient as $patient){

            $patientName = strtolower(trim($patient->category_name));
            $sheetType = strtolower(trim($sheet['typeofpatient_hospital_facility']));

            if(strpos($patientName, $sheetType) !== false || strpos($sheetType, $patientName) !== false){
               $type_patientId = $patient->id;
            }
        }
  
        $transferred = null;
        if( strtolower(trim($sheet['transferred_froman_other_hospital_facility'])) == strtolower(trim('No'))){
            $transferred  = 0;
        }else{
            $transferred  = 1;
        }
        $referred = null;
        if(strtolower(trim($sheet['referred_hospital_facilityforlaboratory'])) == strtolower(trim('No'))){
            $referred = 0;
        }else{
            $referred = 1;
        }

        if($type_patientId == 1){
            $ErOPD = ResuErOpdBhsRhu::where('profile_id', $existingProfile_id)->first();

            if($ErOPD){
                $ErOPD->profile_id = $existingProfile_id;
            }else{
                $ErOPD = new ResuErOpdBhsRhu();
                $ErOPD->profile_id = $profile_id;
            }

            $ErOPD->hospitalfacility_id = $type_patientId;
            $ErOPD->transferred_facility = $transferred;
            $ErOPD->referred_facility = $referred;
            $ErOPD->originating_hospital = $sheet['name_originating_hospital_physician'];
            $ErOPD->status_facility = $sheet['status_upon_reaching_facility'];
            $ErOPD->ifAlive = $sheet['ifalive'];
            $ErOPD->mode_transport_facility = $sheet['modeoftransport_hospital_facility'];
            $ErOPD->other_details = $sheet['others_modeof_transport_details'];
            $ErOPD->initial_impression = $sheet['initialimpression'];
            $ErOPD->icd10Code_nature = $sheet['icd_10code_natureinjury'];
            $ErOPD->icd10Code_external = $sheet['icd_10codes_external_causeofinjury'];
            $ErOPD->disposition = $sheet['disposition'];
            $ErOPD->details = $sheet['specifyfacilitytransferredto'];
            $ErOPD->outcome = $sheet['outcome'];
            $ErOPD->save();
        }
        if($type_patientId == 2){
            $Inpatient = ResuInpatient::where('profile_id', $existingProfile_id)->first();
            if($Inpatient){
                $Inpatient->profile_id = $existingProfile_id;
            }else{
                $Inpatient = new ResuInpatient();
                $Inpatient->profile_id = $profile_id;
            }

            $Inpatient->hospitalfacility_id = $type_patientId;
            $Inpatient->complete_Diagnose = $sheet['initial_admitting_final_diagnosis'];
            $Inpatient->Disposition = $sheet['disposition_inpatient'];
            if($sheet['facilitytransferedto']){
                $Inpatient->details = $sheet['facilitytransferedto'];
            }else{
                $Inpatient->details = $sheet['inpatient_others_details'];
            }
            $Inpatient->Outcome = $sheet['inpatient_outcome'];
            $Inpatient->icd10Code_nature = $sheet['inpatient_icd_10codes_natureofinjury'];
            $Inpatient->icd10Code_external = $sheet['inpatient_icd10_external_caseofinjury'];
            $Inpatient->save();
        }
    }

    
    public function exportCSV()
        {
            $profile = ResuProfileInjury::with(
                'facility',
                'reportfacility',
                'resuEropdbhsrhu',
                'resuInpatient',
                'preadmission.natureInjuryPreadmissions.natureInjury',
                'preadmission.natureInjuryPreadmissions.bodyParts.bodyPart',
                'preadmission.externalPreadmissions.externalInjury',
                'preadmission.transport.safetyRecord.safetyname',
            )
            ->get();
            
            // $latestInjuries = collect(DB::table('resunature_injury_preadmission')
            //     ->select('Pre_admission_id', 'natureInjury_id', 'subtype', 'updated_at')
            //     ->groupBy('Pre_admission_id')
            //     ->orderBy('updated_at', 'desc')
            //     ->get());

            // \Log::info($profile); // Check your log file
            //  dd($profile);

            $csvData = [];

            // Add headers to CSV
            $csvData[] = [
               'Hospital CaseNo', 'Fname', 'Mname', 'Lname', 'Suffix', 'Age', 'Sex', 'DOB', 'Permanent Province/HUC address', 'Permanent Municipal Acddress', 'Permanent Barangay address', 'Place Injury',
               'Injury Intent','First Aid','What','By Whom','Multiple Injuries','ER/OPD/BHS/RHU Transferred Facility', 'ER/OPD/BHS/RHU Referred Facility', 'ER/OPD/BHS/RHU Originating Hospital',
               'ER/OPD/BHS/RHU Status Facility','ER/OPD/BHS/RHU If Alive', 'ER/OPD/BHS/RHU Mode of Transport','ER/OPD/BHS/RHU Other Details','ER/OPD/BHS/RHU Initial Impression', 'ER/OPD/BHS/RHU ICD10 Code Nature', 'ER/OPD/BHS/RHU ICD10 Code External',
               'ER/OPD/BHS/RHU Disposition','ER/OPD/BHS/RHU Details','ER/OPD/BHS/RHU Outcome',
               'In-Patient Complete Diagnose', 'In-Patient Disposition', 'In-Patient Details', 'In-Patient Outcome',  'In-Patient ICD10 Code Nature',  'In-Patient ICD10 Code External',
                'Preadmission_ID',
               'Abrasions','Details','Body Parts',
               'Avulsion', 'Details', 'Body Parts',
               'Concussion', 'Details', 'Body Parts',
               'Contusion', 'Details', 'Body Parts',
               'Open Wound', 'Details', 'Body Parts',
               'Traumatic Amputation', 'Details', 'Body Parts',
               'Burn','Degree SubType',
               'Fracture','SubType',
               //external injuries 
               'Bites/stings/Specific animal/Insect', 'Details',
               'Burns','Subtype',
               'Chemical/Substance, specify','Details',
               'Contact with sharp Objects, specify object','Details',
               'Drowning: Type/Body of Water','Details',
               'Exposure to Forces of Nature','Details',
               'Fall','Details',
               'Firecracker, specify type/s','Details',
               'Sexual Assault/Sexual Abuse/Rape (Alleged)','Details',
               'Others, Specify','Details',
               'Gunshot, specify Weapon','Details',
               'Hanging/Strangulation','Details',
               'Mauling/Assaults','Details',
               'Transport/Vehicular Accident',
               'Vehicular Type Accident',
               'Other Collision',
               'Other Collision Details',
               'Patient Vehicle',
               'Patient Vehicle Details',
               'Position Patient',
               'Position Patient Details',
               'Workplace Specify',
               'Place of Occurence',
               'Place of Occurence  Details',
               'Activity of Patient', 
               'Activity of Patient Details',
               'Other Risk Factors',     
               'Others Risk Factors Details',  
               'Safety',
               'Phil ID', 'Facility Code','Facility Name', 'DRU','Facility Address', 'Name of the Encoder', 'Date And Time Injury','Updated at'
            ];

            // Iterate through the data and prepare the CSV rows
            foreach ($profile as $p) {

                $dob = Carbon::parse($p->dob);
                // $age = $dob->diffInYears(Carbon::now());
                $age = $this->calculateAge($p->dob);

             
                        // Access facility and related facility address
                        $facilityName = $p->facility ? $p->facility->name : 'N/A';
                        $facilityCode = $p->facility ? $p->facility->facility_code : 'N/A';  // Assuming facility_code is a field in the Facility model
                        $facilityaddress = $p->facility && $p->facility->address ? $p->facility->address : 'N/A';
                        $facilityType = $p->facility && $p->facility->hospital_type ? $p->facility->hospital_type: 'N/A';
                        
                        // Check if suffix is empty, and if so, set to 'N/A'
                        $suffix = $p->suffix ? $p->suffix : 'N/A';

                        // Eropdbhsrhu
                        $transferredFac = $p->resuEropdbhsrhu 
                        ? ($p->resuEropdbhsrhu->transferred_facility == 1 ? 'Yes' : 'No') 
                        : 'N/A';
                    
                         $referredFac = $p->resuEropdbhsrhu 
                        ? ($p->resuEropdbhsrhu->referred_facility == 1 ? 'Yes' : 'No') 
                        : 'N/A';

                        $originatedHos = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->originating_hospital : 'N/A';
                        $statusFacility = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->status_facility : 'N/A';
                        $ifAlive = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->Ifalive : 'N/A';
                        $modeTransport = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->mode_transport_facility : 'N/A';
                        $otherDetails = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->other_details : 'N/A';
                        $initialImpression = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->initial_impression : 'N/A';
                        $icdCodeNature = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->icd10Code_nature : 'N/A';
                        $icdCodeExternal = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->icd10Code_external : 'N/A';
                        $disposition = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->disposition : 'N/A';
                        $details = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->details : 'N/A';
                        $outcome = $p->resuEropdbhsrhu ? $p->resuEropdbhsrhu->outcome : 'N/A';

                        // In Patient
                        $diagnose = $p->resuInpatient ?$p->resuInpatient->complete_Diagnose: 'N/A';
                        $disposition = $p->resuInpatient ?$p->resuInpatient->Disposition: 'N/A';
                        $det = $p->resuInpatient ?$p->resuInpatient->details: 'N/A';
                        $outC = $p->resuInpatient ?$p->resuInpatient->Outcome: 'N/A';
                        $icdCode_Nature = $p->resuInpatient ?$p->resuInpatient->icd10Code_nature: 'N/A';
                        $icdCode_External = $p->resuInpatient ?$p->resuInpatient->icd10Code_external: 'N/A';

     //  ============================================================= Nature Injury ========================================================
              // Define the list of injuries
              $injuries = ['Abrasions', 'Avulsion', 'Concussion', 'Contusion', 'Open Wound', 'Traumatic Amputation'];
              $injuryResults = [];
              
              // Get preadmission entries if they exist
              $preadmissionEntries = $p->preadmission ? $p->preadmission->natureInjuryPreadmissions : null;
              
              if ($preadmissionEntries && $preadmissionEntries->count() > 0) {
                  foreach ($preadmissionEntries as $preadmission) {
                      // Get the associated nature injury
                      $latestNatureInjury = $preadmission->natureInjury;    
                      
                      if ($latestNatureInjury) {
                          foreach ($injuries as $injury) {
                              // Check if the nature injury matches
                              if ($latestNatureInjury->id == $preadmission->natureInjury_id && 
                                  $latestNatureInjury->name === $injury) {
                                  
                                  // Initialize injury result if not already set
                                  if (!isset($injuryResults[strtolower($injury)])) {
                                      $injuryResults[strtolower($injury)] = [
                                          'status' => 'Yes',
                                          'details' => $preadmission->details ?: ' ',
                                          'bodyparts_id' => [], 
                                          'preadmission_id' => $preadmission->Pre_admission_id,
                                          'nature_injury_id' => $latestNatureInjury->id,
                                      ];
                                  }
              
                                  // Handle body parts
                                  $bodyParts = $latestNatureInjury->bodyParts;
              
                                  // Check if bodyParts exists
                                  if ($bodyParts &&count($bodyParts) > 0) {
                                      // Filter body parts based on Pre_admission_id
                                      $filteredBodyParts = $bodyParts->filter(function ($bodyPart) use ($preadmission) {
                                          return $bodyPart->preadmission_id == $preadmission->Pre_admission_id;
                                      });
              
                                      // Extract body part names and ensure uniqueness
                                      $bodyPartNames = $filteredBodyParts->map(function ($item) {
                                          return $item->bodypart->name;
                                      })->toArray();
              
                                      // Merge and remove duplicate body parts using array_unique()
                                      $injuryResults[strtolower($injury)]['bodyparts_id'] = array_unique(array_merge(
                                          $injuryResults[strtolower($injury)]['bodyparts_id'],
                                          $bodyPartNames
                                      ));
                                  }
                              }
                          }
                      }
                  }
                  
                  // Mark injuries as 'No' if not found
                  foreach ($injuries as $injury) {
                      if (!isset($injuryResults[strtolower($injury)])) {
                          $injuryResults[strtolower($injury)] = [
                              'status' => 'No',
                              'details' => ' ',
                              'bodyparts_id' => [],
                              'preadmission_id' => null,
                              'nature_injury_id' => null,
                          ];
                      }
                  }              
              
                  // Output for debugging
                  //dd($injuryResults);
              }        
              
              
              // Example output
             // dd($injuryResults);
              
                    // Now you can access the result like this:
                   
                    // $abrasionStatus = $injuryResults['abrasions']['status'] ?? 'N/A';
                    // $abrasionDetails = $injuryResults['abrasions']['details'] ?? 'N/A';
                    // $abrasionbodyPreadmissionIds = $injuryResults['abrasions']['preadmission_id'] ?? [];
                    // $abrasionbodyNatureIds = $injuryResults['abrasions']['nature_injury_id'] ?? [];
                    // $abrasionBodyparts = $injuryResults['abrasions']['bodyparts_id'] ?? [];

                    // $avulsionStatus = $injuryResults['avulsion']['status'];
                    // $avulsionDetails = $injuryResults['avulsion']['details'];
                    // $bodyPartsIdsAvulsion = $injuryResults['avulsion']['bodyparts_id'] ?? [];
                    // $avulsionbodyPreadmissionIds = $injuryResults['avulsion']['preadmission_id'] ?? [];

                    // $concussionStatus = $injuryResults['concussion']['status'];
                    // $concussionDetails = $injuryResults['concussion']['details'];
                    // $bodyPartsIdsConcussion = $injuryResults['concussion']['bodyparts_id'] ?? [];

                    // $contusionStatus = $injuryResults['contusion']['status'];
                    // $contusionDetails = $injuryResults['contusion']['details'];
                    // $bodyPartsIdsContusion = $injuryResults['contusion']['bodyparts_id'] ?? [];

                    // $openwoundStatus = $injuryResults['open wound']['status'];
                    // $openwoundDetails = $injuryResults['open wound']['details'];
                    // $bodyPartsIdsOpenWound = $injuryResults['open wound']['bodyparts_id'] ?? [];

                    // $traumaticStatus = $injuryResults['traumatic amputation']['status'];
                    // $traumaticDetails = $injuryResults['traumatic amputation']['details'];
                    // $bodyPartsIdsTraumaticAmputation = $injuryResults['traumatic amputation']['bodyparts_id'] ?? [];

                    // Output results for debugging
                   //dd($abrasionStatus, $abrasionDetails, $abrasionbodyNatureIds,$abrasionbodyPreadmissionIds,  $abrasionBodyparts);

                    $fractureInfo = 'No';  // Default to No
                    $fractureSubtype = 'N/A';  // Default to N/A
                    $fractureBodyParts = [];    
                    
                    // Check if the preadmission exists and contains fracture information
                    if ($p->preadmission && $p->preadmission->natureInjuryPreadmissions->count() > 0) {
                        // Loop through all nature injury preadmissions for this preadmission
                        foreach ($p->preadmission->natureInjuryPreadmissions as $natureInjuryPreadmission) {
                            // Check if the injury is a fracture
                            if ($natureInjuryPreadmission->natureInjury->name === 'Fracture') {
                                $fractureInfo = 'Yes';  // If fracture is found, set it to Yes
                                // Check if there's a subtype for the fracture (Close or Open)
                                // Assuming 'subtype' is a field on the `natureInjuryPreadmission` model
                                $fractureSubtype = $natureInjuryPreadmission->subtype ? $natureInjuryPreadmission->subtype : 'N/A';
                                // Break the loop as we found a fracture, no need to check further
                                break;

                            }
                        }
                    }
                    
                    $BurnInfo = 'No';  // Default to No
                    $BurnSubtype = 'N/A';  // Default to N/A
                    if ($p->preadmission && $p->preadmission->natureInjuryPreadmissions->count() > 0) {
                        // Loop through all nature injury preadmissions for this preadmission
                        foreach ($p->preadmission->natureInjuryPreadmissions as $natureInjuryPreadmission) {
                            // Check if the injury is a fracture
                            if ($natureInjuryPreadmission->natureInjury->name === 'Burn') {
                                $BurnInfo = 'Yes';  // If fracture is found, set it to Yes
                    
                                // Check if there's a subtype for the fracture (Close or Open)
                                // Assuming 'subtype' is a field on the `natureInjuryPreadmission` model
                                $BurnSubtype = $natureInjuryPreadmission->subtype ? $natureInjuryPreadmission->subtype : 'N/A';
                                // Break the loop as we found a fracture, no need to check further
                                break;
                            }
                        }
                    }  
//  ============================================================= External Injury =============================================               
                    $externalInjuries = [
                        'Bites/stings/Specific animal/Insect:',
                        'Burns',
                        'Chemical/Substance, specify',
                        'Contact with sharp Objects, specify object',
                        'Drowning: Type/Body of Water',
                        'Exposure to Forces of Nature',
                        'Fall',
                        'Firecracker, specify type/s',
                        'Sexual Assault/Sexual Abuse/Rape (Alleged)',
                        'Others, Specify',
                        'Gunshot, specify Weapon',
                        'Hanging/Strangulation',
                        'Mauling/Assaults',
                        'Transport/Vehicular Accident'
                    ];

                    $externalInjuryResults = [];

                    $preadmissionExternalEntries = $p->preadmission ? $p->preadmission->externalPreadmissions : null;

                    if ($preadmissionExternalEntries && $preadmissionExternalEntries->count() > 0) {
                        // Loop through all preadmission entries for this preadmission ID
                        foreach ($preadmissionExternalEntries as $preadmission) {
                            $latestExternalInjury = $preadmission->externalInjury;
                            
                            if ($latestExternalInjury) {
                                // Loop through each defined injury to check if it exists
                                foreach ($externalInjuries as $injury) {
                                    // Check if the injury matches the current nature injury and its ID
                                    if ($latestExternalInjury->id == $preadmission->externalinjury_id && $latestExternalInjury->name === $injury) {
                                        $externalInjuryResults[strtolower($injury)] = [
                                            'status' => 'Yes', // Injury found
                                            'details' => $preadmission->details ? $preadmission->details : ' ' // Capture details
                                        ];
                                    }
                                }
                            }
                        }    
                        // If no matching injury was found after checking all entries, mark as 'No'
                        foreach ($externalInjuries as $injury) {
                            if (!isset($externalInjuryResults[strtolower($injury)])) {
                                $externalInjuryResults[strtolower($injury)] = [
                                    'status' => ' ',  // Injury not found
                                    'details' => ' '  // No details to display
                                ];
                            }
                        }
                    } else {
                        // If no preadmission records exist, mark all injuries as 'N/A'
                        foreach ($externalInjuries as $injury) {
                            $externalInjuryResults[strtolower($injury)] = [
                                'status' => ' ',
                                'details' => ' '
                            ];
                        }
                    }

                    // Now you can access the result like this:
                    $bitesStatus = $externalInjuryResults[strtolower('Bites/stings/Specific animal/Insect:')]['status'];
                    $bitesDetails = $externalInjuryResults[strtolower('Bites/stings/Specific animal/Insect:')]['details'];
                    $chemicalStatus = $externalInjuryResults[strtolower('Chemical/Substance, specify',)]['status'];
                    $chemicalDetails = $externalInjuryResults[strtolower('Chemical/Substance, specify',)]['details'];
                    $contactStatus = $externalInjuryResults[strtolower('Contact with sharp Objects, specify object',)]['status'];
                    $contactDetails = $externalInjuryResults[strtolower('Contact with sharp Objects, specify object',)]['details'];
                    $drownStatus = $externalInjuryResults[strtolower( 'Drowning: Type/Body of Water',)]['status'];
                    $drownDetails = $externalInjuryResults[strtolower( 'Drowning: Type/Body of Water',)]['details'];
                    $exposeStatus = $externalInjuryResults[strtolower( 'Exposure to Forces of Nature',)]['status'];
                    $exposeDetails = $externalInjuryResults[strtolower( 'Exposure to Forces of Nature',)]['details'];
                    $fallStatus = $externalInjuryResults[strtolower('Fall',)]['status'];
                    $fallDetails = $externalInjuryResults[strtolower('Fall',)]['details'];
                    $firecrackerStatus = $externalInjuryResults[strtolower('Firecracker, specify type/s',)]['status'];
                    $firecrackerDetails = $externalInjuryResults[strtolower('Firecracker, specify type/s',)]['details'];
                    $sexualStatus = $externalInjuryResults[strtolower('Sexual Assault/Sexual Abuse/Rape (Alleged)',)]['status'];
                    $sexualDetails = $externalInjuryResults[strtolower('Sexual Assault/Sexual Abuse/Rape (Alleged)',)]['details'];
                    $othersStatus = $externalInjuryResults[strtolower('Others, Specify',)]['status'];
                    $othersDetails = $externalInjuryResults[strtolower('Others, Specify',)]['details'];
                    $gunshotStatus = $externalInjuryResults[strtolower('Gunshot, specify Weapon',)]['status'];
                    $gunshotDetails = $externalInjuryResults[strtolower('Gunshot, specify Weapon',)]['details'];
                    $hangingStatus = $externalInjuryResults[strtolower('Hanging/Strangulation',)]['status'];
                    $hangingDetails = $externalInjuryResults[strtolower('Hanging/Strangulation',)]['details'];                    
                    $maulingStatus = $externalInjuryResults[strtolower('Hanging/Strangulation',)]['status'];
                    $maulingDetails = $externalInjuryResults[strtolower('Hanging/Strangulation',)]['details'];
                   
                    $burnsStatus = 'No';  // Default to No
                    $burnsSubtype = 'N/A';  // Default to N/A
                    if ($p->preadmission && $p->preadmission->externalPreadmissions->count() > 0) {
                        // Loop through all nature injury preadmissions for this preadmission
                        foreach ($p->preadmission->externalPreadmissions as $externalPreadmissions) {
                            // Check if the injury is a fracture
                            if ($externalPreadmissions->externalInjury->name === 'Burn' ) {
                                $burnsStatus = 'Yes';
                                $burnsSubtype = $externalPreadmissions->subtype ? $externalPreadmissions->subtype : 'N/A';
                                // Break the loop as we found a fracture, no need to check further
                                break;
                            }
                        } 
                    } 
//========================================== Transport Vehicle ======================================================
                    $transportStatus = 'No'; 
                    $transportVehicle = 'N/A';
                    $otherCollision = 'N/A';
                    $otherCollisionOthers = 'N/A';
                    $patientVehicle = 'N/A';
                    $patientVehicleDetails = 'N/A';
                    $positionPatient = 'N/A';
                    $positionPatientDetails = 'N/A';
                    $workplace = 'N/A';
                    $placeOccurence = 'N/A';
                    $placeOccurenceDetails = 'N/A';
                    $activityPatient = 'N/A';
                    $activityPatientDetails = 'N/A';
                    $otherRiskFactors = 'N/A';
                    $otherRiskFactorsDetails = 'N/A';
                    $Ressafety= 'N/A';
                                       
                    if ($p->preadmission && $p->preadmission->transport->count() > 0) {
                        // Loop through each transport record associated with the preadmission
                        foreach ($p->preadmission->transport as $transport) {
                            // Check if the transport's Pre_admission_id matches the preadmission's id
                            if ($transport->Pre_admission_id === $p->preadmission->id) {
                                $transportStatus = 'Yes';  // Transport accident found
                                $transportVehicle = $transport->Vehicular_acc_type;
                                $otherCollision = $transport->other_collision;
                                $otherCollisionOthers = $transport->other_collision_details;
                                $patientVehicle = $transport->PatientVehicle;
                                $patientVehicleDetails = $transport->PvOther_details;
                                $positionPatient = $transport->positionPatient;
                                $positionPatientDetails = $transport->ppother_detail;
                                $workplace = $transport->workplace_occurence_specify;
                                $placeOccurence = $transport->pofOccurence;
                                $placeOccurenceDetails = $transport->pofOccurence_others;
                                $activityPatient = $transport->activity_patient;
                                $activityPatientDetails = $transport->AP_others;
                                $otherRiskFactors = $transport->risk_factors;
                                $otherRiskFactorsDetails = $transport->rf_others;
                                //$Ressafety = $transport->safety;  
                                if ($transport->safety) {
                                    $safetyRecord = \App\ResuSafety::find($transport->safety);
                                    $Ressafety = $safetyRecord ? $safetyRecord->name : 'No safety found';
                                } else {
                                    $Ressafety = 'No safety found';  // If no safety record exists
                                }
                                break;
                            }
                        }
                    }
                  
                        $csvData[] = [
                            $p->Hospital_caseNo,
                            $p->fname, $p->mname, $p->lname, $suffix, $age, $p->sex, $p->dob,
                            $p->province ? $p->province->description : 'N/A',
                            $p->muncity ? $p->muncity->description : 'N/A',
                            $p->barangay ? $p->barangay->description : 'N/A',
                            ($p->preadmission->POIProvince_id ? $p->preadmission->province->description : 'N/A') . ' , ' .
                            ($p->preadmission->POImuncity_id ? $p->preadmission->muncity->description : 'N/A') . ' , ' .
                            ($p->preadmission->POIBarangay_id ? $p->preadmission->barangay->description : 'N/A'),
                            $p->preadmission->injury_intent, $p->preadmission->first_aid, $p->preadmission->what,$p->preadmission->bywhom,$p->preadmission->multipleInjury,   
                            $transferredFac, $referredFac, $originatedHos,$statusFacility,$ifAlive,  $modeTransport, $otherDetails, $initialImpression,  $icdCodeNature,  $icdCodeExternal,
                            $disposition,  $details,  $outcome,  $diagnose, $disposition,$det, $outC , $icdCode_Nature,   $icdCode_External, $p->preadmission->id,
                          
                            // Abrasion details
                            $injuryResults['abrasions']['status'] ?? 'No',
                            $injuryResults['abrasions']['details'] ?? 'N/A',
                            implode(',', $injuryResults['abrasions']['bodyparts_id'] ?? []),
                            // Avulsion details
                            $injuryResults['avulsion']['status'] ?? 'No',
                            $injuryResults['avulsion']['details'] ?? 'N/A',
                            implode(',', $injuryResults['avulsion']['bodyparts_id'] ?? []),
                            // Concussion details
                            $injuryResults['concussion']['status'] ?? 'No',
                            $injuryResults['concussion']['details'] ?? 'N/A',
                            implode(',', $injuryResults['concussion']['bodyparts_id'] ?? []),
                            // Contusion details
                            $injuryResults['contusion']['status'] ?? 'No',
                            $injuryResults['contusion']['details'] ?? 'N/A',
                            implode(',', $injuryResults['contusion']['bodyparts_id'] ?? []),
                            // Open Wound details
                            $injuryResults['open wound']['status'] ?? 'No',
                            $injuryResults['open wound']['details'] ?? 'N/A',
                            implode(',', $injuryResults['open wound']['bodyparts_id'] ?? []),
                            // Traumatic Amputation details
                            $injuryResults['traumatic amputation']['status'] ?? 'No',
                            $injuryResults['traumatic amputation']['details'] ?? 'N/A',
                            implode(',', $injuryResults['traumatic amputation']['bodyparts_id'] ?? []),
                            // Burn details
                            // $injuryResults['burn']['status'] ?? 'No',
                            // $injuryResults['burn']['details'] ?? 'N/A',
                            // implode(',', $injuryResults['burn']['bodyparts_id'] ?? []),
                            $BurnInfo,
                            $BurnSubtype,
                            $fractureInfo,$fractureSubtype, 
                           //external injuries
                            $bitesStatus,  $bitesDetails,
                            $burnsStatus, $burnsSubtype, 
                            $chemicalStatus,$chemicalDetails,
                            $contactStatus,$contactDetails,
                            $drownStatus, $drownDetails,
                            $exposeStatus,$exposeDetails,
                            $fallStatus,$fallDetails,
                            $firecrackerStatus,$firecrackerDetails,
                            $sexualStatus,$sexualDetails,
                            $othersStatus,$othersDetails,
                            $gunshotStatus,$gunshotDetails,
                            $hangingStatus, $hangingDetails,
                            $maulingStatus,$maulingDetails,
                            $transportStatus,$transportVehicle,
                            $otherCollision,
                            $otherCollisionOthers,
                            $patientVehicle,
                            $patientVehicleDetails,
                            $positionPatient,
                            $positionPatientDetails,
                            $workplace,
                            $placeOccurence,
                            $placeOccurenceDetails,
                            $activityPatient,
                            $activityPatientDetails,
                            $otherRiskFactors,
                            $otherRiskFactorsDetails,
                            $Ressafety,
                            $p->phicID, $facilityCode, $facilityName, $facilityType, $facilityaddress, $p->name_of_encoder,
                            $p->preadmission->dateInjury . '::' . $p->preadmission->timeInjury, $p->updated_at,
                        ];
                    
            }
            // Open a file for writing the CSV
            // $filename = 'Patient_Injury_data.csv';
            $filename = 'Patient_Injury_data_' . date('Y-m-d') . '.csv';
            $handle = fopen('php://output', 'w');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            // Write the CSV rows
            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }
            // Close the file
            fclose($handle);
            exit();
        }

        //Helper method to calculate age from DOB
        // private function calculateAge($dob)
        // {
        //     if ($dob) {
        //         return \Carbon\Carbon::parse($dob)->age;
        //     }
        //     return 'N/A';
        // }
        private function calculateAge($dob)
            {
                if ($dob) {
                    $dob = \Carbon\Carbon::parse($dob);
                    $ageYears = $dob->diffInYears(\Carbon\Carbon::now());
                    $ageMonths = $dob->diffInMonths(\Carbon\Carbon::now()) % 12;

                    // Return only years if non-zero, otherwise return months
                    return $ageYears > 0 
                        ? "{$ageYears} years old" 
                        : "{$ageMonths} months old";
                }
                return 'N/A';
            }



        // private function calculateAge($dob)
        // {
        //     if ($dob) {
        //         $birthDate = \Carbon\Carbon::parse($dob);
        //         $now = \Carbon\Carbon::now();

        //         // Calculate the age in years
        //         $years = $now->diffInYears($birthDate);
                
        //         // Calculate the age in months (remaining after years)
        //         $months = $now->diffInMonths($birthDate) % 12;

        //         return [
        //             'years' => $years,
        //             'months' => $months,
        //         ];
        //     }
        //     return 'N/A';
        // }

}


