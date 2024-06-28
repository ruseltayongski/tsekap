<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ResuNatureInjury;
use App\ResuBodyParts;

use Illuminate\Support\Facades\Redirect; // Import Redirect facade

class InjuryController extends Controller
{
    //
    public function index(){
        $user = Auth::user();

        $injured = ResuNatureInjury::all();

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
}
