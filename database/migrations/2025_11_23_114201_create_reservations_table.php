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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_number')->unique();
            $table->foreignId('guest_id')->constrained()->onDelete('cascade');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('number_of_guests');
            $table->integer('number_of_rooms');
            $table->enum('status', ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled', 'no_show'])->default('pending');
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('deposit_amount', 10, 2)->default(0);
            $table->enum('booking_source', ['walk_in', 'phone', 'email', 'website', 'third_party'])->default('walk_in');
            $table->text('special_requests')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
