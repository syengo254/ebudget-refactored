<?php

use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fixuserprofiles', function () {
    $this->comment("Starting to fix...");

    $users = User::with('profile')->get();
    $users_without_profiles = $users->filter(function($user, $key) {
        return $user->profile == NULL;
    });

    $this->comment("Found {$users_without_profiles->count()} users without profiles");

    $command = $this;
    $users_without_profiles->each(function($user, $key) use ($command) {
        $pf = Profile::create([
                'user_id' => $user->id,
                'phone' => NULL,
                'active_address_id' => NULL,
            ]);
        $command->comment("Created profile entry for user '{$user->name}' with profile id: {$pf->id}");
    });

})->purpose('Create a 1-1 entry for users who don\'t have a profile entry');
