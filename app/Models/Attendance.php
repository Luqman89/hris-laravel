<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasUlids;

    protected $fillable = [
        'employee_id', 'date', 'check_in', 'check_out',
        'status', 'late_minutes', 'overtime_minutes', 'leave_id', 'note',
    ];

    protected $casts = [
        'date'   => 'date',
        'status' => AttendanceStatus::class,
    ];

    public function employee(): BelongsTo { return $this->belongsTo(Employee::class); }
    public function leave(): BelongsTo { return $this->belongsTo(Leave::class); }

    public function getWorkingMinutesAttribute(): int
    {
        if (! $this->check_in || ! $this->check_out) return 0;
        return (int) \Carbon\Carbon::parse($this->check_in)
            ->diffInMinutes(\Carbon\Carbon::parse($this->check_out));
    }

    // Gunakan method dari Enum
    public function isPresent(): bool { return $this->status->isPresent(); }
    public function isLate(): bool { return $this->late_minutes > 0; }
    public function hasOvertime(): bool { return $this->overtime_minutes > 0; }

    public function scopeByMonth($query, int $month, int $year) {
        return $query->whereMonth('date', $month)->whereYear('date', $year);
    }
    public function scopePresent($query) {
        return $query->whereIn('status', [
            AttendanceStatus::PRESENT->value,
            AttendanceStatus::LATE->value,
            AttendanceStatus::WORK_FROM_HOME->value,
        ]);
    }
}