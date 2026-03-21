<?php

namespace App\Models;

use App\Enums\LeaveStatus;
use App\Enums\LeaveType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'employee_id',
        'start_date',
        'end_date',
        'type',
        'reason',
        'status',
        'approved_by',
    ];
    protected $casts = [
        'status' => LeaveStatus::class,
        'type'   => LeaveType::class,
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
