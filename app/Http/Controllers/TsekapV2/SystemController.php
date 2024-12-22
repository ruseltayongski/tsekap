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
        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {

            // Log the user in
            Auth::login($user);

            // Generate a CSRF token
            $csrfToken = csrf_token();

            // Set the XSRF-TOKEN and X-CSRF-TOKEN cookies
            $xsrfCookie = Cookie::make('XSRF-TOKEN', $csrfToken, 60);
            $csrfCookie = Cookie::make('X-CSRF-TOKEN', $csrfToken, 60);

            return Response::json([
                'data' => $user,
                'status' => 'success'
            ])->withCookie($xsrfCookie)->withCookie($csrfCookie);
        }

        return Response::json(['status' => 'denied'], 401);
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
