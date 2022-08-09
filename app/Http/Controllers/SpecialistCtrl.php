<?php

namespace App\Http\Controllers;

use App\Facility;
use App\Facility2;
use App\FacilityAssign;
use App\ReferralUser;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SpecialistCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        if($request->view_all == 'view_all')
            $keyword = null;
        else{
            if(Session::get("specialistKeyword")){
                if(!empty($request->keyword) && Session::get("specialistKeyword") != $request->keyword)
                    $keyword = $request->keyword;
                else
                    $keyword = Session::get("specialistKeyword");
            } else {
                $keyword = $request->keyword;
            }
        }

        Session::put('specialistKeyword',$keyword);

        $data = ReferralUser::select(
            'id as user_id',
            'username',
            'fname',
            'mname',
            'lname',
            'muncity',
            'province'
        )
            ->where('level','doctor')
            ->where('status','active');

        if(isset($keyword)) {
            $data = $data->where('fname','like','%'.$keyword.'%')
                ->orWhere('mname','like','%'.$keyword.'%')
                ->orWhere('lname','like','%'.$keyword.'%')
                ->where('status','active');
        }

        $province = Auth::user()->province;
        $muncity = Auth::user()->muncity;
        $user_priv = Auth::user()->user_priv;

        if($user_priv == 0 || $user_priv == 2) {
            $data = $data->where('muncity',$muncity);
        } else if($user_priv == 3) {
            $data = $data->where('province',$province);
        }

        $data = $data->orderBy('lname','asc')
            ->paginate(20);

        return view('specialist.specialist',[
            'title' => 'List of Health Specialists',
            'data' => $data,
            'dashboard' => (Auth::user()->user_priv == 3 || Auth::user()->user_priv == 1) ? 'app' : 'client'
        ]);
    }

    public function getSpecialist(Request $req) {
        $user_id = $req->user_id;
        $data = ReferralUser::select('id as user_id','username','fname','mname','lname','contact','email')
            ->where('username',$req->username)->first();
        $user_facilities = self::getUserFacilities($data->username);

        $muncity = Auth::user()->muncity;
        $facilities = Facility::select(
            'id as facility_id',
            'name as facility_name',
            'facility_code'
        )->where('muncity',$muncity)->orderBy('name','asc')->get();

        return view('specialist.specialist_body',[
            'data' => $data,
            'user_facilities' => $user_facilities,
            'facilities' => $facilities
        ]);
    }

    public static function getUserFacilities($username) {
        $data = FacilityAssign::select(
            'facility_assignment.username',
            'facility_assignment.facility_code',
            'facility_assignment.specialization',
            'facility_assignment.schedule',
            'facility_assignment.fee',
            'facility_assignment.contact',
            'facility_assignment.email',
            'facility.name as facility_name'
        )
            ->leftJoin('doh_referral.facility','facility.facility_code','=','facility_assignment.facility_code')
            ->where('facility_assignment.username',$username)->get();

        if(count($data) == 0) {
            $data = ReferralUser::select(
                'users.id as user_id',
                'users.facility_id',
                'users.contact',
                'users.email',
                'facility.name as facility_name',
                'facility.facility_code'
            )
                ->leftJoin('facility','facility.id','=','users.facility_id')
                ->where('users.username',$username)->get();
        }

        return $data;
    }

    public function addSpecialist(Request $req){
        $username = $req->username;
        $today = Carbon::now()->format('ymdhi');

        if($username) {
            $data = array(
                'fname' => $req->fname,
                'mname' => $req->mname,
                'lname' => $req->lname,
            );
            ReferralUser::where('username', $username)->update($data);
            $delete = FacilityAssign::select('facility_code')->where('username',$username)->get();

            for ($i = 0; $i < count($req->affil_faci); $i++) {
                $faci_code = $req->affil_faci[$i];
                $faci_data = array(
                    'username' => $req->username,
                    'facility_code' => isset($faci_code) ? $faci_code : null,
                    'specialization' => $req->specialization[$i],
                    'schedule' => $req->schedule[$i],
                    'fee' => ($req->specialist_fee[$i] !== "PHP .") ? $req->specialist_fee[$i] : "",
                    'contact' => $req->contact[$i],
                    'email' => $req->email[$i]
                );
                
                $check = FacilityAssign::where('username', $username)->where('facility_code', $faci_code)->first();
                if(isset($check) && $check != '') {
                    FacilityAssign::where('username', $username)->where('facility_code', $faci_code)->update($faci_data);
                } else {
                    FacilityAssign::create($faci_data);
                }

                for($counter = 0; $counter < count($delete); $counter++) {
                    if($faci_code == $delete[$counter]->facility_code) {
                        $delete[$counter] = null;
                        break;
                    }
                }

//                foreach ($req->remove_facility as $remove) {
//                    FacilityAssign::where('username', $username)->where('facility_code', $remove)->delete();
//                }
            }

            foreach($delete as $code) {
                FacilityAssign::where('username', $username)->where('facility_code', $code->facility_code)->delete();
            }
            Session::put('specialist_msg', 'Successfully updated specialist information!');
        } else {
            $data = array(
                'fname' => $req->fname,
                'mname' => $req->mname,
                'lname' => $req->lname,
                'username' => ($req->username) ? $req->username : strtolower(substr($req->fname,0,1).str_replace(' ','',$req->lname).$today),
                'password' => ($req->password) ? $req->password: bcrypt('123'),
                'level' => 'doctor',
                'facility_id' => 0,
                'department_id' => 0,
                'muncity' => Auth::user()->muncity,
                'province' => Auth::user()->province,
                'designation' => '',
                'status' => 'active',
                'email' => '',
                'contact' => ''
            );
            $username = ReferralUser::create($data)->username;
            for($i = 0; $i < count($req->affil_faci); $i++) {
                $facility = new FacilityAssign();
                $facility->username = $username;
                $facility->facility_code = $req->affil_faci[$i];
                $facility->specialization = $req->specialization[$i];
                $facility->schedule = $req->schedule[$i];
                $facility->fee = $req->specialist_fee[$i];
                $facility->contact = $req->contact[$i];
                $facility->email = $req->email[$i];
                $facility->save();
            }
            Session::put('specialist_msg','Successfully added specialist information!');
        }

        Session::put('specialist_notif',true);
        return Redirect::back();
    }

    public function deleteSpecialist(Request $req) {
        ReferralUser::where('username',$req->username)->update(['status' => 'inactive']);
        FacilityAssign::where('username',$req->username)->delete();
        Session::put('specialist_msg','Successfully deleted specialist information!');
        Session::put('specialist_notif',true);
        return Redirect::back();
    }

    public function verify(Request $req) {
        $profile = ReferralUser::select('id as user_id','fname','mname','lname','muncity','province','username')
            ->where('level','doctor')
            ->where('status','active');

        if($req->fname == '' && $req->mname == '' && $req->lname == '')
            return '';

        if($req->fname){
            $profile = $profile->where('fname','like',"%".$req->fname."%");
        }
        if($req->mname){
            $profile = $profile->where('mname','like',"%".$req->mname."%");
        }
        if($req->lname){
            $profile = $profile->where('lname','like',"%".$req->lname."%");
        }

        $province = Auth::user()->province;
        $muncity = Auth::user()->muncity;
        $user_priv = Auth::user()->user_priv;

        if($user_priv == 0 || $user_priv == 2) {
            $profile = $profile->where('muncity',$muncity)->get();
        } else if($user_priv == 3) {
            $profile = $profile->where('province',$province)->get();
        }

        return $profile;
    }
}