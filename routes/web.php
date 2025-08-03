<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});


// email verification URLs
Route::get('/email/verify', function () {
    return redirect(env("UI_APP_URL" . "/verify_email"));
})->middleware('auth:sanctum')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    if (Auth::user()->has_store) {
        return redirect(env("UI_APP_URL") . "/dashboard");
    }

    return redirect(env("UI_APP_URL"));
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

// resend verify email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return response()->json([
        "success" => true,
        "message" => "Verification link sent!",
    ]);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

Route::get('/preview', function () {
    //
});

// useful for cpanel hosting as SSH terminal access is not available
Route::get('/setup', function () {
    Artisan::call('storage:link');
    Artisan::call('route:cache');

    return 'storage linked and routes cached!';
});
