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
      
      //  $keyword = $request->input('keyword');

        $users = User::select('id','fname','mname','lname','muncity','province','contact','username','user_priv')
            ->whereNotNull('facility_id')
            ->orWhereIn('user_priv', [11,10,7,3,8])

            ->paginate(15);
            
        // $fname = explode('-', $users->fname);
        // $getLastword = $users = end($fname);
  
        return view('resu.admin.view_Users', [
            'user' => $users,
            //'keyword'=> $keyword
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

    public function searchUsers(Request $request)
        {
            $keyword = $request->input('keyword');
            $level = $request->input('level');
            $provinceId = $request->input('province_id');
            $muncityId = $request->input('muncity_id');

            $query = User::select('fname', 'mname', 'lname', 'muncity', 'province', 'contact', 'username', 'user_priv')
                ->whereNotNull('facility_id')
                ->orWhereIn('user_priv', [11, 10, 7, 3, 8]);

            if ($keyword) {
                $query->where(function($query) use ($keyword) {
                    $query->where('fname', 'like', '%' . $keyword . '%')
                        ->orWhere('mname', 'like', '%' . $keyword . '%')
                        ->orWhere('lname', 'like', '%' . $keyword . '%')
                        ->orWhere('username', 'like', '%' . $keyword . '%')
                        ->orWhere('muncity', 'like', '%' . $keyword . '%')
                        ->orWhere('province', 'like', '%' . $keyword . '%');
                });
            }

            if ($level) {
                $query->where('user_priv', $level);
            }

            if ($provinceId) {
                $query->where('province', $provinceId);
            }

            if ($muncityId) {
                $query->where('muncity', $muncityId);
            }

            $users = $query->paginate(15);

            return view('resu.admin.view_Users', [
                'user' => $users,
                'keyword' => $keyword,
                'level' => $level,
                'province_id' => $provinceId,
                'muncity_id' => $muncityId
            ]);
        }

}
