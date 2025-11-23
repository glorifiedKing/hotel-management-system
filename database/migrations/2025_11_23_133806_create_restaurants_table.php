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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['restaurant', 'bar', 'cafe', 'lounge', 'other'])->default('restaurant');
            $table->text('description')->nullable();
            $table->string('location')->nullable(); // Floor, Building, etc.
            $table->integer('floor')->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->integer('seating_capacity')->nullable();
            $table->unsignedBigInteger('kitchen_id')->nullable(); // No foreign key yet
            $table->boolean('is_active')->default(true);
            $table->boolean('accepts_reservations')->default(true);
            $table->json('operating_days')->nullable(); // ['monday', 'tuesday', ...]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
