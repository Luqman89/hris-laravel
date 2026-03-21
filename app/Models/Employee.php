<?php

namespace App\Models;

use App\Enums\EmployeeStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'employee_code',
        'full_name',
        'gender',
        'birth_date',
        'phone',
        'address',
        'department_id',
        'position_id',
        'hire_date',
        'status',
    ];

    protected $casts = [
        'status' => EmployeeStatus::class,
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
