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

                    $nature_Pread = new ResuNature_Preadmission();

                    $nature_Pread->Pre_admission_id = $pre_admission->id;
                        $abration = $sheet['abrasion'];
                        $avulsion = $sheet['avulsion'];
                        $burn = $sheet['burn'];
                        $concussion = $sheet['concussion'];
                        $contusion = $sheet['contusion'];
                        $fracture = $sheet['fracture'];
                        $openwound = $sheet['openwound'];
                        $traumaAmputation = $sheet['traumaticamputation'];
                        $Others = $sheet['others'];

                        $Abrasion_details = $sheet['abrasion_details'];
                        $Avulsion_details = $sheet['avulsion_details'];
                        $Burn_details = $sheet['burn_details'];
                        $burnsite = $sheet['burnsite'];
                        $Concussion_details = $sheet['concussion_details'];
                        $Contusion_details = $sheet['contusion_details'];
                        $Fracture_details = $sheet['fracture_details'];
                        $FractureType_details = $sheet['fracturetype_details'];
                        $OpenWound_details = $sheet['openwound_details'];
                        $TraumaticAmputation_details = $sheet['traumaticamputation_details'];
                        $Other_details = $sheet['other_details'];


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

