<?php

use App\Http\Controllers\Customers\CustomerController;
use App\Http\Controllers\Stores\StoreController;
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

Route::get('/csrf', function (Request $request) {
    return [
        "token" => csrf_token(),
    ];
})->middleware('web')->name('api.csrf');

Route::prefix('customers')->group(function () {

    Route::controller(CustomerController::class)->group(function () {

        Route::middleware(['web'])->group(function () {

            Route::post('/register', 'register');

            Route::post('/login', 'login');

            Route::middleware(['auth:web'])->group(function () {

                Route::get('/logout', 'logout');

                Route::get('/{customer}', 'show');
            });
        });
    });
});

Route::prefix('stores')->group(function () {

    Route::controller(StoreController::class)->group(function () {

        Route::middleware(['web'])->group(function () {

            Route::post('/register', 'register');

            Route::post('/login', 'login');

            Route::middleware(['auth:store'])->group(function () {

                Route::get('/logout', 'logout');

                Route::get('/{store}', 'show');
            });
        });
    });
});

Route::get('/public', function (Request $request) {
    // todo: redirect to frontend login page.
    return ["message" => "you are not logged in"];
})->middleware('web')->name('login');
