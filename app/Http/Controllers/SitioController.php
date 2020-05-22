<?php

namespace App\Http\Controllers;

use App\Sitio;
use App\SitioDeleted;
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

        Sitio::updateOrCreate(
            ["sitio_id" => $request->sitio_id],
            [
                "sitio_created_by" => Auth::user()->id,
                "sitio_name" => $request->get('name'),
                "sitio_barangay_id" => $request->get('barangay_id'),
                "sitio_target" => $request->get('target'),
                "sitio_status" => 1
            ]
        );

        Session::put('add',true);
        return redirect()->back();
    }

    public function removeSitio(Request $request){
        $sitio = Sitio::find($request->sitio_id);

        //logs deleted purok
        $sitio_deleted = new SitioDeleted();
        $sitio_deleted->sitio_id = $sitio->sitio_id;
        $sitio_deleted->sitio_deleted_by = Auth::user()->id;
        $sitio_deleted->sitio_name = $sitio->sitio_name;
        $sitio_deleted->sitio_barangay_id = $sitio->sitio_barangay_id;
        $sitio_deleted->sitio_target = $sitio->sitoi_targer;
        $sitio_deleted->sitio_status = 1;
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
        return view("sitio.sitio_select",[
            "sitio" => $sitio
        ]);
    }



}
