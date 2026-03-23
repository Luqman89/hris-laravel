<?php

namespace App\Enums;

enum PayrollStatus: string
{
     case DRAFT     = 'draft';       // baru dibuat, belum diproses
    case PROCESSED = 'processed';   // sudah dihitung, menunggu pembayaran
    case PAID      = 'paid';        // sudah ditransfer
 
    public function label(): string
    {
        return match($this) {
            self::DRAFT     => 'Draft',
            self::PROCESSED => 'Diproses',
            self::PAID      => 'Sudah Dibayar',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::DRAFT     => 'gray',
            self::PROCESSED => 'yellow',
            self::PAID      => 'green',
        };
    }
 
    public function isEditable(): bool
    {
        return $this === self::DRAFT;
    }
 
    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->label(),
        ])->values()->toArray();
    }
}
