<?php

namespace App\Http\Controllers\risk;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Profile;
use App\RiskProfile;

class RiskClientExtractionController extends Controller
{
    // Get specific profile
    public function riskGetSpecificClient(Request $req) {
        $id = $req->input('id');

        // Retrieve the profile with the specified ID, selecting only fname, mname, and lname fields
        $profile = Profile::select('unique_id','fname','mname','lname','suffix','dob','sex','barangay_id','muncity_id','province_id',
                                    'civil_status','religion','contact','height','weight','phicID',)
                    ->where('id', $id)
                    ->first();

        // Check if profile exists
        if ($profile) {
            // Remove trailing whitespace from lname
            $profile->fname = ucwords(strtolower(trim($profile->fname)));
            $profile->mname = ucwords(strtolower(trim($profile->mname)));
            $profile->lname = ucwords(strtolower(trim($profile->lname)));

            return response()->json($profile);
        } else {
            return response()->json(['error' => 'Profile not found'], 404);
        }
    }
}
