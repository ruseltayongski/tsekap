<?php

namespace App\Http\Controllers;

use App\Barangay;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\UserHealthFacility;
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
        $users = User::whereYear('created_at', "=", 2024) // Filter by year 2024
                    ->where(function ($q) use ($keyword) {
                        $q->where('lname', 'like', "%$keyword%")
                        ->orWhere('mname', 'like', "%$keyword%")
                        ->orWhere('fname', 'like', "%$keyword%")
                        ->orWhere('username', 'like', "%$keyword%")
                        ->orWhere('contact', 'like', "%$keyword%");
                    })
        ->where('id', '!=', $id);
          

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
        // Validate if the name already exists
        $validateName = User::where('fname', $req->fname)
            ->where('mname', $req->mname)
            ->where('lname', $req->lname)
            ->first();
        if ($validateName) {
            return redirect('users?duplicate=name');
        }
    
        // Validate if the username already exists
        $validateUsername = User::where('username', $req->username)->first();
        if ($validateUsername) {
            return redirect('users?duplicate=username');
        }
    
        // Create new user record
        $user = new User();
        $user->fname = $req->fname;
        $user->mname = $req->mname;
        $user->lname = $req->lname;
        $user->muncity = $req->muncity;
        $user->province = $req->province;
        $user->username = $req->username;
        $user->password = bcrypt($req->password);
        $user->facility_id = $req->facility;
        $user->contact = $req->contact;
        $user->user_priv = $req->user_priv;
        $user->save();
    
        // Map user to health facility
        $userHfMapping = new UserHealthFacility();
        $userHfMapping->user_id = $user->id;
        $userHfMapping->facility_id = $req->facility;
        $userHfMapping->user_designation = $req->user_designation;
        $userHfMapping->assigned_at = \Carbon\Carbon::now(); // set current timestamp
        $userHfMapping->save();
    
        // Success message
        Session::put('success', 'User successfully saved.');
        
        // Redirect to the users list page or wherever needed
        return redirect('users')->with('success', 'User has been successfully added.');
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
