<?php

use App\Http\Controllers\Orders\OrderController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Products\CategoryController;
use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Users\ProfileController;
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
Route::get("/authenticated", [SessionController::class, "authCheck"])->name("auth-check");
Route::get("/login", function () {
    return redirect(env("UI_APP_URL" . "/login", env("APP_URL"))); // SPA's login page
})->name("login");
Route::post("/login", [SessionController::class, "store"])->middleware(["guest:sanctum", "throttle:login-attempts"]);
Route::post("/logout", [SessionController::class, "destroy"]);

// password reset
Route::post('/forgot-password', [SessionController::class, "sendResetEmail"])->middleware("guest");
Route::post('/reset-password/{token}', [
    SessionController::class,
    "resetPassword"
])->middleware("guest")->name('password.reset');


// users
Route::post("/users", [UserController::class, "store"])->middleware("guest");
Route::get("/users/{user}", [UserController::class, "show"])->middleware("auth:sanctum");
Route::patch("/users/{user}", [UserController::class, "update"])->middleware("auth:sanctum");
Route::post("/profiles", [ProfileController::class, "store"])->middleware("auth:sanctum");

Route::middleware(["auth:sanctum", "verified"])->get("/users", [UserController::class, "index"]);
Route::middleware("auth:sanctum")->get("/users/{user}", [UserController::class, "show"]);


// products
Route::get("/products", [ProductController::class, "index"]);
Route::get("/products/{product}", [ProductController::class, "show"]);

// categories
Route::get("/categories", [CategoryController::class, "index"]);

// orders
Route::controller(OrderController::class)->middleware("auth:sanctum")->group(function(){
    Route::get("/orders", "index");
    Route::post("/orders", "store");
    Route::patch("/orders/{order}", "update");
    Route::get("/orders/{order}", "show");
});

// home for redirects
Route::get("/home", function(){
    return response()->json([
        "message" => "You are already logged in.",
    ], headers: [
        "Access-Control-Allow-Origin" => "*",
    ]); 
})->name("home");
