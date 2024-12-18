<?php

namespace App\Http\Controllers\TsekapV2;

use Illuminate\Http\Request;
use App\UserHealthFacility;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserHealthFacilityController extends Controller
{
    // add a user-health facility mapping
    public function addUserHealthFacility(Request $request)
    {
        $user = $request->input('user');
        $fields = $request->input('fields');

        $validator = Validator::make($fields->all(), [
            'user_id' => 'required|integer',
            'facility_id' => 'required|integer',
            'user_designation' => 'nullable|string|max:255',
            'assigned_at' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $existingMapping = UserHealthFacility::where('user_id', $user['user_id'])
            ->where('facility_id', $fields['facility_id'])
            ->first();

        // check mapping if it exists
        if ($existingMapping) {
            return response()->json(['message' => 'Mapping already exists'], 409);
        }

        $userHealthFacility = UserHealthFacility::create($request->all());

        return response()->json($userHealthFacility, 201);
    }

    // Get a user-health facility mapping
    public function retrieveUserHealthFacility(Request $request)
    {
        $fields = $request->input('fields');

        $userHealthFacility = UserHealthFacility::where('user_id', $fields['user_id'])
            ->where('facility_id', $fields['facility_id'])
            ->first();

        if (!$userHealthFacility) {
            return response()->json(['message' => 'Mapping not found'], 404);
        } 

        return response()->json($userHealthFacility);
    }

    // update a user-health facility mapping
    public function updateUserHealthFacility(Request $request)
    {
        $user = $request->input('user');
        $fields = $request->input('fields');
        
        // do not allow access unless no user is logged in.
        if(!$user){
            return response()->json(['error' => 'No user is logged in.'], 401);
        }

        // do not authorize update unless admin
        if ($user['user_priv'] != 1) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }
    
        $userHealthFacility = UserHealthFacility::where('user_id', $fields['user_id'])
            ->where('facility_id', $fields['facility_id'])
            ->first();
    
        if (!$userHealthFacility) {
            return response()->json(['message' => 'Mapping not found'], 404);
        }
    
        $validator = Validator::make($fields, [
            'user_designation' => 'nullable|string|max:255',
            'assigned_at' => 'sometimes|required|date',
            'new_facility_id' => 'sometimes|required|integer|exists:facilities,id',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        $validatedData = $validator->validated();
    
        if (isset($validatedData['new_facility_id'])) {
            $userHealthFacility->facility_id = $validatedData['new_facility_id'];
        }
    
        if (isset($validatedData['user_designation'])) {
            $userHealthFacility->user_designation = $validatedData['user_designation'];
        }
    
        if (isset($validatedData['assigned_at'])) {
            $userHealthFacility->assigned_at = $validatedData['assigned_at'];
        }
    
        $userHealthFacility->save();
    
        return response()->json($userHealthFacility);
    }
    

    // delete a user-health facility mapping
    public function deleteUserHealthFacility(Request $request)
    {
        $user = $request->input('user');
        $fields = $request->input('fields');

        // Do not authorize update unless admin
        if ($user['user_priv'] != 1) {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        $userHealthFacility = UserHealthFacility::where('user_id', $fields['user_id'])
            ->where('facility_id', $fields['facility_id'])->first();

        if (!$userHealthFacility) {
            return response()->json(['message' => 'Mapping not found'], 404);
        }

        $userHealthFacility->delete();

        return response()->json(['message' => 'Mapping deleted']);
    }
}
