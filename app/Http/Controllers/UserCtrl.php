<?php

namespace App\Http\Controllers;

use App\Barangay;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\UserBrgy;
use Illuminate\Support\Facades\Hash;

class UserCtrl extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(){
        $data = Session::get('userKeyword');
        $keyword = $data['keyword'];
        $province_id = $data['province_id'];
        $muncity_id = $data['muncity_id'];
        $level = $data['level'];

        $user = Auth::user();
        $id = $user->id;
        $users = User::where(function($q) use ($keyword){
                            $q->where('lname','like',"%$keyword%")
                                ->orwhere('mname','like',"%$keyword%")
                                ->orwhere('fname','like',"%$keyword%")
                                ->orwhere('username','like',"%$keyword%")
                                ->orwhere('contact','like',"%$keyword%");
                        })
            ->where('id','!=',$id);

        if($user->user_priv==3){
            $users = $users->where('user_priv','!=',1)
                        ->where('province',$user->province);
        }
        if($level || $level=='0') {
            $users = $users->where('user_priv',$level);
        }
        if($province_id){
            $users = $users->where('province',$province_id);
        }
        if($muncity_id){
            $users = $users->where('muncity',$muncity_id);
        }

        $users = $users->paginate(15);
        return view('user.index',[
            'users'=>$users,
            'province_id' => $province_id,
            'muncity_id' => $muncity_id,
            'keyword' => $keyword,
            'level' => $level,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = array(
            'keyword' => $request->keyword,
            'province_id' => $request->province_id,
            'muncity_id' => $request->muncity_id,
            'level' => $request->level,
        );
        Session::put('userKeyword',$keyword);
        return self::index();
    }

    public function save(Request $req)
    {
        $validateName = User::where('fname',$req->fname)
            ->where('mname',$req->mname)
            ->where('lname',$req->lname)
            ->first();
        if($validateName){
            return redirect('users?duplicate=name');
        }

        $validateUsername = User::where('username',$req->username)->first();
        if($validateUsername){
            return redirect('users?duplicate=username');
        }

        $q = new User();
        $q->fname = $req->fname;
        $q->mname = $req->mname;
        $q->lname = $req->lname;
        $q->muncity = $req->muncity;
        $q->province = $req->province;
        $q->username = $req->username;
        $q->password = bcrypt($req->password);
        $q->contact = $req->contact;
        $q->user_priv = $req->user_priv;
        $q->save();
        Session::put('success',true);
        return redirect()->back();
    }

    public function info($id){
        $info = User::find($id);
        $delete = array(
            'table' => 'users',
            'id' => $id
        );
        Session::put('toDelete',$delete);
        return $info;
    }

    public function update(Request $r)
    {
        echo '<pre>';
        print_r($_POST);
        $update = array(
          'fname' => $r->fname,
          'mname' => $r->mname,
          'lname' => $r->lname,
          'province' => $r->province,
          'muncity' => $r->muncity,
          'username' => $r->username,
          'user_priv' => $r->user_priv
        );
        print_r($update);
        $validateName = User::where('fname',$r->fname)
            ->where('mname',$r->mname)
            ->where('lname',$r->lname)
            ->where('id','!=',$r->currentID)
            ->first();
        if($validateName){
            return redirect('users?duplicate=name');
        }

        $validateUsername = User::where('username',$r->username)
            ->where('id','!=',$r->currentID)
            ->first();
        if($validateUsername){
            return redirect('users?duplicate=username');
        }

        if($r->password){
            $update['password'] = bcrypt($r->password);
        }
        $update['contact'] = $r->contact;
        User::where('id',$r->currentID)
            ->update($update);
        Session::put('update',true);
        return redirect('users');

    }

    public function assign($id)
    {
        $muncity = User::find($id)->muncity;
        $barangay = Barangay::where('muncity_id',$muncity)->orderBy('description','asc')->get();
        return view('user.assign',['barangay'=>$barangay, 'user_id' => $id ]);
    }

    public function password()
    {
        return view('passwordAdmin');
    }

    public function changePassword(Request $req)
    {
        $current = bcrypt($req->current);

        $password = Auth::user()->password;
        $try = Session::get('tryPass');
        if(Hash::check($req->current,$password)) {
            if($req->new==$req->confirm){
                $id = Auth::user()->id;
                $update = array(
                    'password' => bcrypt($req->new)
                );
                User::where('id',$id)
                    ->update($update);
                return redirect()->back()->with('status','updated');
            }else{
                return redirect()->back()->with('status','notsame');
            }
        } else {
            $try++;
            if($try>2){
                return redirect('logout');
            }
            Session::put('tryPass',$try);
            return redirect()->back()->with('status','notequal');
        }
    }

    static function validateBrgy()
    {
        return true;
//        if(Auth::user()->user_priv==2){
//            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
//            foreach($tmpBrgy as $tmp){
//                if($tmp->barangay_id==1875){
//                    return true;
//                }
//            }
//            if(count($tmpBrgy)==0){
//                return false;
//            }
//        }else{
//            return false;
//        }
    }

    static function getUser($id){
        return User::find($id);
    }
}
