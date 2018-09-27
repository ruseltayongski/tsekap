<?php

namespace App\Http\Controllers;

use App\Dengvaxia;
use App\Profile;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf;

class DengvaxiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function verify_dengvaxia($id){
        $tsekap = Profile::find($id);
        $dengvaxia = \DB::connection('dengvaxia')->select("SELECT id,dob,fname,lname,mname,barangay_id,
                    muncity_id,province_id,sex,gen_age from `dengvaxia_profiles` WHERE fname = '$tsekap->fname' and lname = '$tsekap->lname' 
                    and DATE_FORMAT(dob,'%Y-%m-%d') = '$tsekap->dob' and province_id = '$tsekap->province_id' and muncity_id = '$tsekap->muncity_id' ");

        return view('dengvaxia.verify_dengvaxia',[
            "dengvaxia" => $dengvaxia
        ]);
    }

    public function form_dengvaxia($dengvaxiaID){
        $dengvaxia = Dengvaxia::find($dengvaxiaID);

        return view('dengvaxia.form_dengvaxia',[
            "dengvaxia" => $dengvaxia
        ]);
    }

    public function post_dengvaxia(Request $request,$dengvaxiaID){
        $data = $request->except(['_token','gen_reli_oth','phi_typ_oth','phi_ben_spe','ale_spe','can_spe','imm_spe','epi_spe','hea_spe','kid_spe']);
        $data['gen_reli'] = json_encode([
            [
                'rel' => $request->gen_reli,
                'oth' => $request->gen_reli_oth
            ]
        ]);

        Dengvaxia::where('id','=',$dengvaxiaID)->first()->update($data);
        return redirect()->back();
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