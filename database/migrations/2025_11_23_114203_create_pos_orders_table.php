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
        Schema::create('pos_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('reservation_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('guest_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('order_type', ['room_service', 'restaurant', 'bar', 'spa', 'other'])->default('restaurant');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'preparing', 'ready', 'delivered', 'cancelled'])->default('pending');
            $table->boolean('charge_to_room')->default(false);
            $table->foreignId('served_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('order_time');
            $table->timestamp('delivered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_orders');
    }
};
