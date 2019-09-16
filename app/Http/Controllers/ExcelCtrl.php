<?php

namespace App\Http\Controllers;

use App\Barangay;
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

    public function ExportExcelBarangay(Request $request)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
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

}
