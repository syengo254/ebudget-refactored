<?php

namespace Tests\Feature;

use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

// use Laravel\Sanctum\Sanctum;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Referer' => 'http://localhost:5173',
            'Accept' => 'application/json', // Good practice for API-like interactions
        ])
            ->withSession([]);

        $this->user = User::factory()->create();

        // create profile
        $profile = Profile::factory()->create([
            'user_id' => $this->user->id,
        ]);

        // create address
        $address = Address::factory()->create([
            'profile_id' => $profile->id,
        ]);

        // set active address
        $profile->active_address_id = $address->id;
        $profile->save();
    }

    // test that user with correct credentials can login
    public function test_that_a_user_able_to_login_with_correct_credentials()
    {
        $response = $this->postJson("/api/login", [
            "email" => $this->user->email,
            "password" => "Password1234!",
        ]);

        $response->assertOk()->assertJson([
            "success" => true,
        ]);

        $this->assertAuthenticatedAs($this->user);
    }

    // test that user with incorrect credentials cannot login
    public function test_that_login_fails_with_wrong_credentials()
    {
        $response = $this->postJson("/api/login", [
            "email" => $this->user->email,
            "password" => "Password124!",
        ]);

        $response->assertStatus(401)->assertJson([
            "success" => false,
        ]);
    }

    // test that user with incorrect credentials cannot login
    // public function test_validation_error_for_nonexistent_email_login()
    // {
    //     $response = $this->postJson("/api/login", [
    //         "email" => "some.dummy@email.com",
    //         "password" => "Password1234!",
    //     ]);

    //     $response->assertStatus(422)->assertJsonValidationErrorFor("email");
    // }
}
