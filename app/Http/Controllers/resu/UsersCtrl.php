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
      

        $users = User::select('id','fname','mname','lname','muncity','province','contact','username','user_priv')
            ->whereNotNull('facility_id')
            ->orWhereIn('user_priv', [11,10,7,3,8])
            ->paginate(15);
            
        // $fname = explode('-', $users->fname);
        // $getLastword = $users = end($fname);
  
        return view('resu.admin.view_Users', [
            'user' => $users
        ]);
    }

    public function AddUsers(Request $req){
        
        $u = new User();
        if($req->Selected_facilities){
            $u->facility_id = $req->Selected_facilities;
        }else{
            $u->fname = $req->fname . '-DSO'; 
        }
        $u->mname = $req->mname;
        $u->lname = $req->lname;
        $u->muncity = $req->muncity;
        $u->province = $req->province;
        $u->username = $req->username;
        $u->password = bcrypt($req->password);
        $u->contact = $req->contact;
        $u->user_priv = $req->user_priv;
        $u->save();
    }
    
}
