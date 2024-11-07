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
        // Define the fields to check for duplication
        $duplicateCheck = [
          'fname' => $req->fname,
          'lname' => $req->lname,
          'mname' => $req->mname,
          'dob' => $req->dateofbirth
        ];

        // Check for duplicate in the RiskProfile table
        $existingRiskProfile = RiskProfile::where($duplicateCheck)->first();

        if ($existingRiskProfile) {
          // Redirect with an error message if a duplicate is found
          return redirect()->back()->with('error', 'Duplicate risk profile exists with the same data.');
        }

        $user = Auth::user();

        $riskprofile = new RiskProfile();

        // Assign all the necessary values
        $riskprofile->profile_id = $req->profile_id? $req->profile_id : null;
        $riskprofile->fname = $req->fname;
        $riskprofile->mname = $req->mname? $req->mname : null ;
        $riskprofile->lname = $req->lname;
        $riskprofile->suffix = $req->suffix? $req->suffix : null;
        $riskprofile->sex = $req->sex;
        $riskprofile->dob = $req->dateofbirth;
        $riskprofile->age = $req->age;
        $riskprofile->province_id = $req->province;
        $riskprofile->municipal_id = $req->municipal;
        $riskprofile->barangay_id = $req->barangay;
        $riskprofile->sitio = $req->sitio? $req->sitio : null;
        $riskprofile->street = $req->street? $req->street : null;
        $riskprofile->purok = $req->purok? $req->purok : null;
        $riskprofile->phic_id = $req->phic_id? $req->phic_id : null; // Ensure you use the correct field name here
        $riskprofile->civil_status = $req->civil_status;
        $riskprofile->religion = $req->religion;
        $riskprofile->pwd_id = $req->pwd_id? $req->pwd_id : null;
        $riskprofile->ethnicity = $req->ethnicity;
        $riskprofile->indigenous_person = $req->indigenous_person;
        $riskprofile->employment_status = $req->employment_status;
        $riskprofile->facility_id_updated = $req->facility_id_updated; // Ensure this is not null
    
        // Save the profile
        $riskprofile->save();
    
        // Redirect after saving
        return redirect()->route('riskassessment')->with('success', 'Patient Successfully Added');  
    }
    
}
