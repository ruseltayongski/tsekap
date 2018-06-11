<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\Muncity;
use App\Profile;
use Illuminate\Http\Request;
use App\dengvaxia\Profile as DengProfile;
use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class DengvaxiaCtrl extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $req)
    {
        $profiles = DengProfile::select(
                'profiles.*',
                'barangay.description as barangay',
                'muncity.description as muncity',
                'province.description as province'
        );
        $session = array(
            'name' => '',
            'linked' => '',
            'province_id' => '',
            'muncity_id' => ''
        );
        if ($req->isMethod('post')) {
            $search = array(
                'name' => $req->name,
                'linked' => $req->linked,
                'province_id' => $req->province_id,
                'muncity_id' => $req->muncity_id
            );
            Session::put('dengvaxia_search',$search);
        }
        if(Session::get('dengvaxia_search'))
        {
            $session = Session::get('dengvaxia_search');
            $name = $session['name'];
            $province_id = $session['province_id'];
            $muncity_id = $session['muncity_id'];
            $linked = $session['linked'];

            $profiles = $profiles->where(function($q) use($name){
                $q->where('profiles.fname','like',"%$name%")
                    ->orwhere('profiles.mname','like',"%$name%")
                    ->orwhere('profiles.lname','like',"%$name%");
            });
            if($province_id!='all')
            {
                $profiles = $profiles->where('profiles.province',$province_id);
            }

            if($muncity_id!='all')
            {
                $profiles = $profiles->where('profiles.muncity',$muncity_id);
            }

            if($linked=='yes')
            {
                $profiles = $profiles->where('tsekap_id','>',0);
            }else if($linked=='no'){
                $profiles = $profiles->where('tsekap_id',0);
            }
        }

        $profiles = $profiles->join('barangay','barangay.id','=','profiles.barangay')
                        ->join('muncity','muncity.id','=','profiles.muncity')
                        ->join('province','province.id','=','profiles.province');
        $profiles = $profiles->orderBy('profiles.lname','asc');
        $total = $profiles->count();
        $profiles = $profiles->paginate(20);

        return view('dengvaxia.profile',[
            'title' => 'Dengvaxia Profiles',
            'sidebar' => 'dengvaxia/profile',
            'profiles' => $profiles,
            'total' => $total,
            'post' => (object)$session
        ]);
    }

    public function link(Request $req)
    {
        $title ='';
        $session = array(
            'province_id' => '',
            'muncity_id' => ''
        );
        if ($req->isMethod('post')) {
            $search = array(
                'province_id' => $req->province_id,
                'muncity_id' => $req->muncity_id
            );
            Session::put('link_search',$search);
        }
        $barangay = array();

        if(Session::get('link_search'))
        {
            $session = Session::get('link_search');
            $province_id = $session['province_id'];
            $muncity_id = $session['muncity_id'];

            if($muncity_id > 0)
            {
                $barangay = Barangay::where('muncity_id',$muncity_id)
                            ->orderBy('description','asc')
                            ->get();
                $title = ': '.Muncity::find($muncity_id)->description;
            }
        }

        return view('dengvaxia.link',[
            'title' => 'Link Dengvaxia Profile '.$title,
            'sidebar' => 'dengvaxia/link',
            'post' => (object)$session,
            'barangay' => $barangay
        ]);
    }

    public function countProfile($id)
    {
        return DengProfile::where('barangay',$id)->count();
    }

    public function linkProfile($id,$offset)
    {
        $profiles = DengProfile::where('barangay',$id)
            ->offset($offset)
            ->limit(10)
            ->get();
        foreach($profiles as $row)
        {
            $profile = Profile::where('barangay_id',$id)
                ->where('fname',$row->fname)
                ->where('lname',$row->lname)
                ->where('dob',$row->dob);

            if(strlen($row->mname))
            {
                $mname = $row->mname;
                $mname = $mname[0];
                $profile = $profile->where('mname','like',"$mname%");
            }

            $profile = $profile->first();
            if($profile){
                DengProfile::where('id',$row->id)
                    ->update([
                        'tsekap_id' => $profile->id
                    ]);
            }
        }
    }

    public function finish($id)
    {
        $brgy = Barangay::find($id);
        $brgy->update([
            'dengvaxia_link' => 1
        ]);
    }
}
