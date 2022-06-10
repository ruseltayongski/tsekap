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

    public function targetPopulation(Request $req) {
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

        if($user_priv == 0) {
            $data = Barangay::where('muncity_id', Auth::user()->muncity);
        }
        else if($user_priv == 2)  {
//            $barangay_id = UserBrgy::select('barangay_id')->where('user_id', $user->id)->first()->barangay_id;
//            $data = Barangay::where('id', $barangay_id);
            $data = UserBrgy::select(
                'barangay.id',
                'barangay.description',
                'barangay.province_id',
                'barangay.muncity_id',
                'barangay.target'
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
                'data' => $data
            ]);
        } else {
            if(isset($keyword))
                $data = $data->where('barangay.description',"like","%$keyword%");
            $data = $data->get();
            return view('target.target_muncity',[
                'data' => $data
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
        $prov = Muncity::select('province_id')->where('id',$mun_id)->first()->province_id;
        $mun_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('muncity_id',$mun_id)->first()->target_count;
        $mun_profiled = Profile::where('muncity_id',$mun_id)->count();
        $barangay = LocationCtrl::getBarangayByMuncity($mun_id);
        return array(
            'prov' => $prov,
            'mun_target' => $mun_target,
            'mun_profiled' => $mun_profiled,
            'barangay' => $barangay
        );
    }

    public static function getBrgyTotal($bar_id) {
        $prov = Barangay::select('province_id')->where('id',$bar_id)->first()->province_id;
        $bar_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('id',$bar_id)->first()->target_count;
        $bar_profiled = Profile::where('barangay_id',$bar_id)->count();
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
        $prov_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('province_id',$province)->first()->target_count;
        $prov_profiled = Profile::where('province_id',$province)->count();
        $prov_desc = Province::select('description')->where('id', $province)->first()->description;

        $filename = '('.$prov_desc;
        $muncity_list = array();
        $barangay_list = array();

        if(isset($muncity) && $muncity != '') {
            $mun_desc = Muncity::select('description')->where('id',$muncity)->first()->description;
            $filename .= " ".$mun_desc;
            $mun_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('muncity_id',$muncity)->first()->target_count;
            $mun_profiled = Profile::where('muncity_id',$muncity)->count();
            $tmp = array();
            array_push($tmp, $muncity);
            array_push($tmp, $mun_desc);
            array_push($tmp, $mun_target);
            array_push($tmp, $mun_profiled);
            array_push($muncity_list, $tmp);

            if(isset($barangay) && $barangay != '') {
                $bar_desc = Barangay::select('description')->where('id',$barangay)->first()->description;
                $filename .= "-".$bar_desc;
                $bar_target = Barangay::select(DB::raw("SUM(target) as target_count"))->where('id',$barangay)->first()->target_count;
                $bar_profiled = Profile::where('barangay_id',$barangay)->count();
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
                    array_push($tmp, Barangay::select(DB::raw("SUM(target) as target_count"))->where('id',$t->id)->first()->target_count);
                    array_push($tmp, Profile::where('barangay_id',$t->id)->count());
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
                array_push($tmp, Barangay::select(DB::raw("SUM(target) as target_count"))->where('muncity_id',$t->id)->first()->target_count);
                array_push($tmp, Profile::where('muncity_id', $t->id)->count());
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
            'barangay_list' => $barangay_list
        ]);
    }

    public function update(Request $req) {
        $bar = Barangay::where('id',$req->barangay_id)->first();
        $bar->target = str_replace(',', '', $req->target);
        $bar->save();

        Session::put('target_msg','Successfully updated target population!');
        Session::put('target_notif',true);
        return Redirect::back();
    }
}