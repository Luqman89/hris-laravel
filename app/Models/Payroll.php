<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'base_salary',
        'bonus',
        'deduction',
        'total_salary',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function details()
    {
        return $this->hasMany(PayrollDetail::class);
    }
}
