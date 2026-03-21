<?php

namespace App\Enums;

enum EmployeeStatus : string
{
    case ACTIVE   = 'active';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE    => 'Aktif',
            self::INACTIVE  => 'Tidak Aktif',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->label()
        ])->values()->toArray();
    }
}
