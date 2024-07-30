<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Profile;

class ClientVerifyController extends Controller
{
    //
    public function CheckClients(Request $req){
        $fname = $req->input('fname');
        $lname = $req->input('lname');
        $mname = $req->input('mname');
        $dob = $req->input('dob');
   
        $profile = Profile::select('unique_id','fname','mname','lname','dob','id');

        if($req->fname){
            $profile = $profile->where('fname','like',"%$fname%");
        }
        if($req->mname){
            $profile = $profile->where('mname','like',"%$mname%");
        }
        if($req->lname){
            $profile = $profile->where('lname','like',"%$lname%");
        }
        if($req->dob){
            $profile = $profile->where('dob',"$dob%");
        }

        $profiles = $profile->orderBy('lname', 'asc')
        ->limit(20)
        ->get();

        return response()->json($profiles);
    }
}
