<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kitchen_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('restaurant_table_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('pos_order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('guest_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('order_type', ['dine_in', 'takeaway', 'room_service', 'delivery'])->default('dine_in');
            $table->enum('status', ['pending', 'confirmed', 'preparing', 'ready', 'served', 'cancelled'])->default('pending');
            $table->integer('number_of_guests')->default(1);
            $table->text('special_instructions')->nullable();
            $table->timestamp('order_time');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('prepared_at')->nullable();
            $table->timestamp('served_at')->nullable();
            $table->foreignId('waiter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('chef_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kitchen_orders');
    }
};
