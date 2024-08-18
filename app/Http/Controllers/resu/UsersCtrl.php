<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UsersCtrl extends Controller
{
    //
    public function index(){
        
        return view('resu.admin.view_Users');
    }

    public function AddUsers(Request $req){
        
        $u = new User();

        $u->fname = $req->fname . '-DSO'; 
        $u->mname = $req->mname;
        $u->lname = $req->lname;
        $u->muncity = $req->muncity;
        $u->province = $req->province;
        $u->username = $req->username;
        $u->password = bcrypt($req->password);
        $u->contact = $req->contact;
        $u->user_priv = $req->user_priv;
        $u->facility_id = $req->Selected_facilities;

        $u->save();
    }
}
