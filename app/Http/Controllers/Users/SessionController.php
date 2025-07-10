<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\LoginFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SessionController extends Controller
{
    public function authCheck()
    {
        if (Auth::user()) {
            return response()->json([
                "authenticated" => true,
                "user" => new UserResource(Auth::user()),
            ]);
        }

        return [
            "authenticated" => false,
            "user" => null,
        ];
    }

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
                "user" => new UserResource(Auth::user()),
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => 'Login failed. Invalid credentials'
            ], 401);
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard("web")->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            "success" => true,
            "message" => 'logged out'
        ]);
    }

    public function sendResetEmail(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email",
        ]);

        $status = Password::sendResetLink($validated);

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                "success" => true,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "status" => $status,
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email",
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                "success" => true,
            ]);
        } else {
            return response()->json([
                "success" => false,
                "status" => $status,
            ]);
        }
    }
}
