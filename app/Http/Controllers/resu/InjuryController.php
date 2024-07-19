<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ResuNatureInjury;
use App\ResuBodyParts;
use App\ResuExternalInjury;
use App\ResuTransportAccident;
use App\ResuSafety;
use Illuminate\Support\Facades\Redirect; // Import Redirect facade

class InjuryController extends Controller
{
    //
    public function index(){
        $user = Auth::user();

        $injured = ResuNatureInjury::paginate(13);

        return view('resu.injury.nature_injury', [
            'injured' =>  $injured,
            'user_priv' => $user
        ]);
    }

    public function bodypart(){
        $user = Auth::user();
        
        $b_body = ResuBodyParts::paginate(13);
        
        return view('resu.partsbody.bodyparts', [
            'b_parts' => $b_body,
            'user_priv' => $user
        ]);
    }

    public function addinjury(Request $r)
    {
        $injured = new ResuNatureInjury();
        $injured->name = $r->name;
        $injured->save();

        return Redirect::back();
    }

    public function addbodypart(Request $r){
        
        $b_part = new ResuBodyParts();

        $b_part->name = $r->name;
        $b_part->save();

        return Redirect::back();
    }

    public function Listbodyparts(){

        $b_part = ResuBodyParts::all();

        return response()->json($b_part);
    }

    public function listExternal(){

        $external = ResuExternalInjury::paginate(13);
    
        return view('resu.injury.external_injury', [
            'external' => $external
        ]);
     }

    public function addExternal(Request $r){
       
        $external = new ResuExternalInjury();

        $external->name = $r->name;
        $external->save();

        return Redirect::back();
    }

    public function viewAccident(){
        $rtaccident = ResuTransportAccident::paginate(13);

        return view('resu.accident.accident', [
            'accidentType' => $rtaccident
        ]);
    }

    public function AddAccidenttype(Request $req){

        $rtaccident = new ResuTransportAccident();

        $rtaccident->description = $req->Description;
        $rtaccident->save();

        return Redirect::back();

    }

    public function safetyView(){
        $saftey = ResuSafety::paginate(13);
        return view('resu.accident.safety', [
            'safetytype' => $saftey 
        ]);
    }

    public function Savesafety(Request $req){

       $safety = new ResuSafety();

       $safety->name = $req->name;

       $safety->save();

       return Redirect::back();
    }
}
