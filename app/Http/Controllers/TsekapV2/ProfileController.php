<?php

namespace App\Http\Controllers\TsekapV2;

use Illuminate\Http\Request;

use App\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    private function generateUniqueId($fname, $mname, $lname, $barangay_id, $muncity_id)
    {
        return $fname . $mname . $lname . $barangay_id . $muncity_id;
    }

    // get profiles
    public function retrieveProfile(Request $request){
        $user = $request->input('user');
        $fields = $request->input('fields');
        
        if(!$user){
            return response()->json(['error' => 'No user is logged in.'], 401);
        }

        $firstName = $fields->firstname;
        $middleName = $fields->middlename;
        $lastName = $fields->lastname;
        $dob = $request->dob;
   
        $profile = Profile::select('unique_id','fname','mname','lname','dob','id');

        // check individually
        if($firstName){
            $profile = $profile->where('fname','like',"%$firstName%");
        }
        if($middleName){
            $profile = $profile->where('mname','like',"%$middleName%");
        }
        if($lastName){
            $profile = $profile->where('lname','like',"%$lastName%");
        }
        if($dob){
            $profile = $profile->where('dob',"%$dob%");
        }
        
        $profiles = $profile->orderBy('lname', 'asc')
        ->limit(25)
        ->get();

        return response()->json($profiles);
    }

    // add profile
    public function addProfile(Request $request){
        // Validation rules
        $rules = [
            'unique_id' => 'required|unique:profiles',
            'familyID' => 'required',
            'phicID' => 'required',
            'nhtsID' => 'required',
            'head' => 'required',
            'relation' => 'required',
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'suffix' => 'required',
            'dob' => 'required|date',
            'sex' => 'required',
            'barangay_id' => 'required|integer',
            'muncity_id' => 'required|integer',
            'province_id' => 'required|integer',
            'income' => 'required|integer',
            'unmet' => 'required|integer',
            'water' => 'required|integer',
            'toilet' => 'required|string|max:10',
            'education' => 'required|string|max:20',
            'hypertension' => 'required',
            'diabetic' => 'required',
            'pwd' => 'required',
            'pregnant' => 'required|date',
            'dengvaxia' => 'required|string|max:45',
            'sexually_active' => 'required|string|max:10',
            'nhts' => 'required',
            'four_ps' => 'required',
            'ip' => 'required',
            'member_others' => 'required',
            'balik_probinsya' => 'required',
            'updated_by' => 'required|string|max:10',
            'household_num' => 'required|string|max:30',
            'philhealth_categ' => 'required|string|max:15',
            'fourps_num' => 'required|string|max:30',
            'health_group' => 'required|string|max:20',
            'fam_plan' => 'required|string|max:10',
            'fam_plan_method' => 'required|string|max:20',
            'fam_plan_other_method' => 'required',
            'fam_plan_status' => 'required|string|max:25',
            'fam_plan_other_status' => 'required',
            'other_med_history' => 'required',
        ];

        // Validate input
        $validator = Validator::make($request->all(), $rules);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Generate unique ID
        $unique_id = $this->generateUniqueId(
            $request->input('fname'),
            $request->input('mname'),
            $request->input('lname'),
            $request->input('barangay_id'),
            $request->input('muncity_id')
        );

        // Check if unique ID already exists
        if (Profile::where('unique_id', $unique_id)->exists()) {
            return response()->json(['message' => 'Profile with this unique ID already exists'], 400);
        }

        // Create new profile with unique ID
        $profile = Profile::create(array_merge($request->all(), ['unique_id' => $unique_id]));

        return response()->json(['message' => 'Profile added successfully', 'profile' => $profile], 201);
    }
    
    // update profile
    public function updateProfile(Request $request){
        $user = $request->input('user');
        $fields = $request->input('fields');
        
        if(!$user){
            return response()->json(['error' => 'No user is logged in.'], 401);
        }

        // do not authorize update unless admin
        if($user->user_priv != 1){
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
        
        // Check if profile exists
        $profile = Profile::find($fields->id);

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        // Validation rules
        $rules = [
            'unique_id' => 'required|unique:profiles,unique_id,',
            'familyID' => 'required',
            'phicID' => 'required',
            'nhtsID' => 'required',
            'head' => 'required',
            'relation' => 'required',
            'fname' => 'required',
            'mname' => 'required',
            'lname' => 'required',
            'suffix' => 'required',
            'dob' => 'required|date',
            'sex' => 'required',
            'barangay_id' => 'required|integer',
            'muncity_id' => 'required|integer',
            'province_id' => 'required|integer',
            'income' => 'required|integer',
            'unmet' => 'required|integer',
            'water' => 'required|integer',
            'toilet' => 'required|string|max:10',
            'education' => 'required|string|max:20',
            'hypertension' => 'required',
            'diabetic' => 'required',
            'pwd' => 'required',
            'pregnant' => 'required|date',
            'dengvaxia' => 'required|string|max:45',
            'sexually_active' => 'required|string|max:10',
            'nhts' => 'required',
            'four_ps' => 'required',
            'ip' => 'required',
            'member_others' => 'required',
            'balik_probinsya' => 'required',
            'updated_by' => 'required|string|max:10',
            'household_num' => 'required|string|max:30',
            'philhealth_categ' => 'required|string|max:15',
            'fourps_num' => 'required|string|max:30',
            'health_group' => 'required|string|max:20',
            'fam_plan' => 'required|string|max:10',
            'fam_plan_method' => 'required|string|max:20',
            'fam_plan_other_method' => 'required',
            'fam_plan_status' => 'required|string|max:25',
            'fam_plan_other_status' => 'required',
            'other_med_history' => 'required',
        ];

        // Validate input
        $validator = Validator::make($request->all(), $rules);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update profile
        $profile->update($request->all());

        return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile], 200);
    } 
    
    // delete profile
    public function deleteProfile(Request $request){
        $user = $request->input('user');
        $fields = $request->input('fields');
        
        if(!$user){
            return response()->json(['error' => 'No user is logged in.'], 401);
        }

        // do not authorize deletion unless admin
        if($user->user_priv != 1){
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        $profile = Profile::find($fields->id);
        $profile->delete(); 
        return response()->json(['message' => 'Deleted profile.'], 200);
    } 
}
