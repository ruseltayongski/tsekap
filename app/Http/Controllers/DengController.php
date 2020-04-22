<?php

namespace App\Http\Controllers;
use App\Abdomen;
use App\Adolescent;
use App\BronchialAsthma;
use App\ChestAndLungs;
use App\Dewormed;
use App\Disability;
use App\DisabilityOne;
use App\FamilyHistory;
use App\GeneralInformation;
use App\Heart;
use App\HospitalizationHistory;
use App\HospitalizationHistoryOne;
use App\Injury;
use App\MedicalHistory;
use App\MenstrualHistory;
use App\Muncity;
use App\PersonalHistory;
use App\PertinentExamination;
use App\PhicMembership;
use App\Province;
use App\Tuberculosis;
use App\TuberculosisTick;
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


        $family_history = [];
        foreach(FamilyHistory::where('profile_id','=',$profile->main_id)->get() as $row){
            $family_history['fh_tick_'.$row->fh_tick] = $row->fh_tick;
            $family_history['fh_specify_'.$row->fh_tick] = $row->fh_specify;
        }

        $medical_history = [];
        foreach(MedicalHistory::where('profile_id','=',$profile->main_id)->get() as $row){
            $medical_history['mh_tick_'.$row->mh_tick] = $row->mh_tick;
            $medical_history['mh_specify_'.$row->mh_tick] = $row->mh_specify;
        }

        $tuberculosis_tick = [];
        foreach(TuberculosisTick::where('profile_id','=',$profile->main_id)->get() as $row){
            $tuberculosis_tick['tb_tick_'.$row->tb_tick] = $row->tb_tick;
            $tuberculosis_tick['tb_tick_specify_'.$row->tb_tick] = $row->tb_tick_specify;
        }

        $disability = [];
        foreach(Disability::where('profile_id','=',$profile->main_id)->get() as $row){
            $disability['dis_tick_'.$row->dis_tick] = $row->dis_tick;
        }
        $hospitalization_history = HospitalizationHistory::where('profile_id','=',$profile->main_id)->get();
        Session::put('host_count',1);

        return view('dengvaxiav2.form.form',[
            'profile' => $profile,
            'brgy' => $brgy,
            'muncity' => $muncity,
            'province' => $province,
            'family_history' => $family_history,
            'medical_history' => $medical_history,
            'tuberculosis_tick' => $tuberculosis_tick,
            'disability' => $disability,
            'hospitalization_history' => $hospitalization_history
        ]);
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
                "religion"=> $request->religion,
                "religion_others"=> $request->religion_others,
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
                "bro_consultation" => $request->bro_consultation,
                "bro_no_attack_week"=> $request->bro_no_attack_week,
                "bro_medication"=> $request->bro_medication,
                "bro_medication_yes"=> $request->bro_medication_yes,
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
                "tb_ppd"=> $request->tb_ppd,
                "tb_result_ppd"=> $request->tb_result_ppd,
                "tb_sputum_exam"=> $request->tb_sputum_exam,
                "tb_result_eputum_exam"=> $request->tb_result_eputum_exam,
                "tb_cxr"=> $request->tb_cxr,
                "tb_result_cxr"=> $request->tb_result_cxr,
                "tb_genxpert"=> $request->tb_genxpert,
                "tb_result_genxpert"=> $request->tb_result_genxpert,
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

        $family_history = FamilyHistory::where('profile_id','=',$request->profile_id);
        if(count($family_history) >= 1){
            $family_history->delete();
        }
        foreach($request->fh_tick as $value){
            $family_history = new FamilyHistory();
            $family_history->profile_id = $request->profile_id;
            $family_history->fh_tick = $value;
            $fh_specify = 'fh_specify_'.$value;
            $family_history->fh_specify = $request->$fh_specify;
            $family_history->fh_status = 1;
            $family_history->save();
        }

        $medical_history = MedicalHistory::where('profile_id','=',$request->profile_id);
        if(count($medical_history) >= 1){
            $medical_history->delete();
        }
        foreach($request->mh_tick as $value){
            $medical_history = new MedicalHistory();
            $medical_history->profile_id = $request->profile_id;
            $medical_history->mh_tick = $value;
            $mh_specify = 'mh_specify_'.$value;
            $medical_history->mh_specify = $request->$mh_specify;
            $medical_history->mh_status = 1;
            $medical_history->save();
        }

        $tuberculosis_tick = TuberculosisTick::where('profile_id','=',$request->profile_id);
        if(count($tuberculosis_tick) >= 1){
            $tuberculosis_tick->delete();
        }
        foreach($request->tb_tick as $value){
            $tuberculosis_tick = new TuberculosisTick();
            $tuberculosis_tick->profile_id = $request->profile_id;
            $tuberculosis_tick->tb_tick = $value;
            $tb_tick_specify = 'tb_tick_specify_'.$value;
            $tuberculosis_tick->tb_tick_specify = $request->$tb_tick_specify;
            $tuberculosis_tick->tb_tick_status = 1;
            $tuberculosis_tick->save();
        }

        $disability = Disability::where('profile_id','=',$request->profile_id);
        if(count($disability) >= 1){
            $disability->delete();
        }
        foreach($request->dis_tick as $value){
            $disability = new Disability();
            $disability->profile_id = $request->profile_id;
            $disability->dis_tick = $value;
            $disability->dis_status = 1;
            $disability->save();
        }

        $hospitalization_history = HospitalizationHistory::where('profile_id','=',$request->profile_id);
        if(count($hospitalization_history) >= 1){
            $hospitalization_history->delete();
        }
        $hos_count = 0;
        foreach($request->hos_reason as $hos_reason){
            $hospitalization_history = new HospitalizationHistory();
            $hospitalization_history->profile_id = $request->profile_id;
            $hospitalization_history->hos_reason = $hos_reason;
            $hospitalization_history->hos_date = $request->hos_date[$hos_count];
            $hospitalization_history->hos_place = $request->hos_place[$hos_count];
            $hospitalization_history->hos_phic = $request->hos_phic[$hos_count];
            $hospitalization_history->hos_cost = $request->hos_cost[$hos_count];
            $hospitalization_history->save();
            $hos_count++;
        }


        return redirect()->back()->with('status','updated');
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