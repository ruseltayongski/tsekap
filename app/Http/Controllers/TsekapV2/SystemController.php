<?php

namespace App\Http\Controllers\TsekapV2;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Cookie;

class SystemController extends Controller
{
    // Used to login users
    public function login(Request $request)
    {
        $username = $request->input('user');
        $password = $request->input('pass');

        if (!$username || !$password) {
            return Response::json(['status' => 'error', 'message' => 'Username and password are required'], 400);
        }

        // Attempt to find the user by username
        $user = User::select(
            'users.*',
            'muncity.description as muncity_name',
            'province.description as province_name',
            'user_health_facility.facility_id',
            'facilities.name as facility_name',
            'user_health_facility.user_designation as user_designation'
        )
            ->where('username', $username)
            ->join('muncity', 'users.muncity', '=', 'muncity.id')
            ->join('province', 'users.province', '=', 'province.id')
            ->leftJoin('user_health_facility', 'users.id', '=', 'user_health_facility.user_id')
            ->leftJoin('facilities', 'user_health_facility.facility_id', '=', 'facilities.id')
            ->first();

        if ($user) {
            // Check if the user is verified
            if (!$user->verified) {
                return response()->json(['status' => 'error', 'message' => 'Your account is not yet verified. Please contact the administrator.'], 403);
            }
            
            if (Hash::check($password, $user->password)) {
                // Log the user in
                Auth::login($user);

                // Generate a CSRF token
                $csrfToken = csrf_token();

                // Set the XSRF-TOKEN and X-CSRF-TOKEN cookies
                $xsrfCookie = Cookie::make('XSRF-TOKEN', $csrfToken, 60);
                $csrfCookie = Cookie::make('X-CSRF-TOKEN', $csrfToken, 60);

                return Response::json([
                    'data' => [
                        'user' => $user,
                        'facility' => $user->facility_id ? [
                            'id' => $user->facility_id,
                            'name' => $user->facility_name,
                        ] : null,
                    ],
                    'status' => 'success',
                ])->withCookie($xsrfCookie)->withCookie($csrfCookie);
            } else {
                return Response::json(['status' => 'error', 'message' => 'Invalid credentials'], 401);
            }
        }

        return Response::json(['status' => 'error', 'message' => 'User not found'], 404);
    }

    public function selfRegisterUser(Request $request)
    {
        $fields = $request->input('fields');

        // Validate the input
        $fieldsValidator = \Validator::make($fields, [
            'fname' => 'required|string|max:255',
            'mname' => 'string|max:255',
            'lname' => 'required|string|max:255',
            'muncity' => 'required|integer',
            'province' => 'required|integer',
            'facility_id' => 'required|integer',
            'user_designation' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|max:255',
            'contact' => 'required|string|max:11',
            'user_priv' => 'required|integer',
            'email' => 'string|max:255|email',
        ]);

        if ($fieldsValidator->fails()) {
            return response()->json(['error' => $fieldsValidator->errors()->all()], 400);
        }

        $validatedFields = $fieldsValidator->getData();

        // Check if the username already exists
        if (User::where('username', $validatedFields['username'])->exists()) {
            return response()->json(['status' => 'error', 'message' => 'This account has already been taken.'], 400);
        }

        try {
            // Create new user record
            $user = new User();
            $user->fname = $validatedFields['fname'];
            $user->mname = $validatedFields['mname'] ?? null;
            $user->lname = $validatedFields['lname'];
            $user->muncity = $validatedFields['muncity'];
            $user->province = $validatedFields['province'];
            $user->username = $validatedFields['username'];
            $user->password = \Hash::make($validatedFields['password']); // Encrypt password
            $user->contact = $validatedFields['contact'];
            $user->user_priv = $validatedFields['user_priv'];
            $user->email = $validatedFields['email'] ?? null;
            $user->verified = 0; // Make this field zero because it is self-registered and still needs to be verified
            $user->save();


            $userHfMapping = \App\UserHealthFacility::create([
                'user_id' => $user->id,
                'facility_id' => $validatedFields['facility_id'],
                'user_designation' => $validatedFields['user_designation'],
                'assigned_at' => \Carbon\Carbon::now(), // set current timestamp
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }

        $message = "Welcome to Tsekapp, " . $user->fname . " (" . $userHfMapping->user_designation . ")! Please wait for the admin to verify your account before you can log in.";
        return response()->json(['status' => 'success', 'message' => $message], 201);
    }

    // Logout the user
    public function logout()
    {
        Auth::logout();
        return Response::json(['status' => 'success', 'message' => 'Logged out successfully']);
    }

    // Get version for API documentation
    public function getVersion()
    {
        return Response::json([
            'apiName' => 'Tsekap 2.0 API',
            'revision' => '1.0',
        ]);
    }
}
