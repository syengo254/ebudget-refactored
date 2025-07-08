<?php

namespace Tests\Unit;

use App\Jobs\SendVerifyEmailJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_when_user_is_created_an_email_job_is_pushed_to_queue()
    {
        $user_data = [
            "name" => "Example User",
            "email" => "exampleuser@example.com",
            "password" => "Password1234!",
            "has_store" => true,
        ];

        $user = \App\Models\User::create($user_data);
        Queue::fake();
        $user->sendEmailVerificationNotification();
        // Queue::assertPushed(SendVerifyEmailJob::class);
        $this->assertTrue(Queue::hasPushed(SendVerifyEmailJob::class));
    }
}
