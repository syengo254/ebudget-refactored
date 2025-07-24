<?php

use App\Enums\OrderStatus;
use App\Models\Address;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("order_no", length:12)->unique();
            $table->foreignIdFor(User::class);
            $table->enum('status', array_column(OrderStatus::cases(), "value"))->default(OrderStatus::NEW->value);
            $table->date('expected_delivery_date');
            $table->date('latest_delivery_date');
            $table->date('actual_delivery_date')->nullable();
            $table->decimal('delivery_charge');
            $table->foreignIdFor(Address::class)->nullable();
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
        Schema::dropIfExists('orders');
    }
};
