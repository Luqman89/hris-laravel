<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'payroll_id',
        'type',
        'description',
        'amount',
    ];

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
