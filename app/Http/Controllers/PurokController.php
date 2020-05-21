<?php

namespace App\Http\Controllers;

use App\Purok;
use App\PurokDeleted;
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
    public function Purok(){
        $user_brgy = UserBrgy::where('user_id',Auth::user()->id)->get();
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
                ->leftJoin('barangay','barangay.id','=','purok.purok_barangay_id')
                ->leftJoin('users','users.id','=','purok.purok_created_by')
                ->get();

        return view('purok.purok',[
            "purok" => $purok
        ]);
    }

    public function addPurok(Request $request){
        Purok::updateOrCreate(
            ["purok_id" => $request->purok_id],
            [
                "purok_created_by" => Auth::user()->id,
                "purok_name" => $request->get('name'),
                "purok_barangay_id" => $request->get('barangay_id'),
                "purok_target" => $request->get('target'),
                "purok_status" => 1
            ]
        );

        Session::put('add',true);
        return redirect()->back();
    }

    public function removePurok(Request $request){
        $purok = Purok::find($request->purok_id);

        //logs deleted purok
        $purok_deleted = new PurokDeleted();
        $purok_deleted->purok_id = $purok->purok_id;
        $purok_deleted->purok_deleted_by = Auth::user()->id;
        $purok_deleted->purok_name = $purok->purok_name;
        $purok_deleted->purok_barangay_id = $purok->purok_barangay_id;
        $purok_deleted->purok_target = $purok->purok_targer;
        $purok_deleted->purok_status = 1;
        $purok_deleted->save();
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

}
