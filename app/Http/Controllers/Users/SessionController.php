<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{

    public function store(LoginFormRequest $request)
    {
        $authenticated = Auth::attempt(
            $request->validated()
        );
        
        if ($authenticated) {
            // check if password rehash
            // if (Hash::needsRehash()) {
            //     $hashed = Hash::make('plain-text');
            // }
            request()->session()->regenerate();

            return response()->json([
                "success" => true,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => 'Login attempt failed.'
            ], 401);
        }
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            "success" => true,
            "message" => 'logged out'
        ]);
    }
}
