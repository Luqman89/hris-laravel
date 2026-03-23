<?php

use App\Enums\EmployeeStatus;
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
 
            $table->string('employee_code')->unique();
            $table->string('full_name');
            $table->enum('gender', ['male', 'female']); // tidak perlu Enum class, hanya 2 nilai tetap
            $table->date('birth_date');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('hire_date');
 
            $table->enum('status', array_column(EmployeeStatus::cases(), 'value'))
                  ->default(EmployeeStatus::ACTIVE->value);
 
            $table->string('photo')->nullable();
            $table->string('identity_number')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->date('resign_date')->nullable();
 
            $table->timestamps();
            $table->softDeletes();
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
