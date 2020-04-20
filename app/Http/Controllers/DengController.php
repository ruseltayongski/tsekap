<?php

namespace App\Http\Controllers;
use App\GeneralInformation;
use App\Muncity;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Profile;
use App\Barangay;
use Illuminate\Support\Facades\Auth;
use App\UserBrgy;

class DengController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function form(Request $request){
        $profile = $this->profileInfo(Session::get('profile_id'));

        $brgy = Barangay::where('muncity_id',Auth::user()->muncity);
        $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
        //get barangay
        $brgy = $brgy->where(function($q) use ($tmpBrgy){
            foreach($tmpBrgy as $tmp){
                $q->orwhere('id',$tmp->barangay_id);
            }
        });
        if(count($tmpBrgy)==0){
            $brgy = $brgy->where('id',0);
        }
        $brgy = $brgy->orderBy('description','asc')
            ->get();
        //end barangay

        //get muncity
        $muncity = Muncity::where(function($q) use ($brgy){
            foreach($brgy as $tmp){
                $q->orWhere('id',$tmp->muncity_id);
            }
        })
        ->groupBy('id')
        ->orderBy('description','asc')
        ->get();
        //end muncity

        //get province
        $province = Province::where(function($q) use ($brgy){
            foreach($brgy as $tmp){
                $q->orWhere('id',$tmp->province_id);
            }
        })
            ->groupBy('id')
            ->orderBy('description','asc')
            ->get();
        //end province

        return view('dengvaxiav2.form.form',[
            'profile' => $profile,
            'brgy' => $brgy,
            'muncity' => $muncity,
            'province' => $province
        ]);
    }

    public function profileInfo($profile_id){
        $profile = Profile::select(
                'profile.id as main_id',
                'profile.*',
                'general_information.*',
                'phic_membership.*',
                'bronchial_asthma.*',
                'tuberculosis.*',
                'disability_one.*',
                'injury.*',
                'hospitalization_history_one.*',
                'personal_history.*',
                'menstrual_history.*',
                'vaccination_received.*',
                'adolescent.*',
                'dewormed.*',
                'pertinent_examination.*',
                'chest_and_lungs.*',
                'heart.*',
                'abdomen.*'
            )
            ->leftJoin('general_information','general_information.profile_id','=','profile.id')
            ->leftJoin('phic_membership','phic_membership.profile_id','=','profile.id')
            ->leftJoin('bronchial_asthma','bronchial_asthma.profile_id','=','profile.id')
            ->leftJoin('tuberculosis','tuberculosis.profile_id','=','profile.id')
            ->leftJoin('disability_one','disability_one.profile_id','=','profile.id')
            ->leftJoin('injury','injury.profile_id','=','profile.id')
            ->leftJoin('hospitalization_history_one','hospitalization_history_one.profile_id','=','profile.id')
            ->leftJoin('personal_history','personal_history.profile_id','=','profile.id')
            ->leftJoin('menstrual_history','menstrual_history.profile_id','=','profile.id')
            ->leftJoin('vaccination_received','vaccination_received.profile_id','=','profile.id')
            ->leftJoin('adolescent','vaccination_received.profile_id','=','profile.id')
            ->leftJoin('dewormed','dewormed.profile_id','=','profile.id')
            ->leftJoin('pertinent_examination','pertinent_examination.profile_id','=','profile.id')
            ->leftJoin('chest_and_lungs','chest_and_lungs.profile_id','=','profile.id')
            ->leftJoin('heart','heart.profile_id','=','profile.id')
            ->leftJoin('abdomen','abdomen.profile_id','=','profile.id')
            ->where('profile.id',$profile_id)
            ->first();

        return $profile;
    }

    public function save(Request $request){
        Profile::find($request->profile_id)->update(
            [
                "lname" => $request->lname,
                "fname" => $request->fname,
                "mname"=> $request->mname,
                "suffix"=> $request->suffix,
                "relation"=> $request->relation,
                "barangay_id"=> $request->barangay_id,
                "muncity_id"=> $request->muncity_id,
                "province_id"=> $request->province_id,
                "sex"=> $request->sex,
                "dob"=> $request->dob,
                "education"=> $request->education
            ]
        );

        GeneralInformation::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "dengvaxia_recipient_no" => $request->dengvaxia_recipient_no,
                "respondent"=> $request->respondent,
                "contact_no"=> $request->contact_no,
                "street_name"=> $request->street_name,
                "sitio"=> $request->sitio,
                "religion"=> $request->religion_others,
                "birth_place"=> $request->birth_place,
                "yrs_current_address"=> $request->yrs_current_address,
            ]
        );


        return redirect()->back()->with('status','updated');
    }

    public function pdf(){
        $size = 'a4';
        $orientation = 'landscape';
        $display = view('dengvaxiav2.pdf.pdf');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($display);
        return $pdf->setPaper($size, $orientation)->stream();
    }

    public function sessionProfileId(Request $request){
        Session::put('profile_id',$request->profile_id);
    }

}