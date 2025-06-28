<?php

use App\Http\Controllers\Users\SessionController;
use App\Http\Controllers\Users\UserController;
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

Route::post("/login", [SessionController::class, "store"])->middleware(["guest", "throttle:login-attempts"]);
Route::post("/logout", [SessionController::class, "destroy"])->middleware("auth:sanctum");



// users
Route::post("/users", [UserController::class, "store"])->middleware("guest");

Route::middleware(["auth:sanctum", "verified"])->get("/users", [UserController::class, "index"]);
Route::middleware("auth:sanctum")->get("/users/{user}", [UserController::class, "show"]);
