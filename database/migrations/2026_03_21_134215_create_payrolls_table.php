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
            // REVISI KRITIS: tambah relasi ke employee — payroll harus tahu untuk siapa
            $table->foreignUlid('employee_id')->constrained('employees')->cascadeOnDelete();
 
            $table->tinyInteger('month'); // 1-12
            $table->smallInteger('year');
 
            // REVISI: simpan base_salary snapshot saat payroll dibuat
            // agar tidak berubah jika posisi/gaji pokok karyawan diupdate di kemudian hari
            $table->decimal('base_salary', 15, 2)->default(0);
            $table->decimal('bonus', 15, 2)->default(0);
            $table->decimal('deduction', 15, 2)->default(0);
            $table->decimal('total_salary', 15, 2)->default(0); // base + bonus - deduction
 
            // REVISI: tambah info kehadiran yang mempengaruhi gaji
            $table->integer('working_days')->default(0);   // hari kerja di bulan tsb
            $table->integer('present_days')->default(0);   // hari masuk
            $table->integer('absent_days')->default(0);    // hari tidak masuk
            $table->integer('leave_days')->default(0);     // hari cuti
            $table->integer('overtime_hours')->default(0); // total jam lembur
 
            // REVISI: status payroll
            $table->enum('status', ['draft', 'processed', 'paid'])->default('draft');
            $table->date('paid_at')->nullable(); // tanggal transfer gaji
            $table->text('note')->nullable();
 
            // REVISI: unique agar tidak double-entry payroll per karyawan per bulan
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
