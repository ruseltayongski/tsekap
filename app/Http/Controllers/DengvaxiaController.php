<?php

namespace App\Http\Controllers;

use App\Dengvaxia;
use App\Profile;
use App\Province;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf;
use Illuminate\Support\Facades\Session;

class DengvaxiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function verify_dengvaxia($id){
        $tsekap = Profile::find($id);
        $dengvaxia = \DB::connection('dengvaxia_dummy')->select("SELECT id,dob,fname,lname,mname,barangay_id,
                    muncity_id,province_id,sex,gen_age from `dengvaxia_profiles` WHERE fname = '$tsekap->fname' and lname = '$tsekap->lname' 
                    and DATE_FORMAT(dob,'%Y-%m-%d') = '$tsekap->dob' and province_id = '$tsekap->province_id' and muncity_id = '$tsekap->muncity_id' ");

        return view('dengvaxia.verify_dengvaxia',[
            "unique_id" => $tsekap->unique_id,
            "dengvaxia" => $dengvaxia
        ]);
    }

    public function form_dengvaxia($dengvaxiaID,$unique_id){
        $dengvaxia = Dengvaxia::find($dengvaxiaID);

        return view('dengvaxia.form_dengvaxia',[
            "dengvaxia" => $dengvaxia,
            "unique_id" => $unique_id
        ]);
    }

    public function post_dengvaxia(Request $request,$dengvaxiaID,$unique_id){

        strpos($request->gen_reli, 'Others') !== false ? $religion = $request->gen_reli.' - '.$request->gen_reli_oth : $religion = $request->gen_reli;

        if(strpos($request->phic_sponsoredby, 'Sponsored') !== false){
            if($request->phic_sponsored == "Others"){
                $phic_type = $request->phic_sponsoredby.' '.$request->phic_sponsored.' - '.$request->phic_sponsored_others;
            } else {
                $phic_type = $request->phic_sponsoredby.' '.$request->phic_sponsored;
            }
        }

        if($request->phic_ben == "Yes"){
            $phic_ben = $request->phic_ben.' - '.$request->phic_ben_spe;
        }
        else if($request->phic_ben == "No") {
            $phic_ben = $request->phic_ben;
        }

        $phic_membership = json_encode([
            "status" => $request->phic_status,
            "type" => $phic_type,
            "employment" => $request->phic_employed,
            "benefit" => $phic_ben
        ]);

        foreach($request->fam_his as $row){
            if(isset($request->$row)){
                $fam_concat = $request->$row;
            } else {
                $fam_concat = '';
            }
            $fam_his[$row] = $row.' - '.$fam_concat;
        }
        $family_history = json_encode($fam_his);

        foreach($request->med_his as $row){
            if(isset($request->$row)){
                $med_concat = $request->$row;
            } else {
                $med_concat = '';
            }
            $med_his[$row] = $row.' - '.$med_concat;
        }
        $medical_history = json_encode($med_his);

        $request->with_medication == "Yes" ? $with_medication = $request->with_medication.' - '.$request->with_medication_spe : $with_medication = $request->with_medication;
        $bronchial_asthma = json_encode([
            "diagnosed" => $request->diagnosed,
            "no_attacks" => $request->no_attacks,
            "with_medication" => $with_medication,
        ]);

        foreach($request->Any_Following as $row){
            if(isset($request->$row)){
                $any_following_concat = $request->$row;
            } else {
                $any_following_concat = '';
            }
            $Any_Following[$row] = $row.' - '.$any_following_concat;
        }
        foreach($request->Labs_Done as $row){
            if(isset($request->$row)){
                $labs_done_concat = $request->$row;
            } else {
                $labs_done_concat = '';
            }
            $Labs_Done[$row] = $row.' - '.$labs_done_concat;
        }

        foreach($request->Medications as $row){
            $Medications[$row] = $row;
        }

        $tuberculosis = json_encode([
            "Any_Following" => $Any_Following,
            "Diagnosed" => $request->Diagnosed.' - '.$request->Diagnosed_Form,
            "Labs_Done" => $Labs_Done,
            "Medications" => $Medications,
        ]);

        foreach($request->disability_injury as $row){
            $selected_options[$row] = $row;
        }

        $disability_injury = json_encode([
            "selected_options" => $selected_options,
            "with_assistive" => $request->with_assistive_diagnosed.' - '.$request->with_assistive_spe,
            "need_assistive" => $request->need_assistive_diagnosed.' - '.$request->need_assistive_spe,
            "description" => $request->disability_description,
            "medication" => $request->injury_medication
        ]);

        Dengvaxia::updateOrCreate(
            ['id' => $dengvaxiaID], [
                "unique_id" => $unique_id,
                "lname" => $request->lname,
                "fname" => $request->fname,
                "mname" => $request->mname,
                "suffix" => $request->suffix,
                "head" => $request->head,
                "gen_res" => $request->gen_res,
                "gen_con" => $request->gen_con,
                "gen_hou_r" => $request->gen_hou_r,
                "barangay_id" => $request->barangay_id,
                "muncity_id" => $request->muncity_id,
                "province_id" => $request->province_id,
                "sex" => $request->sex,
                "gen_age" => $request->gen_age,
                "gen_reli" => $religion,
                "dob" => $request->dob,
                "birthplace" => $request->birthplace,
                "gen_rel_yrs" => $request->gen_rel_yrs,
                "education" => $request->education,
                "phic_membership" => $phic_membership,
                "family_history" => $family_history,
                "medical_history" => $medical_history,
                "bronchial_asthma" => $bronchial_asthma,
                "tuberculosis" => $tuberculosis,
                "disability_injury" => $disability_injury,
                "platform" => "web",
            ]
        );

        Profile::updateOrCreate(
            ['unique_id' => $unique_id], [
                "lname" => $request->lname,
                "fname" => $request->fname,
                "mname" => $request->mname,
                "suffix" => $request->suffix,
                "head" => $request->head,
                "dob" => $request->dob,
                "barangay_id" => $request->barangay_id,
                "muncity_id" => $request->muncity_id,
                "province_id" => $request->province_id,
                "education" => $request->education,
            ]
        );

        Session::flash('deng_updated',"Successfully Updated!");
        return redirect()->back();
    }

    public function sessionProcessPrint($unique_id){
        session_start();
        $_SESSION['unique_id'] = $unique_id;
    }

    public function fpdf(){
        \Fpdf::AddPage();
        \Fpdf::SetFont('Courier', 'B', 18);
        \Fpdf::SetXY(3,10);
        \Fpdf::Cell(0, 0, 'Hello World!');

        \Fpdf::SetXY(3,15);
        \Fpdf::Cell(0, 0, 'Hello World!');
        \Fpdf::Output();

        //return response(\Fpdf::Output(), 200)->header('Content-Type', 'application/pdf');
    }


}