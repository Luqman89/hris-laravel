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
 
            // REVISI: status enum yang lebih detail
            $table->enum('status', [
                'present',      // hadir
                'absent',       // tidak hadir tanpa keterangan
                'late',         // terlambat
                'leave',        // cuti (linked to leaves)
                'holiday',      // hari libur
                'work_from_home', // WFH
            ])->default('present');
 
            // REVISI: tambah kolom penting
            $table->integer('late_minutes')->default(0);    // berapa menit terlambat
            $table->integer('overtime_minutes')->default(0); // berapa menit lembur
            $table->foreignUlid('leave_id')->nullable()->constrained('leaves')->nullOnDelete(); // relasi ke cuti jika status = leave
            $table->text('note')->nullable();
 
            $table->timestamps();
 
            // REVISI: unique constraint agar 1 karyawan hanya 1 record per hari
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
