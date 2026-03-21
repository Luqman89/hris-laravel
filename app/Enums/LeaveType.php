<?php

namespace App\Enums;

enum LeaveType : string
{
    case ANNUAL    = 'annual';
    case SICK      = 'sick';
    case PERMISSION = 'permission';

    public function label(): string
    {
        return match($this) {
            self::ANNUAL     => 'Cuti Tahunan',
            self::SICK       => 'Cuti Sakit',
            self::PERMISSION => 'Izin',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->label(),
        ])->values()->toArray();
    }
}
