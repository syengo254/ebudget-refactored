<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserFormRequest;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\Store;
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

        $user = User::create($validated);

        if ($user) {
            // create profile entry
            Profile::create([
                'user_id' => $user->id,
                'phone' => NULL,
                'active_address_id' => NULL,
            ]);

            // if has_store create store entry
            if($user->has_store)
            {
                Store::create([
                    "user_id" => $user->id,
                    "logo" => NULL,
                    "name" => $user->name,
                ]);
            }

            // login user
            Auth::login($user);

            // send verify email
            $user->sendEmailVerificationNotification();

            return [
                "success" => true,
                "user" => new UserResource($user),
            ];
        }
        return [
            "success" => false,
            "message" => "Failed to create your user account. Try again later."
        ];
    }

    public function show(User $user)
    {
        if(Auth::user()->isNot($user)) abort(401);
        
        return UserResource::make($user);
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
