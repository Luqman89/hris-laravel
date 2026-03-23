<?php

namespace App\Models;

use App\Enums\PayrollDetailType;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollDetail extends Model
{
    use HasUlids;

    protected $fillable = ['payroll_id', 'type', 'description', 'amount'];

    protected $casts = [
        'amount' => 'decimal:2',
        'type'   => PayrollDetailType::class,
    ];

    public function payroll(): BelongsTo { return $this->belongsTo(Payroll::class); }

    public function isAdditive(): bool { return $this->type->isAdditive(); }
}