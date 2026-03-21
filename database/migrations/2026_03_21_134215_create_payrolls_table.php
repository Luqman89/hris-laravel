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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('employee_id')->constrained('employees')->cascadeOnDelete();

            $table->integer('month');
            $table->integer('year');

            $table->decimal('base_salary', 12, 2);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('deduction', 12, 2)->default(0);
            $table->decimal('total_salary', 12, 2);

            $table->unique(['employee_id', 'month', 'year']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
