<?php

use App\Enums\OrderStatus;
use App\Http\Resources\UserResource;
use App\Mail\OrderCreated;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

// SPA home for redirects
Route::get("/home", function () {
    return response()->json([
        "success" => true,
        "user" => UserResource::make(Auth::user()),
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
    //Mail::to(Auth::user())->queue(new OrderCreated(Order::find(28)));
    // $products = Product::query()
    //     ->withCount('orderItems')
    //     ->with("orderItems")
    //     ->where("store_id", "=", 6)
    //     ->addSelect([
    //         "total_quantity_ordered" => OrderItem::whereColumn("product_id", 'products.id')
    //             ->selectRaw("sum(item_count) as quantity")
    //     ])
    //     ->get();

    return Store::find(6)->orderItems()->whereHas("order", function($query){
        $query->where("status", OrderStatus::CANCELLED->value);
    })->get();
});
