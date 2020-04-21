<?php

namespace App\Http\Controllers;
use App\Abdomen;
use App\Adolescent;
use App\BronchialAsthma;
use App\ChestAndLungs;
use App\Dewormed;
use App\DisabilityOne;
use App\GeneralInformation;
use App\Heart;
use App\HospitalizationHistoryOne;
use App\Injury;
use App\MenstrualHistory;
use App\Muncity;
use App\PersonalHistory;
use App\PertinentExamination;
use App\PhicMembership;
use App\Province;
use App\Tuberculosis;
use App\VaccinationReceived;
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
                "status"=> 1,
            ]
        );

        PhicMembership::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "phic_status" => $request->phic_status,
                "phic_type" => $request->phic_type,
                "phic_sponsored"=> $request->phic_sponsored,
                "phic_sponsored_others"=> $request->phic_sponsored_others,
                "phic_employed"=> $request->phic_employed,
                "phic_benefits"=> $request->phic_benefits,
                "phic_benefits_yes"=> $request->phic_benefits_yes,
                "phic_status1" => 1
            ]
        );

        BronchialAsthma::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "bro_consultation" => $request->phic_type,
                "bro_no_attack_week"=> $request->phic_sponsored,
                "bro_medication"=> $request->phic_sponsored_others,
                "bro_medication_yes"=> $request->phic_employed,
                "bro_status" => 1
            ]
        );

        Tuberculosis::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "tb_diagnosed" => $request->tb_diagnosed,
                "tb_diagnosed_yes"=> $request->tb_diagnosed_yes,
                "tb_cat1"=> $request->tb_cat1,
                "tb_cat2"=> $request->tb_cat2,
                "tb_cat3"=> $request->tb_cat3,
                "tb_cat4"=> $request->tb_cat4,
                "tb_status" => 1
            ]
        );

        DisabilityOne::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "dis_give_description" => $request->dis_give_description,
                "dis_with_assistive"=> $request->dis_with_assistive,
                "dis_with_assistive_yes"=> $request->dis_with_assistive_yes,
                "dis_need_assistive"=> $request->dis_need_assistive,
                "dis_need_assistive_yes"=> $request->dis_need_assistive_yes,
                "dis_one_status" => 1
            ]
        );

        Injury::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "inj_vehicular" => $request->inj_vehicular,
                "inj_burns"=> $request->inj_burns,
                "inj_drowning"=> $request->inj_drowning,
                "inj_fall"=> $request->inj_fall,
                "inj_medications"=> $request->inj_medications,
                "inj_status" => 1
            ]
        );

        HospitalizationHistoryOne::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "hos_hospitalized" => $request->hos_hospitalized,
                "hos_one_status" => 1
            ]
        );

        PersonalHistory::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "per_smoking" => $request->per_smoking,
                "per_age_started"=> $request->per_age_started,
                "per_age_quit"=> $request->per_age_quit,
                "per_stick_day"=> $request->per_stick_day,
                "per_pack_years"=> $request->per_pack_years,
                "per_high_fat"=> $request->per_high_fat,
                "per_fiber_vegetable"=> $request->per_fiber_vegetable,
                "per_fiber_fruits"=> $request->per_fiber_fruits,
                "per_physical_activity"=> $request->per_physical_activity,
                "per_alcohol"=> $request->per_alcohol,
                "per_drugs"=> $request->per_drugs,
                "per_drugs_yes"=> $request->per_drugs_yes,
                "per_status" => 1
            ]
        );

        MenstrualHistory::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "menst_age" => $request->menst_age,
                "menst_date_period"=> $request->menst_date_period,
                "menst_duration_days"=> $request->menst_duration_days,
                "menst_interval_days"=> $request->menst_interval_days,
                "menst_pads"=> $request->menst_pads,
                "menst_status"=> 1,
            ]
        );

        VaccinationReceived::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "vacc_rec_mr" => $request->vacc_rec_mr,
                "vacc_rec_diphtheria"=> $request->vacc_rec_diphtheria,
                "vacc_rec_mmr"=> $request->vacc_rec_mmr,
                "vacc_rec_hpv"=> $request->vacc_rec_hpv,
                "vacc_rec_tetanus"=> $request->vacc_rec_tetanus,
                "vacc_rec_doses"=> $request->vacc_rec_doses,
                "vacc_rec_status" => 1
            ]
        );

        Adolescent::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "adol_supplementation" => $request->adol_supplementation,
                "adol_capsule"=> $request->adol_capsule,
                "adol_status" => 1
            ]
        );

        Dewormed::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "dewormed" => $request->dewormed,
                "dewormed_date"=> $request->dewormed_yes,
                "dewormed_status" => 1
            ]
        );

        PertinentExamination::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "per_orriented_time" => $request->per_orriented_time,
                "per_conscious"=> $request->per_conscious,
                "per_ambulatory"=> $request->per_ambulatory,
                "per_others"=> $request->per_others,
                "per_others_specify"=> $request->per_others_specify,
                "per_bp"=> $request->per_bp,
                "per_hr"=> $request->per_hr,
                "per_rr"=> $request->per_rr,
                "per_temp"=> $request->per_temp,
                "per_blood_type"=> $request->per_blood_type,
                "per_weight"=> $request->per_weight,
                "per_waist"=> $request->per_waist,
                "per_hip"=> $request->per_hip,
                "per_ratio"=> $request->per_ratio,
                "per_skin_good"=> $request->per_skin_good,
                "per_skin_pailor"=> $request->per_skin_pailor,
                "per_skin_jaundice"=> $request->per_skin_jaundice,
                "per_skin_rashes"=> $request->per_skin_rashes,
                "per_skin_lession"=> $request->per_skin_lession,
                "per_skin_lession_specify"=> $request->per_skin_lession_specify,
                "per_skin_others"=> $request->per_skin_others,
                "per_status" => 1
            ]
        );

        ChestAndLungs::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "chest_no_findings" => $request->chest_no_findings,
                "chest_retractions"=> $request->chest_retractions,
                "chest_crackles"=> $request->chest_crackles,
                "chest_wheezes"=> $request->chest_wheezes,
                "chest_breast"=> $request->chest_breast,
                "chest_others"=> $request->chest_others,
                "chest_others_specify"=> $request->chest_others_specify,
                "chest_status" => 1
            ]
        );

        Heart::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "heart_no_findings" => $request->heart_no_findings,
                "heart_pulse"=> $request->heart_pulse,
                "heart_cyanosis"=> $request->heart_cyanosis,
                "heart_murmur"=> $request->heart_murmur,
                "heart_murmur_specify"=> $request->heart_murmur_specify,
                "heart_others"=> $request->heart_others,
                "heart_others_specify"=> $request->heart_others_specify,
                "heart_status" => 1
            ]
        );

        Abdomen::updateOrCreate(
            ['profile_id'=>$request->profile_id],
            [
                "profile_id" => $request->profile_id,
                "abd_no_findings" => $request->abd_no_findings,
                "abd_tenderness"=> $request->abd_tenderness,
                "abd_palpable"=> $request->abd_palpable,
                "abd_palpable_specify"=> $request->abd_palpable_specify,
                "abd_others"=> $request->abd_others,
                "abd_others_specify"=> $request->abd_others_specify,
                "abd_status" => 1
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