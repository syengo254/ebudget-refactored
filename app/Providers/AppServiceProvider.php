<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        RateLimiter::for("login-attempts", function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->user()->id ?? $request->ip)
                ->response(function (Request $request, array $headers) {
                    return response()->json([
                        "message" => "Max login attempts exceeded. Retry after 5 minutes."
                    ], 429, $headers);
                });
        });
    }
}
