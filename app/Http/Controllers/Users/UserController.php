<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function store(UserFormRequest $request)
    {
        $validated = $request->validated();
        $validated["password"] = Hash::make($validated["password"]);
        
        $user = User::create($validated);
        
        if ($user) {
            // send verify email
            event(new Registered($user));
            
            // login user
            Auth::login($user);

            return [
                "success" => true,
                "user" => $user,
            ];
        }
        return [
            "success" => false,
            "message" => "Failed to create your user account. Try again later."
        ];
    }

    public function show(User $user)
    {
        if (Auth::guest() || !$user->is(Auth::user())) {
            return response()->json([
                "message" => "Unauthorized access",
            ], 401);
        }

        return $user;
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
