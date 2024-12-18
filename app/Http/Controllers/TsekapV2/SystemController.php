<?php

namespace App\Http\Controllers\TsekapV2;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SystemController extends Controller
{
    // Used to login users
    public function login(Request $request)
    {
        // Extract username and password from query parameters
        $username = $request->input('user');
        $password = $request->input('pass');
    
        // Validate the input
        if (!$username || !$password) {
            return response()->json(['status' => 'error', 'message' => 'Username and password are required'], 400); // Bad request
        }
    
        // Attempt to find the user by username
        $user = User::where('username', $username)->first();
    
        // Check if user exists and password is correct
        if ($user && Hash::check($password, $user->password)) {
    
            // Generate a CSRF token
            $csrfToken = csrf_token();
    
            // Set the XSRF-TOKEN and X-CSRF-TOKEN cookies
            $xsrfCookie = cookie('XSRF-TOKEN', $csrfToken, 60); // 60 minutes expiration time
            $csrfCookie = cookie('X-CSRF-TOKEN', $csrfToken, 60); // 60 minutes expiration time
    
            // Return success response with user data and attach the CSRF token cookies
            return response()->json([
                'data' => $user,
                'status' => 'success'
            ])->cookie($xsrfCookie)->cookie($csrfCookie); // Attach both cookies to the response
        }
    
        // Return unauthorized response if credentials are invalid
        return response()->json(['status' => 'denied'], 401); // Use 401 for unauthorized
    }
    
    // Get version for API documentation
    public function getVersion()
    {
        return response()->json([
            'apiName' => 'Tsekap 2.0 API',
            'revision' => '1.0',
        ]);
    }
}


