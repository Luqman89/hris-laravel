<?php

namespace App\Models;

use App\Enums\PayrollDetailType;
use App\Enums\PayrollStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payroll extends Model
{
    use HasUlids;

    protected $fillable = [
        'employee_id', 'month', 'year',
        'base_salary', 'bonus', 'deduction', 'total_salary',
        'working_days', 'present_days', 'absent_days', 'leave_days',
        'overtime_hours', 'status', 'paid_at', 'note',
    ];

    protected $casts = [
        'base_salary'  => 'decimal:2',
        'bonus'        => 'decimal:2',
        'deduction'    => 'decimal:2',
        'total_salary' => 'decimal:2',
        'paid_at'      => 'date',
        'status'       => PayrollStatus::class,
    ];

    protected static function booted(): void
    {
        static::saving(function (Payroll $payroll) {
            $payroll->total_salary = $payroll->base_salary + $payroll->bonus - $payroll->deduction;
        });
    }

    public function employee(): BelongsTo { return $this->belongsTo(Employee::class); }
    public function details(): HasMany { return $this->hasMany(PayrollDetail::class); }
    public function earnings(): HasMany {
        return $this->hasMany(PayrollDetail::class)
            ->whereIn('type', [PayrollDetailType::EARNING->value, PayrollDetailType::ALLOWANCE->value, PayrollDetailType::OVERTIME->value]);
    }
    public function deductions(): HasMany {
        return $this->hasMany(PayrollDetail::class)->where('type', PayrollDetailType::DEDUCTION);
    }

    public function getPeriodLabelAttribute(): string
    {
        $months = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];
        return ($months[$this->month] ?? $this->month) . ' ' . $this->year;
    }

    public function isDraft(): bool { return $this->status === PayrollStatus::DRAFT; }
    public function isPaid(): bool { return $this->status === PayrollStatus::PAID; }
    public function isEditable(): bool { return $this->status->isEditable(); }

    public function markAsPaid(): void {
        $this->update(['status' => PayrollStatus::PAID, 'paid_at' => now()]);
    }

    public function scopeByPeriod($query, int $month, int $year) {
        return $query->where('month', $month)->where('year', $year);
    }
    public function scopePaid($query) { return $query->where('status', PayrollStatus::PAID); }
}