<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\Muncity;
use App\Profile;
use App\Province;
use App\UserBrgy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TargetCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function targetPopulation(Request $req, $year) {
        if($req->view_all == 'view_all')
            $keyword = null;
        else{
            if(Session::get("targetKeyword")){
                if(!empty($req->keyword) && Session::get("targetKeyword") != $req->keyword)
                    $keyword = $req->keyword;
                else
                    $keyword = Session::get("targetKeyword");
            } else {
                $keyword = $req->keyword;
            }
        }

        Session::put('targetKeyword',$keyword);

        $user = Auth::user();
        $user_priv = $user->user_priv;
        $target_col = ($year === '2022') ? 'barangay.target_2022 as target' : 'barangay.target';

        if($user_priv == 0) {
            $data = Barangay::select(
                'id', 'description',
                'province_id', 'muncity_id',
                $target_col
            )
                ->where('muncity_id', Auth::user()->muncity);
        }
        else if($user_priv == 2)  {
            $data = UserBrgy::select(
                'barangay.id',
                'barangay.description',
                'barangay.province_id',
                'barangay.muncity_id',
                $target_col
            )
                ->where('userbrgy.user_id',$user->id)
                ->leftJoin('barangay','barangay.id','=','userbrgy.barangay_id');
        }
        else if($user_priv == 3 || $user_priv == 1) {
            $data = Province::select(
                'province.id',
                'province.description'
            )->get();
            if($user_priv == 3)
                $data = $data->where('id',Auth::user()->province);
        }

        if($user_priv == 3 || $user_priv == 1) {
            return view('target.target_admin',[
                'data' => $data,
                'year' => $year
            ]);
        } else {
            if(isset($keyword))
                $data = $data->where('barangay.description',"like","%$keyword%");
            $data = $data->get();
            return view('target.target_muncity',[
                'data' => $data,
                'user_priv' => $user_priv,
                'year' => $year
            ]);
        }
    }

    public static function getMuncity($prov_id){
        $data = Muncity::select(
            'muncity.id',
            'muncity.description'
        )
            ->where('muncity.province_id', $prov_id)
            ->get();
        return $data;
    }

    public static function getMuncityTotal($mun_id) {
        $year = Session::get('statreport_year');
        $prov = Muncity::select('province_id')->where('id',$mun_id)->first()->province_id;
        if($year == '2022') {
            $mun_target = Barangay::select(DB::raw("SUM(target_2022) as target_count"))->where('muncity_id',$mun_id)->first()->target_count;
            $mun_profiled = Profile::where('muncity_id',$mun_id)->where('updated_at','>=','2022-01-01 00:00:00')->count();
        } else {
            $mun_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('muncity_id',$mun_id)->first()->target_count;
            $mun_profiled = Profile::where('muncity_id',$mun_id)->where('created_at','<','2022-01-01 00:00:00')->count();
        }
        $barangay = LocationCtrl::getBarangayByMuncity($mun_id);

        return array(
            'prov' => $prov,
            'mun_target' => $mun_target,
            'mun_profiled' => $mun_profiled,
            'barangay' => $barangay
        );
    }

    public static function getBrgyTotal($bar_id) {
        $year = Session::get('statreport_year');
        $prov = Barangay::select('province_id')->where('id',$bar_id)->first()->province_id;
        if($year == '2022') {
            $bar_target = Barangay::select(DB::raw("SUM(target_2022) as target_count"))->where('id',$bar_id)->first()->target_count;
            $bar_profiled = Profile::where('barangay_id',$bar_id)->where('updated_at','>=','2022-01-01 00:00:00')->count();
        } else {
            $bar_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('id',$bar_id)->first()->target_count;
            $bar_profiled = Profile::where('barangay_id',$bar_id)->where('created_at','<','2022-01-01 00:00:00')->count();
        }

        return array(
            'prov' => $prov,
            'bar_target' => $bar_target,
            'bar_profiled' => $bar_profiled
        );
    }

    public function generateDownload(Request $req) {
        $province = $req->province_id;
        $muncity = $req->mun_id;
        $barangay = $req->bar_id;
        $year = Session::get('statreport_year');

        if(isset($req->prov_target)) {
            $prov_target = $req->prov_target;
            $prov_profiled = $req->prov_profiled;
        } else {
            if($year == '2022') {
                $prov_target = Barangay::select(DB::raw("SUM(target_2022) as target_count"))->where('province_id',$province)->first()->target_count;
                $prov_profiled = Profile::where('province_id',$province)->where('updated_at','>=','2022-01-01 00:00:00')->count();
            } else {
                $prov_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('province_id',$province)->first()->target_count;
                $prov_profiled = Profile::where('province_id',$province)->where('created_at','<','2022-01-01 00:00:00')->count();
            }
        }

        $prov_desc = Province::select('description')->where('id', $province)->first()->description;

        $filename = '('.$prov_desc;
        $muncity_list = array();
        $barangay_list = array();

        if(isset($muncity) && $muncity != '') {
            $mun_desc = Muncity::select('description')->where('id',$muncity)->first()->description;
            $filename .= " ".$mun_desc;

            $muncity_total = self::getMuncityTotal($muncity);
            $mun_target = $muncity_total['mun_target'];
            $mun_profiled = $muncity_total['mun_profiled'];

            $tmp = array();
            array_push($tmp, $muncity);
            array_push($tmp, $mun_desc);
            array_push($tmp, $mun_target);
            array_push($tmp, $mun_profiled);
            array_push($muncity_list, $tmp);

            if(isset($barangay) && $barangay != '') {
                $bar_desc = Barangay::select('description')->where('id',$barangay)->first()->description;
                $filename .= "-".$bar_desc;

                $bar_total = self::getBrgyTotal($barangay);
                $bar_target = $bar_total['bar_target'];
                $bar_profiled = $bar_total['bar_profiled'];

                $tmp = array();
                array_push($tmp, $barangay);
                array_push($tmp, $bar_desc);
                array_push($tmp, $bar_target);
                array_push($tmp, $bar_profiled);
                array_push($barangay_list, $tmp);
            } else {
                $tmp_list = Barangay::select('id','description')->where('muncity_id',$muncity)->get();
                foreach($tmp_list as $t) {
                    $b = Barangay::select('id','description')->where('id',$t->id)->first();
                    $tmp = array();
                    array_push($tmp, $b->id);
                    array_push($tmp, $b->description);
                    $bar_total = self::getBrgyTotal($t->id);
                    array_push($tmp, $bar_total['bar_target']);
                    array_push($tmp, $bar_total['bar_profiled']);
                    array_push($barangay_list, $tmp);
                }
            }
        }else {
            $tmp_list = Muncity::select('id')->where('province_id', $province)->get();
            foreach($tmp_list as $t) {
                $m = Muncity::select('id','description')->where('id',$t->id)->first();
                $tmp = array();
                array_push($tmp, $m->id);
                array_push($tmp, $m->description);
                $muncity_total = self::getMuncityTotal($t->id);
                array_push($tmp, $muncity_total['mun_target']);
                array_push($tmp, $muncity_total['mun_profiled']);
                array_push($muncity_list, $tmp);
            }
        }

        $filename .= ")Summary of Target and Profiled Population";

        return view('target.admin_download',[
            'filename' => $filename,
            'prov_target' => $prov_target,
            'prov_profiled' => $prov_profiled,
            'prov_desc' => $prov_desc,
            'muncity_list' => $muncity_list,
            'barangay_list' => $barangay_list,
            'year' => $year
        ]);
    }

    public function update(Request $req) {
        $bar = Barangay::where('id',$req->barangay_id)->first();
        $bar->target_2022 = str_replace(',', '', $req->target);
        $bar->save();

        Session::put('target_msg','Successfully updated target population!');
        Session::put('target_notif',true);
        return Redirect::back();
    }

    public function getProfileCount($id, $year){
        Session::put('statreport_year',$year);
        return ReportCtrl::getProfile('province',$id);
    }
}