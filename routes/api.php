<?php

use App\Http\Controllers\Users\SessionController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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


// auth
Route::get("/login", function(){
    return redirect(env("UI_APP_URL" . "/login", env("APP_URL"))); // SPA's login page
})->name("login");

Route::post("/login", [SessionController::class, "store"]);
Route::post("/logout", [SessionController::class, "destroy"])->middleware("auth:sanctum");


// users
Route::post("/users", [UserController::class, "store"])->middleware("guest");

Route::middleware(["auth:sanctum", "verified"])->get("/users", [UserController::class, "index"]);
Route::middleware("auth:sanctum")->get("/users/{user}", [UserController::class, "show"]);


// email verification URLs
Route::get('/email/verify', function () {
    return redirect(env("UI_APP_URL" . "/verify_email"));
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect(env("UI_APP_URL"));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return response() ->json([
        "success" => true,
        "message" => "Verification link sent!",
    ]);
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
