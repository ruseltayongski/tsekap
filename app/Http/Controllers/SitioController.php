<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Purok;
use App\Sitio;
use App\SitioLogs;
use App\UserBrgy;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SitioController extends Controller
{
    public function Sitio(Request $request){
        $user_brgy = UserBrgy::where('user_id',Auth::user()->id)->get();

        $sitio_keyword = "";
        if($request->view_all){
            $sitio_keyword = null;
            Session::put('sitio_keyword',null);
        }
        elseif($request->sitio_keyword){
            $sitio_keyword = $request->sitio_keyword;
            Session::put('sitio_keyword',$sitio_keyword);
        }
        elseif(Session::get('sitio_keyword')){
            $sitio_keyword = Session::get('sitio_keyword');
        }

        $sitio = Sitio::
                select("sitio.*",
                    "barangay.description as barangay",
                    DB::raw("concat(users.fname,' ',users.mname,' ',users.lname) as created_by"
                    ))
                    ->where(function($q) use ($user_brgy){
                        foreach($user_brgy as $bar){
                            $q->orwhere('sitio.sitio_barangay_id',$bar->barangay_id);
                        }
                    })
                    ->where('sitio.sitio_name','like',"%$sitio_keyword%")
                    ->leftJoin('barangay','barangay.id','=','sitio.sitio_barangay_id')
                    ->leftJoin('users','users.id','=','sitio.sitio_created_by')
                    ->orderBy('sitio.sitio_name','asc')
                    ->paginate(15);


        return view('sitio.sitio',[
            "sitio" => $sitio
        ]);
    }

    public function addSitio(Request $request){

        $sitio_check = Sitio::find($request->sitio_id);
        if($sitio_check){
            $sitio_check->update([
                "sitio_created_by" => Auth::user()->id,
                "sitio_name" => $request->get('name'),
                "sitio_barangay_id" => $request->get('barangay_id'),
                "sitio_target" => $request->get('target'),
                "sitio_status" => 1
            ]);

            //logs purok
            $sitio_logs = new SitioLogs();
            $sitio_logs->sitio_id = $sitio_check->sitio_id;
            $sitio_logs->sitio_logs_by = Auth::user()->id;
            $sitio_logs->sitio_name = $sitio_check->sitio_name;
            $sitio_logs->sitio_barangay_id = $sitio_check->sitio_barangay_id;
            $sitio_logs->sitio_target = $sitio_check->sitio_targer;
            $sitio_logs->sitio_status = 'UPDATE';
            $sitio_logs->save();
            //end logs
        } else {
            $sitio_add = new Sitio();
            $sitio_add->sitio_created_by = Auth::user()->id;
            $sitio_add->sitio_name = $request->get('name');
            $sitio_add->sitio_barangay_id = $request->get('barangay_id');
            $sitio_add->sitio_target = $request->get('target');
            $sitio_add->sitio_status = 1;
            $sitio_add->save();
        }

        Session::put('add',true);
        return redirect()->back();
    }

    public function removeSitio(Request $request){
        $sitio = Sitio::find($request->sitio_id);

        //logs deleted purok
        $sitio_deleted = new SitioLogs();
        $sitio_deleted->sitio_id = $sitio->sitio_id;
        $sitio_deleted->sitio_logs_by = Auth::user()->id;
        $sitio_deleted->sitio_name = $sitio->sitio_name;
        $sitio_deleted->sitio_barangay_id = $sitio->sitio_barangay_id;
        $sitio_deleted->sitio_target = $sitio->sitio_targer;
        $sitio_deleted->sitio_status = 'DELETE';
        $sitio_deleted->save();
        //end logs

        $sitio->delete();

        Session::put('remove',true);
        return redirect()->back();
    }

    public function addContent(Request $request){
        $user_brgy = UserBrgy::where('user_id',Auth::user()->id)->get();
        $sitio = Sitio::where('sitio_id',$request->sitio_id)->first();
        return view("sitio.add_content",[
            "user_brgy" => $user_brgy,
            "sitio" => $sitio
        ]);
    }

    public function selectSitioGet(Request $request){
        $sitio = Sitio::where("sitio_barangay_id",$request->barangay_id)->get();
        $sitio_choose = Profile::where('familyID',$request->familyID)->first()->sitio_id;
        return view("sitio.sitio_select",[
            "sitio" => $sitio,
            "familyID" => $request->familyID,
            "sitio_choose" => $sitio_choose
        ]);
    }

    public function selectSitioPost(Request $request){
        $familyID = $request->familyID;
        $profile = Profile::where('familyID',$familyID);

        if($request->clear){
            $profile->update([
                "sitio_id" => null
            ]);
            Session::put('family_updated_sitio','The family had chosen, there Sitio has been cleared');
        } else {
            $profile->update([
                "sitio_id" => $request->sitio_id
            ]);
            Session::put('family_updated_sitio','The family had chosen, there Sitio has been updated');
        }

        return redirect()->back();
    }



}
