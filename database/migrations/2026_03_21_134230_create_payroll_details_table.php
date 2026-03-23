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
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('payroll_id')->constrained('payrolls')->cascadeOnDelete();
 
            // REVISI: tipe lebih lengkap
            $table->enum('type', [
                'earning',      // pendapatan (gaji pokok, tunjangan, bonus)
                'deduction',    // potongan (BPJS, pajak, kasbon)
                'overtime',     // lembur
                'allowance',    // tunjangan makan, transport, dll
            ]);
 
            $table->string('description'); // misal: "Tunjangan Makan", "Potongan BPJS Kesehatan"
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_details');
    }
};
