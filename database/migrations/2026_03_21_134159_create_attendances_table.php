<?php

use App\Enums\AttendanceStatus;
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
            $table->ulid('id')->primary();
            $table->foreignUlid('employee_id')->constrained('employees')->cascadeOnDelete();
 
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
 
            $table->enum('status', array_column(AttendanceStatus::cases(), 'value'))
                  ->default(AttendanceStatus::PRESENT->value);
 
            $table->integer('late_minutes')->default(0);
            $table->integer('overtime_minutes')->default(0);
            $table->ulid('leave_id')->nullable(); // FK constraint di migration 000008
 
            $table->text('note')->nullable();
            $table->timestamps();
 
            $table->unique(['employee_id', 'date']);
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
