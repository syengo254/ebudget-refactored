<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function store(LoginFormRequest $request)
    {
        $validated = $request->validated();
        $exists = false;

        $authenticated = Auth::guard('web')->attemptWhen($validated, fn($customer) => $customer->is_active);
        
        if ($authenticated) {
            $request->session()->regenerate();
            return [
                "success" => true,
            ];
        } else {
            return [
                "success" => false,
                "message" => $exists ? 'Your account is not activated' : 'Login attempt failed.'
            ];
        }
    }

    /**
     * Logout a member.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return [
            "success" => true,
            "message" => 'logged out'
        ];
    }
}
