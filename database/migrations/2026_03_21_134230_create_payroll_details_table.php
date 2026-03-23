<?php

use App\Enums\PayrollDetailType;
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
 
            $table->enum('type', array_column(PayrollDetailType::cases(), 'value'));
 
            $table->string('description');
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
