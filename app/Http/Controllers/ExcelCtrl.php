<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\Muncity;
use App\Province;
use Illuminate\Http\Request;

use App\Http\Requests;
use Excel;
use Illuminate\Support\Facades\Auth;

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
        $province_id = $request->province_id;
        $muncity_id = $request->muncity_id;
        $municipality = Muncity::find($muncity_id)->description;
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $type = 'xlsx';
        $data = \DB::connection('mysql')->select("call GetProfileMunicipality('$province_id','$muncity_id','$municipality')");
        $data = json_decode( json_encode($data), true);

        return Excel::create($municipality, function($excel) use ($data,$municipality) {
            $excel->sheet($municipality, function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);


    }
}
