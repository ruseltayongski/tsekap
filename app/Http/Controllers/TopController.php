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

                    $target = Barangay::where('province_id','=',$row->province)->where('muncity_id','=',$row->muncity)->sum('target');
                    $year2017 = \DB::connection('mysql')->select("select * from profile p where p.muncity_id = '$row->muncity' and p.province_id = '$row->province' and substring_index(substring_index(p.familyID, '-', 2),'-',-1) = '$row->id' and p.created_at like '%2017%' ");
                    $year2018 = \DB::connection('mysql')->select("select * from profile p where p.muncity_id = '$row->muncity' and p.province_id = '$row->province' and substring_index(substring_index(p.familyID, '-', 2),'-',-1) = '$row->id' and p.created_at like '%2018%' ");

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