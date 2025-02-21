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
