<?php

namespace App\Models;

use App\Enums\LeaveStatus;
use App\Enums\LeaveType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
 use HasUlids, SoftDeletes;
 
    protected $fillable = [
        'employee_id', 'type', 'start_date', 'end_date',
        'total_days', 'reason', 'attachment', 'status',
        'approved_by_id', 'approved_at', 'rejection_reason',
    ];
 
    protected $casts = [
        'start_date'  => 'date',
        'end_date'    => 'date',
        'approved_at' => 'datetime',
        'type'        => LeaveType::class,
        'status'      => LeaveStatus::class,
    ];
 
    protected static function booted(): void
    {
        static::saving(function (Leave $leave) {
            $leave->total_days = $leave->calculateWorkingDays();
        });
    }
 
    public function employee(): BelongsTo { return $this->belongsTo(Employee::class); }
    public function approvedBy(): BelongsTo { return $this->belongsTo(Employee::class, 'approved_by_id'); }
 
    public function calculateWorkingDays(): int
    {
        $start = $this->start_date->copy();
        $end   = $this->end_date->copy();
        $days  = 0;
        while ($start->lte($end)) {
            if (! $start->isWeekend()) $days++;
            $start->addDay();
        }
        return $days;
    }
 
    // Sekarang bisa akses method dari Enum
    public function isPending(): bool { return $this->status === LeaveStatus::PENDING; }
    public function isApproved(): bool { return $this->status === LeaveStatus::APPROVED; }
    public function isFinal(): bool { return $this->status->isFinal(); }
    public function deductsAnnualQuota(): bool { return $this->type->deductsAnnualQuota(); }
 
    public function approve(Employee $approver): void
    {
        $this->update([
            'status'         => LeaveStatus::APPROVED,
            'approved_by_id' => $approver->id,
            'approved_at'    => now(),
        ]);
    }
 
    public function reject(Employee $approver, string $reason): void
    {
        $this->update([
            'status'           => LeaveStatus::REJECTED,
            'approved_by_id'   => $approver->id,
            'approved_at'      => now(),
            'rejection_reason' => $reason,
        ]);
    }
 
    public function scopePending($query) { return $query->where('status', LeaveStatus::PENDING); }
    public function scopeApproved($query) { return $query->where('status', LeaveStatus::APPROVED); }
}
