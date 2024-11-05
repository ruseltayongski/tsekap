<?php
namespace App\Http\Controllers\risk;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Facility;
use App\Barangay;
use App\Muncity;
use App\Province;
use App\Profile;
use App\RiskProfile;

class RiskProfileController extends Controller     
{
    //
    
    public function getMunicipal($provinceid){

      $muncity = Muncity::where('province_id', $provinceid)
        ->select('id','province_id','description')
        ->whereNotIn('id',['63','76','80'])
        ->get(); 
        //63 is Cebu City Capital, 76 is Lapu-Lapu City, Mandaue City
      
      return response()->json($muncity);
    }

    public function getBarangay($muncity_id){
        $barangay = Barangay::where('muncity_id',$muncity_id)
            ->select('id','muncity_id','description')
            ->get();
        return response()->json($barangay);
    }
    
    public function SubmitRiskPForm(Request $req)
    {
        $user = Auth::user();

        $riskprofile = new RiskProfile();
        
        $unique_id = $req->fname . $req->mname . $req->lname . $req->suffix . $req->barangay . $user->muncity; // Ensure $user->muncity is accessible
        $riskprofile->unique_id = $unique_id;

        // Assign all the necessary values
        $riskprofile->fname = $req->fname;
        $riskprofile->mname = $req->mname;
        $riskprofile->lname = $req->lname;
        $riskprofile->suffix = $req->suffix;
        $riskprofile->sex = $req->sex;
        $riskprofile->dob = $req->dateofbirth;
        $riskprofile->age = $req->age;
        $riskprofile->province_id = $req->province;
        $riskprofile->municipal_id = $req->municipal;
        $riskprofile->barangay_id = $req->barangay;
        $riskprofile->sitio = $req->sitio;
        $riskprofile->street = $req->street;
        $riskprofile->purok = $req->purok;
        $riskprofile->phic_id = $req->phic_id; // Ensure you use the correct field name here
        $riskprofile->civil_status = $req->civil_status;
        $riskprofile->religion = $req->religion;
        $riskprofile->pwd_id = $req->pwd_id;
        $riskprofile->ethnicity = $req->ethnicity;
        $riskprofile->indigenous_person = $req->indigenous_person;
        $riskprofile->employment_status = $req->employment_status;
        $riskprofile->facility_id_updated = $req->facility_id; // Ensure this is not null
    
        // Save the profile
        $riskprofile->save();
    
        // Redirect after saving
        return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');
    }
    
}
