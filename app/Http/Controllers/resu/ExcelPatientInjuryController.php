<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use DB;
use App\ResuReportFacility;
use App\Profile;
use App\ResuPreadmission;
use App\ResuNature_Preadmission;
use App\ResuNatureInjury;
use App\ResuExternalInjury;
use App\Resuexternal_injury_preAdmission;
use Log;

class ExcelPatientInjuryController extends Controller
{
    //
    public function ViewImport(){
        return view('resu.importExcel.excelPatientInjury');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('file');
        
        Excel::load($file, function($reader) {
            $reader->each(function($sheet) {
                    // ResuReportFacility::create([
                    //     'reportfacility' => $sheet['nameofreportingfacility'],
                    //     'typeOfdru' => $sheet['typeofdru'],
                    //     'Addressfacility' => $sheet['addressofdru'],
                    //     'typeofpatient' => $sheet['typeofpatient'],
                    // ]);
                    //dd($sheet);
                    
                    // $nature_injury = ResuNatureInjury::select('id', 'name')->get();
                   
                    $facility = new ResuReportFacility();

                    $facility->reportfacility = $sheet['nameofreportingfacility'];
                    $facility->typeOfdru = $sheet['typeofdru'];
                    $facility->Addressfacility = $sheet['addressofdru'];
                    $facility->typeofpatient = $sheet['typeofpatient'];

                    $facility->save();

                    $profile = new Profile();
                    $unique_id = $sheet['firstname'].''.$sheet['middlename'].''.$sheet['lastname'].''.substr($sheet['permanent_province']).''.substr($sheet['permanent_muncity']);
                    $profile->unique_id = $unique_id;
                    $profile->Hospital_caseno = $sheet['hospitalcaseno'];
                    $profile->report_facilityId = $facility->id;
                    $profile->fname = $sheet['firstname'];
                    $profile->mname = $sheet['middlename'];
                    $profile->lname = $sheet['lastname'];
                    $profile->sex = $sheet['sex'];
                    $profile->dob = \Carbon\Carbon::parse($sheet['dateofbirth']);
                    $profile->province_id = $sheet['permanent_province'];
                    $profile->muncity_id = $sheet['permanent_muncity'];
                    $profile->barangay_id = $sheet['permanent_barangay'];
                    $profile->phicID = $sheet['philhealthnumber']  ?? '';

                    $profile->save();

                    $dateAndtime = \Carbon\Carbon::parse($sheet['date_and_time_of_injury']);
                    $dateInjury= $dateAndtime->format('d/m/y');
                    $timeInjury = $dateAndtime->format('h:i:s a');

                    $dateAndtimeConsult = \Carbon\Carbon::parse($sheet['date_and_time_of_injury']);
                    $dateconsult = $dateAndtimeConsult->format('d/m/y');
                    $timeconsult = $dateAndtimeConsult->format('h:i:s a');

                    $pre_admission = new ResuPreadmission();
                    $pre_admission->profile_id = $profile->id;
                    $pre_admission->POIProvince_id = $sheet['place_of_injury_province'];
                    $pre_admission->POImuncity_id = $sheet['place_of_injury_muncity'];
                    $pre_admission->POIBarangay_id = $sheet['place_of_injury_barangay'];
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

                //     $abrasion = null;
                //     $avulsion = null;
                //     $burn = null;
                //     $concussion = null;
                //     $contusion = null;
                //     $fracture = null;
                //     $openwound = null;
                //     $traumaAmputation = null;
                //     $Others = null;

                //     // dd($sheet);

                //     if($sheet['abrasion'] == 1){
                //         $abrasion = strtolower(trim("abrasion"));
                //     }
                //     if($sheet['avulsion'] == 1){
                //         $avulsions = strtolower(trim("avulsion"));
                //     }
                //     if($sheet['burn'] == 1){
                //         $burn = strtolower("burn");
                //     }
                //     if($sheet['concussion'] == 1){
                //         $concussion = strtolower(trim("concussion"));
                //     }
                //     if($sheet['contusion'] == 1){
                //         $contusion = strtolower(trim("contusion"));
                //     }
                //     if($sheet['fracture'] == 1){
                //         $fracture = strtolower(trim("fracture"));
                //     }
                //     if($sheet['openwound'] == 1){
                //         $openwound = strtolower(trim("Open Wound"));
                //     }
                //     if($sheet['traumaticamputation'] == 1){
                //         $traumaAmputation = strtolower(trim("Traumatic Amputation"));
                //     }
                //     if($sheet['others'] == 1){
                //         $Others = strtolower(trim("Others"));
                //     }
                //    // dd(compact('abrasion', 'avulsion', 'burn', 'concussion', 'contusion', 'fracture', 'openwound', 'traumaAmputation', 'Others'));
                    
                //     $nature_id_abrasion = null;
                //     $nature_id_avulsion = null;
                //     $nature_id_burn = null;
                //     $nature_id_concussion = null;
                //     $nature_id_contusion = null;
                //     $nature_id_fracture = null;
                //     $nature_id_openwound = null;
                //     $nature_id_traumatic = null;
                //     $nature_id_others = null;
                //     foreach($nature_injury as $nature){
                //         $NatureName = strtolower(trim($nature->name));
                //        if($NatureName == $abrasion){
                //         $nature_id_abrasion = $nature->id;
                //        }
                //        if( $NatureName == $avulsion){
                //         $nature_id_avulsion = $nature->id;
                //        }
                //        if($NatureName ==  $burn){
                //         $nature_id_burn = $nature->id;
                //        }
                //        if($NatureName == $concussion){
                //         $nature_id_concussion = $nature->id;
                //        }
                //        if($NatureName == $contusion){
                //         $nature_id_contusion = $nature->id;
                //        }
                //        if($NatureName == $fracture){
                //         $nature_id_fracture = $nature->id;
                //        }
                //        if($NatureName == $openwound){
                //         $nature_id_openwound = $nature->id;
                //        }  
                //        if($NatureName == $traumaAmputation){
                //         $nature_id_traumatic = $nature->id;
                //        }
                //        if($NatureName == $Others){
                //         $nature_id_others = $nature->id;
                //        }                  
                //     }
                //     // Debugging: Check initial assignment
                //     // dd(compact('openwound','nature_id_abrasion', 'nature_id_avulsion', 'nature_id_burn', 'nature_id_concussion', 'nature_id_contusion', 'nature_id_fracture', 'nature_id_openwound', 'nature_id_traumatic', 'nature_id_others'));
                //     $details = [
                //         'abrasion' => $sheet['abrasion_details'],
                //         'avulsion' => $sheet['avulsion_details'],
                //         'burn' => $sheet['burn_details'],
                //         'burnsite' => $sheet['burnsite'],
                //         'concussion' => $sheet['concussion_details'],
                //         'contusion' => $sheet['contusion_details'],
                //         'fracture' => $sheet['fracture_details'],
                //         'fracturetype' => $sheet['fracturetype_details'],
                //         'open_wounds' => $sheet['openwound_details'],
                //         'traumaticamputation' => $sheet['traumaticamputation_details'],
                //         'others' => $sheet['other_details']
                //     ];
                    
                //     // Save nature_Pread records with only the natures_id and details
                //     if ($nature_id_abrasion) {
                //         $nature_Pread = new ResuNature_Preadmission();
                //         $nature_Pread->Pre_admission_id = $pre_admission->id;
                //         $nature_Pread->natureInjury_id = $nature_id_abrasion;
                //         $nature_Pread->details = $details['abrasion'];
                //         $nature_Pread->save();
                //     }
                //     if ($nature_id_avulsion) {
                //         $nature_Pread = new ResuNature_Preadmission();
                //         $nature_Pread->Pre_admission_id = $pre_admission->id;
                //         $nature_Pread->natureInjury_id = $nature_id_avulsion;
                //         $nature_Pread->details = $details['avulsion'];
                //         $nature_Pread->save();
                //     }
                //     if ($nature_id_burn) {
                //         $nature_Pread = new ResuNature_Preadmission();
                //         $nature_Pread->Pre_admission_id = $pre_admission->id;
                //         $nature_Pread->natureInjury_id = $nature_id_burn;
                //         $nature_Pread->details = $details['burn'] . ' ' .  $details['burnsite'];
                //         $nature_Pread->save();
                //     }
                //     if ($nature_id_concussion) {
                //         $nature_Pread = new ResuNature_Preadmission();
                //         $nature_Pread->Pre_admission_id = $pre_admission->id;
                //         $nature_Pread->natureInjury_id = $nature_id_concussion;
                //         $nature_Pread->details = $details['concussion'];
                //         $nature_Pread->save();
                //     }
                //     if ($nature_id_contusion) {
                //         $nature_Pread = new ResuNature_Preadmission();
                //         $nature_Pread->Pre_admission_id = $pre_admission->id;
                //         $nature_Pread->natureInjury_id = $nature_id_contusion;
                //         $nature_Pread->details = $details['contusion'];
                //         $nature_Pread->save();
                //     }
                //     if ($nature_id_fracture) {
                //         $nature_Pread = new ResuNature_Preadmission();
                //         $nature_Pread->Pre_admission_id = $pre_admission->id;
                //         $nature_Pread->natureInjury_id = $nature_id_fracture;
                //         $nature_Pread->details = $details['fracture'];
                //         $nature_Pread->save();
                //     }
                //     if ($nature_id_openwound) {
                //         $nature_Pread = new ResuNature_Preadmission();
                //         $nature_Pread->Pre_admission_id = $pre_admission->id;
                //         $nature_Pread->natureInjury_id = $nature_id_openwound;
                //         $nature_Pread->details = $details['open_wounds'];
                //         $nature_Pread->save();
                //     }
                //     if ($nature_id_traumatic) {
                //         $nature_Pread = new ResuNature_Preadmission();
                //         $nature_Pread->Pre_admission_id = $pre_admission->id;
                //         $nature_Pread->natureInjury_id = $nature_id_traumatic;
                //         $nature_Pread->details = $details['traumaticamputation'];
                //         $nature_Pread->save();
                //     }
                //     if ($nature_id_others) {
                //         $nature_Pread = new ResuNature_Preadmission();
                //         $nature_Pread->Pre_admission_id = $pre_admission->id;
                //         $nature_Pread->natureInjury_id = $nature_id_others;
                //         $nature_Pread->details = $details['others'];
                //         $nature_Pread->save();
                //     }

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
                            'mauling_assault' => $sheet['MaulingAssault_details'],
                            'transport' => $sheet['transport_details'],
                            'others' => $request['externalothers_details']
                        ];
                        
                        if($exId_bites){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_bites;
                            $external->details = $ex_details['bite'];
                            $external->save();
                        }
                        if($exId_burns){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_burns;
                            $external->details = $ex_details['burn'];
                            $external->save();
                        }
                        if($exId_chemical){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_chemical;
                            $external->details = $ex_details['chemical'];
                            $external->save();
                        }
                        if($exId_contact){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_contact;
                            $external->details = $ex_details['object'];
                            $external->save();
                        }
                        if($exId_drowning){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_drowning;
                            $external->details = $ex_details['drowning'];
                            $external->save();
                        }

                        if($exId_exposure){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_exposure;
                            $external->details = $ex_details['exposure'];
                            $external->save();
                        }
                        if($exId_fall){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_fall;
                            $external->details = $ex_details['fall'];
                            $external->save();
                        }
                        

                        if($exId_firecracker){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_firecracker;
                            $external->details = $ex_details['firecreacker'];
                            $external->save();
                        }

                        if($exId_sexaulAbure){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_sexaulAbure;
                            $external->save();
                        }

                        if($exId_gunshot){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_gunshot;
                            $external->details = $ex_details['gunshot'];
                            $external->save();
                        }

                        if($exId_strangulation){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_strangulation;
                            $external->details = $ex_details['strangulation'];
                            $external->save();
                        }

                        if($exId_maulingAssault){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id = $exId_maulingAssault;
                            $external->details = $ex_details['mauling_assault'];
                            $external->save();
                        }

                        if($exId_transport){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_transport;
                            $external->details = $ex_details['transport'];
                            $external->save();
                        }

                        if($exId_others){
                            $external = new Resuexternal_injury_preAdmission();
                            $external->Pre_admission_id =  $pre_admission->id;
                            $external->externalinjury_id =  $exId_others;
                            $external->details = $ex_details['others'];
                            $external->save();
                        }
            });
        });

