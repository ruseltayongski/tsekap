<?php

namespace App\Http\Controllers;

use App\ProfileCases;
use App\ServiceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Profile;
use App\ProfileServices;
use App\User;
use App\Weight;
use App\Height;
use App\Service;
use App\Feedback;
use App\UserBrgy;
use Illuminate\Support\Facades\Hash;
use App\Session as Sess;

class ParameterCtrl extends Controller
{
    static function getStaticAge($dob,$date)
    {
        $d1 = strtotime($dob);
        $d2 = strtotime($date);
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);

        $age = 0;
        while (($min_date = strtotime("+1 YEAR", $min_date)) <= $max_date) {
            $age++;
        }

        if($age == 0){
            $d1 = strtotime($dob);
            $d2 = strtotime($date);
            $min_date = min($d1, $d2);
            $max_date = max($d1, $d2);

            while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
                $age++;
            }
            if($age == 0){
                $d1 = strtotime($dob);
                $d2 = strtotime($date);
                $min_date = min($d1, $d2);
                $max_date = max($d1, $d2);

                while (($min_date = strtotime("+1 DAY", $min_date)) <= $max_date) {
                    $age++;
                }
                return '<small>('.$age.' D/o)</small>';
            }
            return '<small>('.$age.' M/o)</small>';
        }
        return $age;
    }

    static function getAge($date){
        //date in mm/dd/yyyy format; or it can be in other formats as well
        $birthDate = date('m/d/Y',strtotime($date));
        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
        return $age;
    }

    static function getAgeMonth($date){
        $d1 = strtotime($date);
        $d2 = strtotime(date('Y-m-d'));
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);

        $i = 0;
        while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
            $i++;
        }
        return $i;
    }

    static function getAgeDay($date){
        $d1 = strtotime($date);
        $d2 = strtotime(date('Y-m-d'));
        $min_date = min($d1, $d2);
        $max_date = max($d1, $d2);

        $i = 0;
        while (($min_date = strtotime("+1 DAY", $min_date)) <= $max_date) {
            $i++;
        }
        return $i;
    }

    public function delete()
    {
        $data = Session::get('toDelete');
        Session::put('delete',true);
        $id = $data['id'];
        $table = $data['table'];
        $profile_id = Profile::find($id)->unique_id;
        DB::table($table)->where('id',$id)->delete();
        if($table=='profile')
        {
            DB::table('profileservices')->where('profile_id',$profile_id)->delete();
            DB::table('profilecases')->where('profile_id',$profile_id)->delete();
            DB::table('servicegroup')->where('profile_id',$profile_id)->delete();
            return redirect('user/population')->with('status','deleted');
        }

        Session::forget('toDelete');
        return redirect()->back()->with('status','deleted');
    }

    static function countServices2($sex,$code=null,$bracket_id,$month,$year,$status=null,$measurement=null)
    {
        $user = Auth::user();
        $start = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT).'-01';
        $end = $year.'-'.str_pad($month+1, 2, '0', STR_PAD_LEFT).'-01';
        if($month=='ALL'){
            $start = $year.'-01-01';
            $end = $year+1 . '-01-01';
        }
        $province_id = $user->province;
        $muncity_id = $user->muncity;
        $count = ProfileServices::leftJoin('services','profileservices.service_id','=','services.id')
            ->leftJoin('serviceoption','profileservices.profile_id','=','serviceoption.profile_id')
            ->leftJoin('muncity','profileservices.muncity_id','=','muncity.id');
        if($status){
            $count = $count->leftJoin('femalestatus','profileservices.profile_id','=','femalestatus.profile_id');
        }
        if($sex && $sex!='all'){
            $count = $count->where('profileservices.sex',"$sex");
        }
        if($sex='all'){
            $count = $count->where(function($q){
                $q->where('profileservices.sex','Male')
                    ->orwhere('profileservices.sex','Female');
            });


        }

        if($code!='DRUG' && $code!='ALL' && $code!='SUB'){
            $count = $count->where('services.code',"$code");
        }else if($code=='DRUG'){
            $count = $count->where(function($q){
                $q->where('services.code','SC')
                    ->orwhere('services.code','CNS')
                    ->orwhere('services.code','DT')
                    ->orwhere('services.code','RR');
            });
        }else{
            $count = $count->where(function($q){
                $q->where('services.code','!=','SC')
                    ->orwhere('services.code','!=','CNS')
                    ->orwhere('services.code','!=','DT')
                    ->orwhere('services.code','!=','RR');
            });
        }

        if($bracket_id){
            $count = $count->where('profileservices.bracket_id',$bracket_id);
        }

        if($user->user_priv == 3){
            $count = $count->where('muncity.province_id',$province_id);
        }else if($user->user_priv == 0){
            $count = $count->where('profileservices.muncity_id',$muncity_id);
        }else if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $count = $count->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profileservices.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $count = $count->where('profileservices.barangay_id',0);
            }
        }
        if($status && $code!='SUB'){
            $count = $count->where('femalestatus.status',$status)
                ->where('femalestatus.code',$code);
        }else if($status && $code=='SUB'){
            $count = $count->where('femalestatus.status',$status);
        }

        if($measurement=='ob'){
            $count = $count->where('serviceoption.status',1)
                ->where('serviceoption.option','weight');
        }else if($measurement=='un'){
            $count = $count->where('serviceoption.status',2)
                ->where('serviceoption.option','weight');
        }else if($measurement=='stn'){
            $count = $count->where('serviceoption.status',1)
                ->where('serviceoption.option','height');
        }
        $count = $count->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<',$end)
            ->groupBy('profileservices.profile_id')
            ->get();
        return count($count);
    }


    static function countServices($sex,$code=null,$bracket_id,$month,$year,$status=null,$measurement=null)
    {
        $user = Auth::user();
        $start = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT).'-01';
        $end = $year.'-'.str_pad($month+1, 2, '0', STR_PAD_LEFT).'-01';
        if($month=='ALL'){
            $start = $year.'-01-01';
            $end = $year+1 . '-01-01';
        }
        $province_id = $user->province;
        $muncity_id = $user->muncity;
        $count = ProfileServices::select('profileservices.profile_id')
            ->leftJoin('services','profileservices.service_id','=','services.id')
            ->leftJoin('muncity','profileservices.muncity_id','=','muncity.id')
            ->leftJoin('serviceoption','profileservices.profile_id','=','serviceoption.profile_id');
        if($sex && $sex!='all'){
            $count = $count->where('profileservices.sex',"$sex");
        }
        if($sex='all'){
            $count = $count->where(function($q){
                $q->where('profileservices.sex','Male')
                    ->orwhere('profileservices.sex','Female');
            });


        }

        if($code!='DRUG' && $code!='ALL' && $code!='SUB' && $code!='others'){
            $count = $count->where('services.code',"$code");
        }else if($code=='DRUG'){
            $count = $count->where(function($q){
                $q->where('services.code','SC')
                    ->orwhere('services.code','CNS')
                    ->orwhere('services.code','DT')
                    ->orwhere('services.code','RR');
            });
        }else if($code=='others'){
            $count = $count->where(function($q){
                $q->where('services.code','RBS')
                    ->orwhere('services.code','SPE');
            });
        }else{
            $count = $count->where(function($q){
                $q->where('services.code','!=','SC')
                    ->orwhere('services.code','!=','CNS')
                    ->orwhere('services.code','!=','DT')
                    ->orwhere('services.code','!=','RR');
            });
        }

        if($bracket_id){
            $count = $count->where('profileservices.bracket_id',$bracket_id);
        }

        if($user->user_priv == 3){
            $count = $count->where('muncity.province_id',$province_id);
        }else if($user->user_priv == 0){
            $count = $count->where('profileservices.muncity_id',$muncity_id);
        }else if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $count = $count->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profileservices.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $count = $count->where('profileservices.barangay_id',0);
            }
        }
        if($status && $code!='SUB'){
            $count = $count->where('profileservices.status',$status)
                ->where('services.code',$code);
        }else if($status && $code=='SUB'){
            $count = $count->where('profileservices.status',$status);
        }

        if($measurement=='ob'){
            $count = $count->where('serviceoption.status',1)
                ->where('serviceoption.option','weight');
        }else if($measurement=='un'){
            $count = $count->where('serviceoption.status',2)
                ->where('serviceoption.option','weight');
        }else if($measurement=='stn'){
            $count = $count->where('serviceoption.status',1)
                ->where('serviceoption.option','height');
        }
        $count = $count->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<',$end)
            ->groupBy('profileservices.profile_id')
            ->get();
        return count($count);
    }

    static function countCases($sex,$bracket_id,$month,$year,$case_id=null,$status=null)
    {
        $user = Auth::user();
        $start = $year.'-'.str_pad($month, 2, '0', STR_PAD_LEFT).'-01';
        $end = $year.'-'.str_pad($month+1, 2, '0', STR_PAD_LEFT).'-01';
        if($month=='ALL'){
            $start = $year.'-01-01';
            $end = $year+1 . '-01-01';
        }
        $province_id = $user->province;
        $muncity_id = $user->muncity;
        $count = ProfileCases::leftJoin('muncity','profilecases.muncity_id','=','muncity.id')
            ->where('profilecases.dateProfile','>=',$start)
            ->where('profilecases.dateProfile','<',$end);
        if($sex){
            $count = $count->where('profilecases.sex',"$sex");
        }

        if($bracket_id){
            $count = $count->where('profilecases.bracket_id',$bracket_id);
        }

        if($case_id){
            $count = $count->where('profilecases.case_id',$case_id);
        }

        if($status){
            $count = $count->where('profilecases.status',$status);
        }

        if($user->user_priv == 3){
            $count = $count->where('muncity.province_id',$province_id);
        }else if($user->user_priv == 0){
            $count = $count->where('profilecases.muncity_id',$muncity_id);
        }else if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $count = $count->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profilecases.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $count = $count->where('profilecases.barangay_id',0);
            }
        }

        $count = $count->groupBy('profilecases.profile_id')
            ->get();
        return count($count);
    }
    static function countMustService($level)
    {
        $db = 'db_'.date('Y');
        $user = Auth::user();
        $start = date('Y').'-01-01';
        $end = (date('Y')+1).'-01-01';
        $servicegroup = new ServiceGroup();
        $servicegroup->setConnection($db);
        $count = $servicegroup->leftJoin('tsekap_main.muncity','servicegroup.muncity_id','=','muncity.id')
            ->where('servicegroup.group1',1)
            ->where('servicegroup.group2',1)
            ->where('servicegroup.group3',1);
        if($level === 'province'){
            $count = $count->where('tsekap_main.muncity.province_id',$user->province);
        }else if($level === 'muncity'){
            $count = $count->where('servicegroup.muncity_id',$user->muncity);
        }else if($level === 'barangay'){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $count = $count->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('servicegroup.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $count = $count->where('servicegroup.barangay_id',0);
            }
        }
        $count = $count->where(function($q){
            $q->where('servicegroup.sex','Male')
                ->orwhere('servicegroup.sex','Female');
        });
        $count = $count->where('servicegroup.dateProfile','>=',$start)
                    ->where('servicegroup.dateProfile','<',$end)
                    ->count();

        return $count;
    }

    static function countMustService2($level)
    {
        $user = Auth::user();
        $start = date('Y').'-01-01';
        $end = (date('Y')+1).'-01-01';
        $count = ServiceGroup::leftJoin('muncity','servicegroup.muncity_id','=','muncity.id')
            ->where('servicegroup.group1',1)
            ->where('servicegroup.group2',1)
            ->where('servicegroup.group3',1);
        if($level === 'province'){
            $count = $count->where('muncity.province_id',$user->province);
        }else if($level === 'muncity'){

        }else if($level === 'barangay'){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $count = $count->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('servicegroup.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $count = $count->where('servicegroup.barangay_id',0);
            }
        }
        $count = $count->where(function($q){
            $q->where('servicegroup.sex','Male')
                ->orwhere('servicegroup.sex','Female');
        });
        $count = $count->where('servicegroup.dateProfile','>=',$start)
            ->where('servicegroup.dateProfile','<',$end)
            ->get();
        return $count;
    }

    static function countMustServiceMonthly($sex,$bracket_id,$month,$year,$status=null)
    {
        $user = Auth::user();
        if($month && $year){
            $start = $year.'-01-01';
            $end = $year.'-'.str_pad($month+1, 2, '0', STR_PAD_LEFT).'-01';

            if($month=='ALL'){
                $start = $year.'-01-01';
                $end = $year+1 . '-01-01';
            }
        }else{
            $start = date('Y').'-01-01';
            $end = (date('Y')+1).'-01-01';
        }

        $province_id = $user->province;
        $muncity_id = $user->muncity;

        $count = ServiceGroup::select('servicegroup.profile_id')
            ->leftJoin('muncity','servicegroup.muncity_id','=','muncity.id');

        if($status){
            $count = $count->leftJoin('profileservices','servicegroup.profile_id','=','profileservices.profile_id');
        }
        if($bracket_id) {
            $count = $count->where('servicegroup.bracket_id',$bracket_id);
        }
        if($sex){
            $count = $count->where('servicegroup.sex',$sex);
        }

        if($status){
            $count = $count->where('profileservices.status',$status);
        }

        if($user->user_priv == 3){
            $count = $count->where('muncity.province_id',$province_id);
        }else if($user->user_priv == 0 || $user->user_priv == 4){
            $count = $count->where('servicegroup.muncity_id',$muncity_id);
        }else if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $count = $count->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('servicegroup.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $count = $count->where('servicegroup.barangay_id',0);
            }
        }
        $count = $count->where('servicegroup.group1',1)
            ->where('servicegroup.group2',1)
            ->where('servicegroup.group3',1)
            ->where('servicegroup.dateProfile','>=',$start)
            ->where('servicegroup.dateProfile','<',$end)
            ->groupBy('servicegroup.profile_id')
            ->get();
        return count($count);

    }

    static function countValidService($sex,$bracket_id,$month,$year,$status=null)
    {
        $user = Auth::user();
        if($month && $year){
            $start = $year.'-01-01';
            $end = $year.'-'.str_pad($month+1, 2, '0', STR_PAD_LEFT).'-01';

            if($month=='ALL'){
                $start = $year.'-01-01';
                $end = $year+1 . '-01-01';
            }
        }else{
            $start = date('Y').'-01-01';
            $end = (date('Y')+1).'-01-01';
        }


        $province_id = $user->province;
        $muncity_id = $user->muncity;


        $group1 = array('PE');
        $group2 = array('BT', 'CBC', 'URI', 'BST', 'SE', 'FBS', 'SPE', 'RBS','DT');
        $group3 = array('HEPS', 'WM', 'HM', 'WUN', 'CNL', 'CMD', 'EE', 'ERE', 'OS', 'BP', 'SC','CNS','RR');


        $profiles = ProfileServices::select('profileservices.profile_id')
                    ->leftJoin('services','profileservices.service_id','=','services.id')
                    ->leftJoin('muncity','profileservices.muncity_id','=','muncity.id');

        if($status){
            $profiles = $profiles->leftJoin('femalestatus','profileservices.profile_id','=','femalestatus.profile_id');
        }
        if($bracket_id) {
            $profiles = $profiles->where('profileservices.bracket_id',$bracket_id);
        }
        if($sex){
            $profiles = $profiles->where('profileservices.sex',$sex);
        }

        if($status){
            $profiles = $profiles->where('femalestatus.status',$status);
        }

        if($user->user_priv == 3){
            $profiles = $profiles->where('muncity.province_id',$province_id);
        }else if($user->user_priv == 0 || $user->user_priv == 4){
            $profiles = $profiles->where('profileservices.muncity_id',$muncity_id);
        }else if($user->user_priv == 2){
            $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
            $profiles = $profiles->where(function($q) use ($tmpBrgy){
                foreach($tmpBrgy as $tmp){
                    $q->orwhere('profileservices.barangay_id',$tmp->barangay_id);
                }
            });
            if(count($tmpBrgy)==0){
                $profiles = $profiles->where('profileservices.barangay_id',0);
            }
        }

        $profiles = $profiles->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<',$end)
            ->groupBy('profileservices.profile_id')
            ->get();

        $total = 0;

        foreach($profiles as $p){
            $c = 0;
            $tmp = self::groupService($group1,$p->profile_id,$month,$year);
            if($tmp>0){
                $c++;

                $tmp = self::groupService($group2,$p->profile_id,$month,$year);
                if($tmp>0){
                    $c++;

                    $tmp = self::groupService($group3,$p->profile_id,$month,$year);
                    if($tmp>0){
                        $c++;
                    }
                }
            }

            if($c > 2){
                $total++;
            }
        }
        return $total;
    }

    public static function groupService($group,$profile_id,$month,$year){
        if($month && $year){
            $start = $year.'-01-01';
            $end = $year.'-'.str_pad($month+1, 2, '0', STR_PAD_LEFT).'-01';
            if($month=='ALL'){
                $start = $year.'-01-01';
                $end = $year+1 . '-01-01';
            }
        }else{
            $start = date('Y').'-01-01';
            $end = (date('Y')+1).'-01-01';
        }

        $profiles = ProfileServices::leftJoin('services','profileservices.service_id','=','services.id')
            ->where('profileservices.dateProfile','>=',$start)
            ->where('profileservices.dateProfile','<',$end)
            ->where('profileservices.profile_id',$profile_id);

        $profiles = $profiles->where(function($q) use($group){
            foreach($group as $g){
                $q->orwhere('services.code',$g);
            }
        });

        $profiles = $profiles->count();
        return $profiles;

    }

    public static function checkGroup($service_id)
    {
        $group1 = array('PE');
        $group2 = array('BT', 'CBC', 'URI', 'BST', 'SE', 'FBS', 'SPE', 'RBS','DT');
        $group3 = array('HEPS', 'WM', 'HM', 'WUN', 'CNL', 'CMD', 'EE', 'ERE', 'OS', 'BP', 'SC','CNS','RR');

        $code = Service::find($service_id)->code;
        foreach($group1 as $g){
            if($code===$g){
                return 1;
            }
        }
        foreach($group2 as $g){
            if($code===$g){
                return 2;
            }
        }
        foreach($group3 as $g){
            if($code===$g){
                return 3;
            }
        }
        return 0;
    }

    public static function saveServiceGroup($profile_id,$sex,$group,$barangay_id,$muncity_id,$bracket_id,$dateP=null,$database=null)
    {
        $dateNow = isset($dateP) ? $dateP : date('Y-m-d');
        $db = isset($database) ? $database : 'db_'.date('Y');
        $servicegroup = new ServiceGroup();
        $servicegroup->setConnection($db);
        $year = date('Y',$dateNow);
        $check = $servicegroup->where('profile_id',$profile_id)->first();
        if($check){
            $servicegroup->where('profile_id',$profile_id)
                ->update(array(
                    'group'.$group => 1,
                    'dateProfile' => $dateNow,
                    'sex' => $sex,
                    'year' => $year,
                    'barangay_id' => $barangay_id,
                    'muncity_id' => $muncity_id,
                    'bracket_id' => $bracket_id
                ));
        }else{
            $servicegroup->profile_id = $profile_id;
            if($group==1){
                $servicegroup->group1 = 1;
            }else if($group==2){
                $servicegroup->group2 = 1;
            }else if($group==3){
                $servicegroup->group3 = 1;
            }
            $servicegroup->sex = $sex;
            $servicegroup->dateProfile = $dateNow;
            $servicegroup->year= $year;
            $servicegroup->barangay_id = $barangay_id;
            $servicegroup->muncity_id = $muncity_id;
            $servicegroup->bracket_id = $bracket_id;
            $servicegroup->save();
        }
    }

    public function password()
    {
        return view('password');
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

    static function countServicesAvailed($id,$year=null)
    {
        $year = isset($year) ? $year : date('Y');
        $db = 'db_'.$year;
        $profileservices = new ProfileServices();
        $profileservices->setConnection($db);
        $count = $profileservices->select(DB::raw("count(*) as count"))
                ->where('profile_id',$id)
                ->first()
                ->count;
        return $count;
    }

    public function sendFeedback(Request $req)
    {
        $user_id = Auth::user()->id;
        $message = $req->message;
        $q = new Feedback();
        $q->user_id = $user_id;
        $q->message = $message;
        $q->status = 0;
        $q->save();
        return redirect()->back()->with('status','feedbackSent');
    }

    static function string_limit_words($string, $word_limit) {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $word_limit));
    }

    static function countOnlineUsers()
    {
        if(Auth::user()->user_priv==3){
            $count = Sess::where('sessions.user_id','!=',null)
                ->leftJoin('users','sessions.user_id','=','users.id')
                ->where('users.province',Auth::user()->province)
                ->distinct('sessions.user_id')
                ->count('sessions.user_id');
        }else{
            $count = Sess::where('user_id','!=',null)
                ->distinct('user_id')
                ->count('user_id');
        }
        return $count;
    }

    static function getYear()
    {
        return array(
            '2018',
            '2017'
        );
    }

    static function getMonth()
    {
        return array(
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        );
    }

    static function getMonthName($i)
    {
        switch ($i) {
            case 1:
                return 'January';
                break;
            case 2:
                return 'February';
                break;
            case 3:
                return 'March';
                break;
            case 4:
                return 'April';
                break;
            case 5:
                return 'May';
                break;
            case 6:
                return 'June';
                break;
            case 7:
                return 'July';
                break;
            case 8:
                return 'August';
                break;
            case 9:
                return 'September';
                break;
            case 10:
                return 'October';
                break;
            case 11:
                return 'November';
                break;
            case 12:
                return 'December';
                break;
            default:
                return 'None';
        }
    }

}
