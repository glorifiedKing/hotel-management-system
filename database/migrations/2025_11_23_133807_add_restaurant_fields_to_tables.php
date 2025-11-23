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
        Schema::table('restaurant_tables', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });

        Schema::table('kitchen_orders', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->nullable()->after('id')->constrained()->onDelete('set null');
            $table->foreignId('kitchen_id')->nullable()->after('restaurant_id')->constrained()->onDelete('set null');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('restaurant_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurant_tables', function (Blueprint $table) {
            $table->dropForeign(['restaurant_id']);
            $table->dropColumn('restaurant_id');
        });

        Schema::table('kitchen_orders', function (Blueprint $table) {
            $table->dropForeign(['restaurant_id']);
            $table->dropForeign(['kitchen_id']);
            $table->dropColumn(['restaurant_id', 'kitchen_id']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['restaurant_id']);
            $table->dropColumn('restaurant_id');
        });
    }
};
