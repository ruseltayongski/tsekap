<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\dengvaxia\Profile;
use App\Muncity;
use App\Province;
use App\User;
use Illuminate\Http\Request;
use App\UserBrgy;

use App\Http\Requests;
use Excel;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReportCtrl as Report;
use Illuminate\Support\Facades\DB;

class ExcelCtrl extends Controller
{
    public function importView()
    {
        return view('excel.import');
    }

    public function importExcel(Request $request)
    {
        $path = $request->file('import_file')->getRealPath();
        $data = Excel::load($path)->get();
        if($data->count()){
            foreach ($data as $key => $value) {
                if($barangay = Barangay::where('province_id','=',$value->province)->where('muncity_id','=',$value->municipality)->where('description','=',$value->barangay)->first()){
                    $barangay->target = $value->population;
                    $barangay->save();
                }
                else {
                    return $value;
                }
            }
        }

        return back()->with('success', 'Insert Record successfully.');
    }

    public function ExportExcelMunicipality(Request $request)
    {
        //set_time_limit(0);
        ini_set('memory_limit', '-1');
        /*error_reporting(E_ALL);
        ini_set('display_errors', 1);*/
        $province_id = $request->province_id;
        $province = $request->province;
        $muncity_id = $request->muncity_id;
        $municipality = Muncity::find($muncity_id)->description;
        $type = 'xlsx';
        $data = \DB::connection('mysql')->select("call GetProfileMunicipality('$province_id','$province','$muncity_id','$municipality')");
        $data = json_decode( json_encode($data), true);

        return Excel::create($municipality, function($excel) use ($data,$municipality) {
            $excel->sheet($municipality, function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    public function ExportExcelBarangay(Request $request)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $barangay_id = $request->barangay_id;
        $province = Province::find($request->province_id)->description;
        $municipality = Muncity::find($request->muncity_id)->description;
        $barangay = $request->barangay;
        $type = 'xlsx';
        $data = \DB::connection('mysql')->select("call GetProfileBarangay('$barangay_id','$province','$municipality','$barangay')");

        $data = json_decode( json_encode($data), true);
        return Excel::create($barangay, function($excel) use ($data,$barangay) {
            $excel->sheet($barangay, function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    }

    public function NdpProfileExcel(){
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        Excel::create('NDP PROFILED', function($excel) {

            $province = Province::orderBy("description","asc")->get();
            foreach($province as $prov){
                $barangay = Barangay::select(
                        "barangay.id",
                        "muncity.description as muncity",
                        "barangay.description as barangay",
                        "barangay.target"
                    )
                    ->Join("Muncity","muncity.id","=","barangay.muncity_id")
                    ->where("barangay.province_id","=",$prov->id)
                    ->orderBy("muncity.description","asc")
                    ->orderBy("barangay.description","asc")
                    ->get();

                $excel->sheet($prov->description, function($sheet) use ($prov,$barangay) {

                    $headerColumn = [
                        "Province",
                        "Municipality",
                        "Barangay",
                        "NDP Assigned",
                        "Target",
                        "Profiled",
                        "Accomplishment Rate",
                    ];

                    $sheet->appendRow($headerColumn);
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setFontFamily('Comic Sans MS');
                        $row->setFontSize(10);
                        $row->setFontWeight('bold');
                        $row->setBackground('#FFFF00');
                    });

                    foreach($barangay as $bar){
                        $ndp_assigned = '';
                        $userBrgy = UserBrgy::where('barangay_id',$bar->id)->get();
                        $user_count = 0;
                        foreach($userBrgy as $user_brgy){
                            $ndp_user = User::where("id","=",$user_brgy->user_id)->first();
                            if(isset($ndp_user)){
                                $user_count++;
                                $ndp_name = $user_count.'.) '.$ndp_user->fname." ".$ndp_user->mname." ".$ndp_user->lname;
                                $ndp_name = strtoupper($ndp_name);
                                $ndp_assigned .= $ndp_name."\n";
                            }
                        }

                        $profile = Report::getProfile('brgy',$bar->id);
                        $target = $bar->target;

                        if($target==0){
                            $target=$profile;
                        }

                        if($profile==0){
                            $profilePercentage = 0;
                        }else{
                            $profilePercentage = ($profile / $target) * 100;
                        }

                        $data = [
                            $prov->description,
                            $bar->muncity,
                            $bar->barangay,
                            $ndp_assigned,
                            $target,
                            $profile,
                            number_format((float)$profilePercentage, 0, '.', '')."%",
                        ];
                        $sheet->appendRow($data);
                    }
                });
            }


        })->download('xlsx');
    }

    public function NumberColumnProfiled(){
        ini_set('MAX_EXECUTION_TIME', '-1');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        Excel::create('NDP PROFILED', function($excel) {

            $province = Province::orderBy("description","asc")->get();
            foreach($province as $prov){
                $barangay = Barangay::select(
                    "barangay.id",
                    "muncity.description as muncity",
                    "barangay.description as barangay",
                    "barangay.target"
                )
                    ->Join("Muncity","muncity.id","=","barangay.muncity_id")
                    ->where("barangay.province_id","=",$prov->id)
                    ->orderBy("muncity.description","asc")
                    ->orderBy("barangay.description","asc")
                    ->get();

                $excel->sheet($prov->description, function($sheet) use ($prov,$barangay) {

                    $headerColumn = [
                        "Province",
                        "Municipality",
                        "Barangay",
                        "NDP Assigned",
                        "Target",
                        "Profiled",
                        "Accomplishment Rate",
                        "First Name",
                        "Middle Name",
                        "Last Name",
                        "Birthdate",
                        "Sex",
                        "Income",
                        "Unmet Need",
                        "Safe Water",
                        "Toilet",
                        "Education",
                        "Hypertension",
                        "Diabetic",
                        "PWD",
                        "Pregnant"
                    ];

                    $sheet->appendRow($headerColumn);
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setFontFamily('Comic Sans MS');
                        $row->setFontSize(10);
                        $row->setFontWeight('bold');
                        $row->setBackground('#FFFF00');
                    });

                    foreach($barangay as $bar){
                        $ndp_assigned = '';
                        $userBrgy = UserBrgy::where('barangay_id',$bar->id)->get();
                        $user_count = 0;
                        foreach($userBrgy as $user_brgy){
                            $ndp_user = User::where("id","=",$user_brgy->user_id)->first();
                            if(isset($ndp_user)){
                                $user_count++;
                                $ndp_name = $user_count.'.) '.$ndp_user->fname." ".$ndp_user->mname." ".$ndp_user->lname;
                                $ndp_name = strtoupper($ndp_name);
                                $ndp_assigned .= $ndp_name."\n";
                            }
                        }

                        $profile = Report::getProfile('brgy',$bar->id);
                        $target = $bar->target;

                        if($target==0){
                            $target=$profile;
                        }

                        if($profile==0){
                            $profilePercentage = 0;
                        }else{
                            $profilePercentage = ($profile / $target) * 100;
                        }

                        $fname = Report::getLackProfile($bar->id,"fname");
                        $mname = Report::getLackProfile($bar->id,"mname");
                        $lname = Report::getLackProfile($bar->id,"lname");
                        $dob = Report::getLackProfile($bar->id,"dob");
                        $sex = Report::getLackProfile($bar->id,"sex");
                        $income = Report::getLackProfile($bar->id,"income");
                        $unmet = Report::getLackProfile($bar->id,"unmet");
                        $water = Report::getLackProfile($bar->id,"water");
                        $toilet = Report::getLackProfile($bar->id,"toilet");
                        $education = Report::getLackProfile($bar->id,"education");
                        $hypertension = Report::getLackProfile($bar->id,"hypertension");
                        $diabetic = Report::getLackProfile($bar->id,"diabetic");
                        $pwd = Report::getLackProfile($bar->id,"pwd");
                        $pregnant = Report::getLackProfile($bar->id,"pregnant");

                        $data = [
                            $prov->description,
                            $bar->muncity,
                            $bar->barangay,
                            $ndp_assigned,
                            $target,
                            $profile,
                            number_format((float)$profilePercentage, 0, '.', '')."%",
                            $fname,
                            $mname,
                            $lname,
                            $dob,
                            $sex,
                            $income,
                            $unmet,
                            $water,
                            $toilet,
                            $education,
                            $hypertension,
                            $diabetic,
                            $pwd,
                            $pregnant
                        ];
                        $sheet->appendRow($data);
                    }
                });
            }


        })->download('xlsx');
    }

    public function ProfiledByFamilyId(){
        ini_set('MAX_EXECUTION_TIME', '-1');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        Excel::create('ProfiledByFamilyId', function($excel) {

            $province = Province::orderBy("description","asc")->get();
            foreach($province as $prov){
                $barangay = Barangay::select(
                    "barangay.id",
                    "muncity.description as muncity",
                    "barangay.description as barangay",
                    "barangay.target"
                )
                    ->Join("Muncity","muncity.id","=","barangay.muncity_id")
                    ->where("barangay.province_id","=",$prov->id)
                    ->orderBy("muncity.description","asc")
                    ->orderBy("barangay.description","asc")
                    ->get();

                $excel->sheet($prov->description, function($sheet) use ($prov,$barangay) {

                    $headerColumn = [
                        "Province",
                        "Municipality",
                        "Barangay",
                        "NDP Assigned",
                        "Family Profiled",
                    ];

                    $sheet->appendRow($headerColumn);
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setFontFamily('Comic Sans MS');
                        $row->setFontSize(10);
                        $row->setFontWeight('bold');
                        $row->setBackground('#FFFF00');
                    });

                    foreach($barangay as $bar){
                        $ndp_assigned = '';
                        $userBrgy = UserBrgy::where('barangay_id',$bar->id)->get();
                        $user_count = 0;
                        foreach($userBrgy as $user_brgy){
                            $ndp_user = User::where("id","=",$user_brgy->user_id)->first();
                            if(isset($ndp_user)){
                                $user_count++;
                                $ndp_name = $user_count.'.) '.$ndp_user->fname." ".$ndp_user->mname." ".$ndp_user->lname;
                                $ndp_name = strtoupper($ndp_name);
                                $ndp_assigned .= $ndp_name."\n";
                            }
                        }

                        $family_profiled = Report::getProfiledByFamilyId($bar->id);

                        $data = [
                            $prov->description,
                            $bar->muncity,
                            $bar->barangay,
                            $ndp_assigned,
                            $family_profiled
                        ];
                        $sheet->appendRow($data);
                    }
                });
            }


        })->download('xlsx');
    }



}
