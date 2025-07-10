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
            $passwordChanged = false;

            if (array_key_exists("name", $validated) && $validated["name"] !== $user->name) {
                $user->name = $validated["name"];
                $user->save();

                if($user->has_store){
                    $user->store->name = $validated["name"];
                    $user->store->save();
                }
            }

            if (array_key_exists("logo", $validated)) {
                $path = $request->logo->store('logos');
                $user->store->logo = $path;
                $user->store->save();
            }

            if (array_key_exists("password", $validated)) {
                $user->password = Hash::make($validated["password"]);
                $passwordChanged = true;
            }

            $saved = $user->save();
            $user->refresh();
            
            if($passwordChanged){
                Auth::guard("web")->login($user);
                request()->session()->regenerate();
            }

            return [
                "success" => $saved,
                "user" => new UserResource($user),
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "user" => new UserResource($user),
                "Exception" => $e->getMessage(),
            ];
        }
    }

    public function destroy(User $user)
    {
        //
    }
}
