<?php

namespace App\Models;

use App\Enums\EmployeeStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
     use HasUlids, SoftDeletes;
 
    protected $fillable = [
        'user_id', 'department_id', 'position_id',
        'employee_code', 'full_name', 'gender',
        'birth_date', 'phone', 'address', 'hire_date',
        'status', 'photo', 'identity_number', 'tax_number',
        'bank_name', 'bank_account', 'resign_date',
    ];
 
    protected $casts = [
        'birth_date'  => 'date',
        'hire_date'   => 'date',
        'resign_date' => 'date',
        'status'      => EmployeeStatus::class,
    ];
 
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function department(): BelongsTo { return $this->belongsTo(Department::class); }
    public function position(): BelongsTo { return $this->belongsTo(Position::class); }
    public function leaves(): HasMany { return $this->hasMany(Leave::class); }
    public function attendances(): HasMany { return $this->hasMany(Attendance::class); }
    public function payrolls(): HasMany { return $this->hasMany(Payroll::class); }
    public function approvedLeaves(): HasMany { return $this->hasMany(Leave::class, 'approved_by_id'); }
 
    public function getAgeAttribute(): int { return $this->birth_date->age; }
    public function getYearsOfServiceAttribute(): int { return $this->hire_date->diffInYears(now()); }
    public function isActive(): bool { return $this->status->isEmployed(); }
 
    public function scopeActive($query) { return $query->where('status', EmployeeStatus::ACTIVE); }
    public function scopeEmployed($query) {
        return $query->whereIn('status', [EmployeeStatus::ACTIVE->value, EmployeeStatus::ON_LEAVE->value]);
    }
    public function scopeByDepartment($query, string $departmentId) {
        return $query->where('department_id', $departmentId);
    }
}
