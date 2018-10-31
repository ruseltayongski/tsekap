<?php

namespace App\Http\Controllers;
use App\Barangay;
use App\Muncity;
use App\Profile;
use App\Province;
use App\User;

class TopController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        ini_set('max_execution_time', 0);
        ini_set('memory_limit','99999999M');
        ini_set('max_input_time','99999999999');

        \Excel::create('Top NDP', function($excel) {
            $excel->sheet('ALL', function($sheet)
            {
                $headerColumn = array("Userid","Fullname","Username","Contact_number","Province","Municipality","Target","Jan-Dec 2017","Jan-Sep 2018");

                $sheet->appendRow($headerColumn);
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(10);
                    $row->setFontWeight('bold');
                    $row->setBackground('#FFFF00');
                });

                $user = User::get();
                foreach($user as $row){
                    //$target = Barangay::where('province_id','=',$row->province)->where('muncity_id','=',$row->muncity)->sum('target');
                    $year2017 = \DB::connection('mysql')->select("select * from profile p where p.muncity_id = '$row->muncity' and p.province_id = '$row->province' and substring_index(substring_index(p.familyID, '-', 2),'-',-1) = '$row->id' and p.created_at like '%2017%' ");
                    $year2018 = \DB::connection('mysql')->select("select * from profile p where p.muncity_id = '$row->muncity' and p.province_id = '$row->province' and substring_index(substring_index(p.familyID, '-', 2),'-',-1) = '$row->id' and p.created_at like '%2018%' ");
                    if(count($year2017) > 0){
                        $barangay_id = json_encode($year2017[0]->barangay_id,JSON_NUMERIC_CHECK);
                    } elseif(count($year2018) > 0) {
                        $barangay_id = json_encode($year2018[0]->barangay_id,JSON_NUMERIC_CHECK);
                    } else {
                        $barangay_id = "none";
                    }

                    if($tar = Barangay::where('id','=',$barangay_id)->first()){
                        $target = $tar->target;
                    } else {
                        $target = "no target specified";
                    }

                    $data = [
                        $row->id,
                        $row->fname.' '.$row->mname.' '.$row->lname,
                        $row->username,
                        $row->contact,
                        Province::find($row->province)->description,
                        Muncity::find($row->muncity)->description,
                        $target,
                        count($year2017),
                        count($year2018)
                    ];

                    $sheet->appendRow($data);
                }

            });
        })->download('xls');
    }

}
?>