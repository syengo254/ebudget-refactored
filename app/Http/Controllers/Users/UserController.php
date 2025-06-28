<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserFormRequest;
use App\Models\User;
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
        
        $customer = User::create($validated);
        // todo: email verification
        if ($customer) {
            return [
                "success" => true,
                "customer" => $customer,
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

    public function update(Request $request, User $customer)
    {
        //
    }

    public function destroy(User $customer)
    {
        //
    }
}
