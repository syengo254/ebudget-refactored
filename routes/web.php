<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

// home for redirects
Route::get("/home", function(){
    return response()->json([
        "message" => "You are already logged in.",
    ], headers: [
        "Access-Control-Allow-Origin" => "*",
    ]); 
})->name("home");


// email verification URLs
Route::get('/email/verify', function () {
    return redirect(env("UI_APP_URL" . "/verify_email"));
})->middleware('auth:sanctum')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
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
