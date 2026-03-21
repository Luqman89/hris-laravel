<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasUlids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'base_salary',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
