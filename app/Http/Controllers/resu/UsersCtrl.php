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
        dd($req->all());
        $u = new User();

  
    }
}
