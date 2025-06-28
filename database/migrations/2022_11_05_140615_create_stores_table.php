<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->mediumText('name');
            $table->char('email', 100)->unique();
            $table->string('password');
            $table->text('logo')->nullable();
            $table->text('phone_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->unsignedBigInteger('active_address_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
