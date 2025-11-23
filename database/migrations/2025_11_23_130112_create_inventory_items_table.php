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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('inventory_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->string('unit_of_measurement'); // kg, liters, pieces, etc.
            $table->decimal('current_stock', 10, 2)->default(0);
            $table->decimal('minimum_stock', 10, 2)->default(0);
            $table->decimal('maximum_stock', 10, 2)->nullable();
            $table->decimal('reorder_point', 10, 2)->default(0);
            $table->decimal('cost_per_unit', 10, 2)->default(0);
            $table->string('storage_location')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('is_perishable')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
