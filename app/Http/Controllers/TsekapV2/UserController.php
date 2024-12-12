<?php

namespace App\Http\Controllers\TsekapV2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // changes the user's password
    public function updateUserPassword(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required',
            'newPassword' => 'required|min:5',
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $currentPassword = $request->input('currentPassword');
        $newPassword = $request->input('newPassword');
        $username = $request->input('username');

        // Fetch the user based on the provided username
        $user = User::where('username', '=', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Verify that the current password matches the user's existing password
        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json(['error' => 'Current password is incorrect'], 400);
        }

        // Update the user's password with the new password
        $user->password = Hash::make($newPassword);
        $user->save();

        // Return a success response
        return response()->json(['message' => 'Password changed successfully'], 200);
    }

    // changes/updates any of the ff. user's name (fname, mname, lname)
    public function updateUserFullName(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Get username 
        $username = $request->input('username');

        // Get names
        $firstName = $request->input('firstName');
        $middleName = $request->input('middleName');
        $lastName = $request->input('lastName');

        // Fetch the user based on the provided username
        $user = User::where('username', '=', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update the user's full name if the fields are not blank
        if (!is_null($firstName) && trim($firstName) !== '') {
            $user->fname = $firstName;
        }
        if (!is_null($middleName) && trim($middleName) !== '') {
            $user->mname = $middleName;
        }
        if (!is_null($lastName) && trim($lastName) !== '') {
            $user->lname = $lastName;
        }

        // Save the changes
        $user->save();

        // Return a success response
        return response()->json(['message' => 'Names updated successfully'], 200);
    }


    // changes the user's contact
    public function updateUserContact(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'contact' => 'required|min:11|max:11'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Get username
        $username = $request->input('username');

        // Get contact
        $contact = $request->input('contact');

        // Fetch the user based on the provided username
        $user = User::where('username', '=', $username)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Update the user's full name if the fields are not blank
        $user->contact = $contact;

        // Save the changes
        $user->save();

        // Return a success response
        return response()->json(['message' => 'Contact updated successfully'], 200);
    }
}
