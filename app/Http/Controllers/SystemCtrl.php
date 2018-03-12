<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\Muncity;
use App\Profile;
use App\Province;
use Illuminate\Http\Request;
use App\ProfileCases;
use App\ProfileServices;
use App\Http\Requests;
use App\Http\Controllers\ParameterCtrl as Param;
use App\ServiceGroup;
use App\ServiceOption;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SystemCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($process)
    {

    }

    public function deleteDummy()
    {

    }

    public function fixBrgy()
    {
        $file = url('public/csv/negros.csv');
        $file = fopen($file,"r");
        $data = array();
        while(! feof($file))
        {
            $data[] = fgetcsv($file);
        }
        fclose($file);
        echo '<table border="1">';

        foreach($data as $row){
            $prov = $row[0];
            $mun = $row[1];
            $brgy = utf8_encode($row[2]);
            $target = $row[3];

            $prov_id = Province::where('description','like',"%$prov%")->first()->id;
            $mun_tmp = Muncity::where('description','like',"%$mun%")
                    ->where('province_id',$prov_id)
                    ->first();
            $mun_id = 'Invalid';
            if($mun_tmp){
                $mun_id = $mun_tmp->id;
            }
            $brgy_tmp = Barangay::where('province_id',$prov_id)
                    ->where('muncity_id',$mun_id)
                    ->where('description',$brgy)
                    ->first();
            $brgy_id = 'Invalid';
            if($brgy_tmp){
                $brgy_id = $brgy_tmp->id;
            }

            Barangay::where('id',$brgy_id)
                ->update([
                    'new_target' => $target
                ]);

            echo '<tr>';
            echo '<td>'.$prov.'</td>';
            echo '<td>'.$prov_id.'</td>';
            echo '<td>'.$mun.'</td>';
            echo '<td>'.$mun_id.'</td>';
            echo '<td>'.$brgy.'</td>';
            echo '<td>'.$brgy_id.'</td>';
            echo '<td>'.$target.'</td>';
            echo '</tr>';
        }

        echo '</table>';
    }

}
