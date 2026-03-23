<?php

namespace App\Enums;

enum EmployeeStatus : string
{
    case ACTIVE      = 'active';
    case INACTIVE    = 'inactive';
    case RESIGNED    = 'resigned';      // TAMBAH: mengundurkan diri
    case TERMINATED  = 'terminated';    // TAMBAH: diberhentikan
    case ON_LEAVE    = 'on_leave';      // TAMBAH: cuti panjang (misal: cuti melahirkan)
 
    public function label(): string
    {
        return match($this) {
            self::ACTIVE     => 'Aktif',
            self::INACTIVE   => 'Tidak Aktif',
            self::RESIGNED   => 'Mengundurkan Diri',
            self::TERMINATED => 'Diberhentikan',
            self::ON_LEAVE   => 'Cuti Panjang',
        };
    }
 
    // TAMBAH: warna badge untuk UI
    public function color(): string
    {
        return match($this) {
            self::ACTIVE     => 'green',
            self::INACTIVE   => 'gray',
            self::RESIGNED   => 'yellow',
            self::TERMINATED => 'red',
            self::ON_LEAVE   => 'blue',
        };
    }
 
    // TAMBAH: apakah karyawan masih terhitung aktif (untuk filter payroll, dll)
    public function isEmployed(): bool
    {
        return in_array($this, [self::ACTIVE, self::ON_LEAVE]);
    }
 
    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->label(),
        ])->values()->toArray();
    }
}
