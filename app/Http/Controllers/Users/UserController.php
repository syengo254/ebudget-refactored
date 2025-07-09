<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserFormRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\Profile;
use App\Models\Store;
use App\Models\User;
use Exception;
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
            if ($user->has_store) {
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
        if (Auth::user()->isNot($user)) abort(401);

        return UserResource::make($user);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();

        try {
            if (Auth::user()->isNot($user)) abort(401);

            if (array_key_exists("name", $validated)) {
                $user->name = $validated["name"];
            }

            if (array_key_exists("password", $validated)) {
                $user->password = Hash::make($validated["password"]);
            }

            $saved = $user->save();
            $user->refresh();
            Auth::login($user);
            request()->session()->regenerate();

            return [
                "success" => $saved,
                "user" => $user,
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "user" => $user,
            ];
        }
    }

    public function destroy(User $user)
    {
        //
    }
}
