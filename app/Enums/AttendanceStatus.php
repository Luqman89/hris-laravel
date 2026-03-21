<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case PRESENT = 'present';
    case LATE    = 'late';
    case ABSENT  = 'absent';
    case LEAVE   = 'leave';

    public function label(): string
    {
        return match($this) {
            self::PRESENT => 'Hadir',
            self::LATE    => 'Terlambat',
            self::ABSENT  => 'Tidak Hadir',
            self::LEAVE   => 'Cuti',
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