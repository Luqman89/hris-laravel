<?php

namespace App\Enums;

enum LeaveType : string
{
 case ANNUAL     = 'annual';
    case SICK       = 'sick';
    case PERMISSION = 'permission';
    case MATERNITY  = 'maternity';  // TAMBAH: cuti melahirkan
    case PATERNITY  = 'paternity';  // TAMBAH: cuti ayah mendampingi
    case EMERGENCY  = 'emergency';  // TAMBAH: darurat keluarga (menikah, keluarga meninggal)
    case UNPAID     = 'unpaid';     // TAMBAH: cuti tanpa gaji
 
    public function label(): string
    {
        return match($this) {
            self::ANNUAL     => 'Cuti Tahunan',
            self::SICK       => 'Cuti Sakit',
            self::PERMISSION => 'Izin',
            self::MATERNITY  => 'Cuti Melahirkan',
            self::PATERNITY  => 'Cuti Ayah',
            self::EMERGENCY  => 'Darurat Keluarga',
            self::UNPAID     => 'Cuti Tanpa Gaji',
        };
    }
 
    // TAMBAH: apakah tipe cuti ini memotong kuota cuti tahunan
    public function deductsAnnualQuota(): bool
    {
        return $this === self::ANNUAL;
    }
 
    // TAMBAH: apakah tipe cuti ini tetap dibayar
    public function isPaid(): bool
    {
        return ! in_array($this, [self::UNPAID]);
    }
 
    // TAMBAH: maksimal hari default per tipe (bisa dikustomisasi sesuai kebijakan perusahaan)
    public function maxDays(): ?int
    {
        return match($this) {
            self::ANNUAL     => 12,     // 12 hari per tahun
            self::SICK       => 14,     // maksimal 14 hari
            self::PERMISSION => 3,      // maksimal 3 hari
            self::MATERNITY  => 90,     // 3 bulan
            self::PATERNITY  => 3,      // 3 hari
            self::EMERGENCY  => 5,      // 5 hari
            self::UNPAID     => null,   // tidak ada batas
        };
    }
 
    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value'    => $item->value,
            'label'    => $item->label(),
            'max_days' => $item->maxDays(),
            'is_paid'  => $item->isPaid(),
        ])->values()->toArray();
    }
}
