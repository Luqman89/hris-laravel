<?php

namespace App\Enums;

enum LeaveStatus : string
{
    case PENDING   = 'pending';
    case APPROVED  = 'approved';
    case REJECTED  = 'rejected';
    case CANCELLED = 'cancelled';   // TAMBAH: dibatalkan oleh karyawan itu sendiri
 
    public function label(): string
    {
        return match($this) {
            self::PENDING   => 'Menunggu Persetujuan',
            self::APPROVED  => 'Disetujui',
            self::REJECTED  => 'Ditolak',
            self::CANCELLED => 'Dibatalkan',
        };
    }
 
    // TAMBAH: warna badge untuk UI
    public function color(): string
    {
        return match($this) {
            self::PENDING   => 'yellow',
            self::APPROVED  => 'green',
            self::REJECTED  => 'red',
            self::CANCELLED => 'gray',
        };
    }
 
    // TAMBAH: apakah status ini masih bisa diubah/diproses
    public function isEditable(): bool
    {
        return $this === self::PENDING;
    }
 
    // TAMBAH: apakah sudah final (tidak bisa diubah lagi)
    public function isFinal(): bool
    {
        return in_array($this, [self::APPROVED, self::REJECTED, self::CANCELLED]);
    }
 
    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->label(),
        ])->values()->toArray();
    }
}
