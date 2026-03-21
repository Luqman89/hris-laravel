<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => AttendanceStatus::class,
    ];
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
