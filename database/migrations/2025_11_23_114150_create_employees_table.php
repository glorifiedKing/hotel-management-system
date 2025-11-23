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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('employee_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->enum('department', ['front_desk', 'housekeeping', 'maintenance', 'food_beverage', 'management', 'other'])->default('other');
            $table->string('position');
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->date('hire_date');
            $table->date('termination_date')->nullable();
            $table->enum('employment_status', ['active', 'inactive', 'terminated'])->default('active');
            $table->text('address')->nullable();
            $table->text('emergency_contact')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
