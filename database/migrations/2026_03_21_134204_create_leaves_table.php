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
        Schema::create('leaves', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('employee_id')->constrained('employees')->cascadeOnDelete();
 
            $table->enum('type', [
                'annual',       // cuti tahunan
                'sick',         // sakit
                'maternity',    // melahirkan
                'paternity',    // ayah mendampingi
                'emergency',    // darurat keluarga
                'unpaid',       // tanpa gaji
            ]);
 
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days')->default(1); // REVISI: hitung otomatis di model
            $table->text('reason');
            $table->string('attachment')->nullable(); // lampiran surat dokter, dll
 
            // REVISI: status yang lebih jelas
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])
                  ->default('pending');
 
            // REVISI: ganti approve_by jadi lebih eksplisit, nullable karena bisa belum diproses
            $table->foreignUlid('approved_by_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable(); // alasan jika ditolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
