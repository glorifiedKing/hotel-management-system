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
        Schema::create('kitchens', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['main', 'bar', 'pastry', 'cold', 'hot', 'other'])->default('main');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->integer('floor')->nullable();
            $table->unsignedBigInteger('restaurant_id')->nullable(); // No foreign key yet
            $table->boolean('is_active')->default(true);
            $table->integer('max_concurrent_orders')->default(10);
            $table->json('specialties')->nullable(); // ['italian', 'grills', ...]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kitchens');
    }
};
