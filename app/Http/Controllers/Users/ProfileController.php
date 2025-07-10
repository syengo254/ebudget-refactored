<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "phone" => "sometimes|string|min:10",
            "building" => "sometimes|string|min:4|nullable",
            "town" => "sometimes|string|min:3|nullable",
            "city" => "sometimes|string|min:4|nullable",
            "floor" => "sometimes|string|min:2|nullable",
            "additional_info" => "sometimes|string|max:200|nullable",
        ]);

        $success = false;

        try {
            $user_profile = Auth::user()->profile;

            if (array_key_exists("phone", $validated)) {
                // add phone
                $user_profile->phone = $validated["phone"];
                $success = $user_profile->save();

                unset($validated["phone"]);
            }

            if(!empty($validated)){
                $address = Address::create($validated + [
                    "profile_id" => $user_profile->id,
                ]);
                $user_profile->active_address_id = $address->id;
                $success = $user_profile->save();
            }

            return [
                "success" => $success,
                "user" => UserResource::make(Auth::user()),
            ];
        } catch (Exception $e) {
            $success = false;
            return [
                "success" => $success,
                "error" => $e,
            ];
        }
    }
}
