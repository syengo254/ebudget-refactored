<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function store(LoginFormRequest $request)
    {
        $authenticated = Auth::attemptWhen(
            $request->validated(),
            fn($user) => $user->email_verified_at != null
        );
        
        if ($authenticated) {
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

    /**
     * Logout a member.
     *
     * @return \Illuminate\Http\Response
     */
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
