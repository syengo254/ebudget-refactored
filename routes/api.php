<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\SessionController;
use App\Http\Controllers\Users\UserController;

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

Route::get("/authenticated", [SessionController::class, "authCheck"])->name("auth-check");

Route::post("/login", [SessionController::class, "store"])->middleware(["guest:sanctum", "throttle:login-attempts"]);
Route::post("/logout", [SessionController::class, "destroy"]);



// users
Route::post("/users", [UserController::class, "store"])->middleware("guest");

Route::middleware(["auth:sanctum", "verified"])->get("/users", [UserController::class, "index"]);
Route::middleware("auth:sanctum")->get("/users/{user}", [UserController::class, "show"]);


// // csrf
// Route::get('/sanctum/csrf-cookie', function(Request $request){
//     return ["_token" => urldecode($request->session()->token())];
// });
