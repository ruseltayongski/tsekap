<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Profile;

class DengController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function form(Request $request){
        return view('dengvaxiav2.form.form',[
            'profile' => Session::get('profile')
        ]);
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
        $profile = Profile::select('id as profile_id','unique_id','familyID','head','relation','fname','mname','lname','suffix','dob','sex','barangay_id','muncity_id','province_id','relation','phicID','nhtsID','income','unmet','water','toilet','education','hypertension','diabetic','pwd','pregnant')
            ->where('id',$request->profile_id)
            ->first();
        Session::put('profile',$profile);
    }

    public function save(Request $request){
        return $request->all();
    }
}