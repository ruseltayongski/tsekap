<?php

namespace App\Http\Controllers\resu;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


class UsersCtrl extends Controller
{
    //
    public function index(){
      
      //  $keyword = $request->input('keyword');      
        $users = User::select('id','fname','mname','lname','muncity','province','contact','username','user_priv')
            ->whereNotNull('facility_id')
            ->orWhereIn('user_priv', [11,10,7,3,8])
            ->paginate(15);

        $userDetails = User::all();
  
        return view('resu.admin.view_Users', [
            'user' => $users,
            'userDetails'=>$userDetails,
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
        return redirect()->back()->with('success', 'Users added successfully!');
    } 

    public function searchUsers(Request $request)
        {
            $keyword = $request->input('keyword');
            $level = $request->input('level');
            $provinceId = $request->input('province_id');
            $muncityId = $request->input('muncity_id');

            $query = User::select('id','fname', 'mname', 'lname', 'muncity', 'province', 'contact', 'username', 'user_priv')
             //->whereNotNull('facility_id')
            //->orWhereIn('facility_id', [6])
            ->orWhereIn('user_priv', [11, 10, 7, 3, 8,6]); 

            if ($keyword) {
                $query->where(function($query) use ($keyword) { 
                    $query  ->where('id', 'like', '%' . $keyword . '%')
                    ->where('fname', 'like', '%' . $keyword . '%')
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

    public function updateUser(Request $req, $id)
        {
            // Find the user by ID
            $user = User::find($id);
            if (!$user) {
                return redirect()->back()->withErrors(['id' => 'User not found.']);
            }

            // Grouping user attributes
            $userAttributes = [
                'fname' => $req->input('fname'),
                'mname' => $req->input('mname'),
                'lname' => $req->input('lname'),
                'muncity' => $req->input('muncity'),
                'province' => $req->input('province'),
                'username' => $req->input('username'),
                'contact' => $req->input('contact'),
                'user_priv' => $req->input('user_priv'),
                'password' => $req->input('password'),
            ];

            // Update fields only if new values are provided
            foreach ($userAttributes as $key => $value) {
                if ($value !== null && $value !== '') { // Check if the value is not empty or null
                    if ($key === 'username') {
                        // Validate unique username in case of an update
                        $this->validate($req, [
                            'username' => 'required|string|max:255|unique:users,username,' . $id,
                        ]);
                    }

                    if ($key === 'password') {
                        $user->password = bcrypt($value); // Hash the password if it's being updated
                    } else {
                        $user->$key = $value; // Dynamically assign value to the user model
                    }
                }
            }

            // Save changes
            $user->save();

            return redirect()->back()->with('success', 'User updated successfully!');
        }

        public function deleteUser(Request $request)
        {
            $userId = $request->input('user_id');
            $user = User::find($userId);
        
            if ($user) {
                $user->delete();
                return redirect()->route('resu.admin.view_Users')->with('success', 'User deleted successfully.');
            } else {
                return redirect()->route('resu.admin.view_Users')->with('error', 'User not found.');
            }
        }
}