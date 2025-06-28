<?php

use App\Http\Controllers\Customers\CustomerController;
use App\Http\Controllers\Customers\SessionController as CustomerSessionController;
use App\Http\Controllers\Stores\SessionController as StoreSessionController;
use App\Http\Controllers\Stores\StoreController;
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

Route::get("/", function(){
    return "OKe";
});

Route::get('/csrf', function () {
    return [
        "token" => csrf_token(),
    ];
})->middleware('web')->name('api.csrf');


// ===================================== Customers Routes =========================================================

Route::prefix('customers')->group(function () {
   
    Route::post('/login', [CustomerSessionController::class, "store"])->middleware(["web", "guest"]);
    Route::post('/logout', [CustomerSessionController::class, "destroy"])->middleware("auth:web");

    Route::post('/', [CustomerController::class, "store"])->middleware("guest:web");
    Route::get('/{customer}', [CustomerController::class, "show"])->middleware("auth:web");
});

// ================================================================================================================


// =========================================== Stores Routes ======================================================

Route::prefix('stores')->group(function () {

    Route::middleware(['web', 'auth:store'])->group(function () {
        Route::post('/login', [StoreSessionController::class, "create"]);
        Route::post('/logout', [StoreSessionController::class, "destroy"]);
    });

    Route::controller(StoreController::class)->group(function () {

        Route::middleware(['web'])->group(function () {

            Route::post('/', 'store');

            Route::middleware(['auth:store'])->group(function () {

                Route::get('/{store}', 'show');
            });
        });
    });
});

// =================================================================================================================


Route::get('/public', function () {
    // todo: redirect to frontend login page.
    return ["message" => "you are not logged in"];
})->middleware('web')->name('login');
