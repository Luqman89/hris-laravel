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
            $table->ulid('id')->primary();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('employee_code')->unique();
            $table->string('full_name');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->foreignUlid('department_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignUlid('position_id')->constrained('positions')->cascadeOnDelete();
            $table->date('hire_date');
            $table->string('status')->default('ACTIVE');
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
