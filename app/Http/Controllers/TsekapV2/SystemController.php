<?php

namespace App\Http\Controllers\TsekapV2;

use App\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SystemController extends Controller
{
    // function to call once an endpoint is invoked
    public function api(Request $request) // Use Request object
    {
        $action = $request->get('r');

        // switch statement as to what is needed to be done
        switch ($action) {
            case 'login':
                return $this->login($request);
            case 'version':
                return $this->getVersion($request); // Pass request for client validation
            default:
                return response()->json(['error' => 'Invalid request'], 400);
        }
    }

    // # ---------- AUXILIARY FUNCTIONS ----------- # //

    // used to login users, optionally: to add register also.
    private function login(Request $request)
    {
        $username = $request->get('user');
        $password = $request->get('pass');
    
        $user = User::where('username', $username)->first();
    
        if ($user && Hash::check($password, $user->password)) {
            
            // You can set $userBrgy and $target as required
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

    // get version in case of documentation
    private function getVersion(Request $request)
    {
        $client = $request->get('client');

        if (!$client) {
            return response()->json(['error' => 'Invalid parameter'], 400);
        }

        return response()->json([
            'apiName' => 'Tsekap 2.0 API',
            'revision' => '1.0',
            'client' => $client
        ]);
    }

    // # ---------------- BASE FUNCTIONS ----------------- #
    
}