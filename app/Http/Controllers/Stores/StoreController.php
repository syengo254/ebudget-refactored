<?php

namespace App\Http\Controllers\Stores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginFormRequest;
use App\Http\Requests\Stores\StoreRegisterFormRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegisterFormRequest $request)
    {
        $validated = $request->validated();
        $validated["password"] = bcrypt($validated["password"]);

        // upload logo first
        // TODO: Logo should be uploaded later after signup, in the profile section
        $path = $request->file('logo')->store('logos', 'public');
        $validated["logo"] = $path;

        $store = Store::create($validated);
        // todo: activating store account
        if ($store) {
            return [
                "success" => true,
                "store" => $store,
            ];
        }
        return [
            "success" => false,
            "message" => "Failed to create your store account. Try again later."
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Store $store)
    {
        if ($request->user()->id !== $store->id) {
            return [
                "message" => "Unauthorized access",
            ];
        }
        return $store ?? null;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }
}
