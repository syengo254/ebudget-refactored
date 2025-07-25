<?php

namespace Tests\Feature;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\RequestGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

// use Laravel\Sanctum\Sanctum;

class UserRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Referer' => 'http://localhost:5173',
            'Accept' => 'application/json', // Good practice for API-like interactions
        ]);

        RequestGuard::macro('logout', function () {
            // $this->user = null;
        });

        $this->app['auth']->guard('web')->logout();
    }

    public function test_that_we_have_validation_errors_with_invalid_data()
    {
        $response = $this->post('/api/logout');
        $payload = [
            "email" => "johndoe@example.com",
            "password" => "Password1234!",
            "password_confirmation" => "Password234!",
            "name" => "John Doe",
            "has_store" => 0,
        ];

        $response = $this->postJson("api/users", $payload);

        $response->assertInvalid(["password"])->assertStatus(422);
    }

    public function test_that_a_user_can_register_with_valid_data()
    {
        $payload = [
            "email" => "johndoe@example.com",
            "password" => "Password1234!",
            "password_confirmation" => "Password1234!",
            "name" => "John Doe",
            "has_store" => 0,
        ];

        $response = $this->postJson("api/users", $payload);
        $response->dump();

        $response->assertStatus(200)->assertJson([
            "success" => TRUE,
        ]);
    }
}
