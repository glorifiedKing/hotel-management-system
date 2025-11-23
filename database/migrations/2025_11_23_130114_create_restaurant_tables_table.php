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
        Schema::create('restaurant_tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number')->unique();
            $table->string('location')->default('restaurant'); //['restaurant', 'bar', 'outdoor', 'vip']
            $table->integer('capacity');
            $table->enum('status', ['available', 'occupied', 'reserved', 'cleaning'])->default('available');
            $table->string('section')->nullable();
            $table->integer('floor')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_tables');
    }
};