        // Excel::load($file, function($reader) {
        //     $reader->each(function($sheet) {
        //         $sheet->each(function($row) {
        //             ResuReportFacility::create([
        //                 'reportfacility' => $row['NameofReportingFacility'],
        //                 'typeOfdru' => $row['TypeofDRU'],
        //                 'Addressfacility' => $row['AddressofDRU'],
        //                 'typeofpatient' => $row['TypeofPatient'],
        //             ]);
        //         });

        //     });

        // });


        // $mappingData = [
        //     'NameofReportingFacility' => ['table' => 'resu_report_facility', 'column' => 'reportfacility'],
        //     'TypeofDRU' => ['table' => 'resu_report_facility', 'column' => 'typeOfdru'],
        //     'AddressofDRU' => ['table' => 'resu_report_facility', 'column' => 'Addressfacility'],
        //     'TypeofPatient' => ['table' => 'resu_report_facility', 'column' => 'typeofpatient'],
        // ];

        // $tableData = [];

        // Excel::load($file, function($reader) use (&$tableData, $mappingData) {
        //     $sheets = $reader->all();

        //     foreach ($sheets as $sheet) {
        //         foreach ($sheet as $row) {
        //             foreach ($mappingData as $header => $map) {
        //                 if (isset($row->$header)) {
        //                     $tableData[$map['table']][] = [
        //                         $map['column'] => $row->$header,
        //                     ];
        //                 }
        //             }
        //         }
        //     }
        // });

        // foreach ($tableData as $table => $rows) {
        //     DB::table($table)->insert($rows);
        // }
    }

}

