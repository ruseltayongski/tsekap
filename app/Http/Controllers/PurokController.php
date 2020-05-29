<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Purok;
use App\PurokLogs;
use Illuminate\Support\Facades\Session;
use App\User;
use App\UserBrgy;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PurokController extends Controller
{
    public function Purok(Request $request){
        $user_brgy = UserBrgy::where('user_id',Auth::user()->id)->get();

        $purok_keyword = "";
        if($request->view_all){
            $purok_keyword = null;
            Session::put('purok_keyword',null);
        }
        elseif($request->purok_keyword){
            $purok_keyword = $request->purok_keyword;
            Session::put('purok_keyword',$purok_keyword);
        }
        elseif(Session::get('purok_keyword')){
            $purok_keyword = Session::get('purok_keyword');
        }

        $purok = Purok::
                    select("purok.*",
                           "barangay.description as barangay",
                            DB::raw("concat(users.fname,' ',users.mname,' ',users.lname) as created_by"
                    ))
                    ->where(function($q) use ($user_brgy){
                        foreach($user_brgy as $bar){
                            $q->orwhere('purok.purok_barangay_id',$bar->barangay_id);
                        }
                    })
                    ->where('purok.purok_name','like',"%$purok_keyword%")
                    ->leftJoin('barangay','barangay.id','=','purok.purok_barangay_id')
                    ->leftJoin('users','users.id','=','purok.purok_created_by')
                    ->orderBy('purok.purok_name','asc')
                    ->paginate(15);

        return view('purok.purok',[
            "purok" => $purok
        ]);
    }

    public function addPurok(Request $request){
        $purok_check = Purok::find($request->purok_id);
        if($purok_check){
            $purok_check->update([
                "purok_created_by" => Auth::user()->id,
                "purok_name" => $request->get('name'),
                "purok_barangay_id" => $request->get('barangay_id'),
                "purok_target" => $request->get('target'),
                "purok_status" => 1
            ]);

            //logs purok
            $purok_logs = new PurokLogs();
            $purok_logs->purok_id = $purok_check->purok_id;
            $purok_logs->purok_logs_by = Auth::user()->id;
            $purok_logs->purok_name = $purok_check->purok_name;
            $purok_logs->purok_barangay_id = $purok_check->purok_barangay_id;
            $purok_logs->purok_target = $purok_check->purok_targer;
            $purok_logs->purok_status = 'UPDATE';
            $purok_logs->save();
            //end logs
        } else {
            $purok_add = new Purok();
            $purok_add->purok_created_by = Auth::user()->id;
            $purok_add->purok_name = $request->get('name');
            $purok_add->purok_barangay_id = $request->get('barangay_id');
            $purok_add->purok_target = $request->get('target');
            $purok_add->purok_status = 1;
            $purok_add->save();
        }

        Session::put('add',true);
        return redirect()->back();
    }

    public function removePurok(Request $request){
        $purok = Purok::find($request->purok_id);

        //logs purok
        $purok_logs = new PurokLogs();
        $purok_logs->purok_id = $purok->purok_id;
        $purok_logs->purok_logs_by = Auth::user()->id;
        $purok_logs->purok_name = $purok->purok_name;
        $purok_logs->purok_barangay_id = $purok->purok_barangay_id;
        $purok_logs->purok_target = $purok->purok_targer;
        $purok_logs->purok_status = 'DELETE';
        $purok_logs->save();
        //end logs

        $purok->delete();

        Session::put('remove',true);
        return redirect()->back();
    }

    public function addContent(Request $request){
        $user_brgy = UserBrgy::where('user_id',Auth::user()->id)->get();
        $purok = Purok::where('purok_id',$request->purok_id)->first();
        return view("purok.add_content",[
            "user_brgy" => $user_brgy,
            "purok" => $purok
        ]);
    }

    public function selectPurokGet(Request $request){
        $purok = Purok::where("purok_barangay_id",$request->barangay_id)->get();
        $purok_choose = Profile::where('familyID',$request->familyID)->first()->purok_id;
        return view("purok.purok_select",[
            "purok" => $purok,
            "familyID" => $request->familyID,
            "purok_choose" => $purok_choose
        ]);
    }

    public function selectPurokPost(Request $request){
        $familyID = $request->familyID;
        $profile = Profile::where('familyID',$familyID);

        if($request->clear){
            $profile->update([
                "purok_id" => null
            ]);
            Session::put('family_updated_purok','The family had chosen, there Purok has been cleared');
        } else {
            $profile->update([
                "purok_id" => $request->purok_id
            ]);
            Session::put('family_updated_purok','The family had chosen, there Purok has been updated');
        }

        return redirect()->back();
    }

}
