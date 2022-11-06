<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFormRequest;
use App\Http\Requests\Customers\CustomerFormRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Get csrf token for post requests
     *
     * @return \Illuminate\Http\Response
     */
    public function csrf(Request $request)
    {
        return [
            "token" => csrf_token(),
        ];
    }

    /**
     * Login a member.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginFormRequest $request)
    {
        $validated = $request->validated();
        $exists = false;
        $closure = function ($customer) use (&$exists) {
            $exists = true;
            return $customer->is_active;
        };
        $authenticated = Auth::guard('web')->attemptWhen($validated, $closure);
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
     * Login a member.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return [
            "success" => true,
            "message" => 'logged out'
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(CustomerFormRequest $request)
    {
        $validated = $request->validated();
        $validated["password"] = bcrypt($validated["password"]);
        $customer = Customer::create($validated + ["is_active" => true]);
        // todo: activating user account
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

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Customer  $customer)
    {
        if ($request->user()->id !== $customer->id) {
            return [
                "message" => "Unauthorized access",
            ];
        }
        return $customer ?? null;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
