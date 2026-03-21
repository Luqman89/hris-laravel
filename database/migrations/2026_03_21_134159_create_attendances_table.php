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
        Schema::create('attendances', function (Blueprint $table) {
            $table->ulid('ID')->primary();
            $table->foreignUlid('employee_id')->constrained('employees')->cascadeOnDelete();

            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();

            $table->string('status');
            $table->text('notes')->nullable();

            $table->unique(['employee_id', 'date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
