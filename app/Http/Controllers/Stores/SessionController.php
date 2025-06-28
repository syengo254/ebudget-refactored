<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
     /**
     * Login a member.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(LoginFormRequest $request)
    {
        $validated = $request->validated();
        
        if (Auth::guard('store')->attempt($validated)) {
            $request->session()->regenerate();
            return [
                "success" => true,
            ];
        } else {
            return [
                "success" => false,
                "message" => 'Login attempt failed.'
            ];
        }
    }

    /**
     * Login a member.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('store')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return [
            "success" => true,
            "message" => 'logged out'
        ];
    }
}
