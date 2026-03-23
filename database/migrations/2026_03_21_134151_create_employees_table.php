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
            $table->foreignUlid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUlid('department_id')->constrained('departments')->restrictOnDelete();
            $table->foreignUlid('position_id')->constrained('positions')->restrictOnDelete();
 
            $table->string('employee_code')->unique(); // NIK karyawan, misal: EMP-2024-001
            $table->string('full_name');
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('hire_date');
 
            // REVISI: status enum yang lebih lengkap
            $table->enum('status', ['active', 'inactive', 'resigned', 'terminated', 'on_leave'])
                  ->default('active');
 
            // REVISI: tambah kolom penting untuk HRIS
            $table->string('photo')->nullable();           // path foto karyawan
            $table->string('identity_number')->nullable(); // NIK KTP
            $table->string('tax_number')->nullable();      // NPWP
            $table->string('bank_name')->nullable();       // nama bank
            $table->string('bank_account')->nullable();    // nomor rekening
            $table->date('resign_date')->nullable();       // tanggal resign jika status resigned/terminated
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
