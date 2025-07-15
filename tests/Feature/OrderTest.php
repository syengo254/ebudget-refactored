<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderCreated;
// use Laravel\Sanctum\Sanctum;

class OrderTest extends TestCase
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
        $this->actingAs($this->user);

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

        // create products
        Product::factory()->count(2)->create();
    }

    public function test_user_can_create_order()
    {
        $orderPayload = [
            'order' => [
                [
                    'product_id' => 1,
                    'count' => 1,
                ],
                [
                    'product_id' => 2,
                    'count' => 2,
                ],
            ],
            'cart_id' => $this->faker->uuid(),
        ];

        $response = $this->postJson('/api/orders', $orderPayload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Your order has been created.',
            ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
        ]);
        $this->assertDatabaseCount('order_items', 2);
    }

    public function test_unverified_user_cannot_create_order()
    {
        $this->user = User::factory()->unverified()->create();
        $this->actingAs($this->user);

        $orderPayload = [
            'order' => [
                [
                    'product_id' => 1,
                    'count' => 1,
                ],
            ],
            'cart_id' => $this->faker->uuid(),
        ];

        $response = $this->postJson('/api/orders', $orderPayload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
                'order' => null,
                'message' => 'You need to verify your account.',
            ]);
    }

    // test with non-existent product
    public function test_non_existent_product_cannot_be_added_to_order()
    {
        $orderPayload = [
            'order' => [
                [
                    'product_id' => 999,
                    'count' => 1,
                ],
            ],
            'cart_id' => $this->faker->uuid(),
        ];

        $response = $this->postJson('/api/orders', $orderPayload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'order.0.product_id',
            ]);
    }

    // test on success, order created mail is queued
    public function test_on_success_order_created_mail_is_queued()
    {
        Mail::fake();

        $orderPayload = [
            'order' => [
                [
                    'product_id' => 1,
                    'count' => 1,   
                ],
            ],
            'cart_id' => $this->faker->uuid(),
        ];

        $response = $this->postJson('/api/orders', $orderPayload);

        Mail::assertQueued(OrderCreated::class, function ($mail) {
            return $mail->hasTo($this->user->email);
        });
    }
}
