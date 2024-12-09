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
        $username = $request->query('user');
        $password = $request->query('pass');

        $user = User::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            // Optional: Set $userBrgy and $target as required
            $userBrgy = 0;
            $target = 0;

            // Set the XSRF token in the cookies
            $cookie = cookie('XSRF-TOKEN', csrf_token(), 60); // 60 minutes expiration time

            return response()->json([
                'data' => $user,
                'userBrgy' => $userBrgy,
                'muncity' => $user->muncity,
                'target' => $target,
                'status' => 'success'
            ])->cookie($cookie); // Attach the cookie to the response
        }

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


