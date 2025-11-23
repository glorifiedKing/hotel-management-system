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
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('track_inventory')->default(false)->after('is_taxable');
            $table->json('recipe')->nullable()->after('track_inventory'); // Array of inventory items and quantities
            $table->decimal('preparation_time', 5, 2)->nullable()->after('recipe'); // In minutes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            //
        });
    }
};
