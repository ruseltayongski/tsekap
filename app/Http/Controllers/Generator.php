<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Muncity;
use App\Barangay;
use App\Province;
use App\Http\Controllers\ParameterCtrl as Param;

class Generator extends Controller
{

    function above60()
    {
        $q = "select * from profile where (DATEDIFF(profile.dob, '2017-07-18')/365.25 * -1) >= 60 order by barangay_id asc";
        $result = DB::select($q);
        echo '<table border="1">';
        foreach($result as $row)
        {
            if($row->barangay_id!=0){
                $name = $row->fname.' '.$row->mname.' '.$row->lname;
                $dob = date('M d, Y',strtotime($row->dob));
                $brgy = Barangay::find($row->barangay_id)->description;
                $muncity = Muncity::find($row->muncity_id)->description;
                $province = Province::find($row->province_id)->description;

                $age = Param::getAge($row->dob);
                $tmp = '';
                if($age==0){
                    $age = Param::getAgeMonth($row->dob);
                    $tmp = 'M/o';

                    if($age==0){
                        $age = Param::getAgeDay($row->dob);
                        $tmp = 'D/o';
                    }
                }
                echo '<tr>';
                echo '<td>'.$name.'</td>';
                echo '<td>'.$dob.'</td>';
                echo '<td>'.$age.' '.$tmp.'</td>';
                echo '<td>'.$row->sex.'</td>';
                echo '<td>'.$brgy.'</td>';
                echo '<td>'.$muncity.'</td>';
                echo '<td>'.$province.'</td>';
                echo '</tr>';
            }
        }
        echo '</table>';
    }

}
