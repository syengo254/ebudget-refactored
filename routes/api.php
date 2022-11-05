<?php

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/customers/login', function (Request $request) {
    $authenticated = Auth::guard('web')->attempt(["email" => "david.syengo019@gmail.com", "password" => "Password123!"]);
    if ($authenticated) {
        $request->session()->regenerate();
        return ["result" => 'successful'];
    } else {
        return ["result" => 'login attempt failed'];
    }
})->middleware('web');

Route::get('/customers/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return [
        "result" => 'logged out'
    ];
})->middleware(['web', 'auth:web']);

Route::get('/customer', function (Request $request) {
    return $request->user();
})->middleware(['web', 'auth:web']);


Route::get('/public', function (Request $request) {
    return ["message" => "you are not logged in"];
})->middleware('web')->name('login');
