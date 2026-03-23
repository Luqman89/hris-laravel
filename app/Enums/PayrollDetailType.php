<?php

namespace App\Enums;

enum PayrollDetailType: string
{
    case EARNING   = 'earning';     // pendapatan utama (gaji pokok, dll)
    case ALLOWANCE = 'allowance';   // tunjangan (makan, transport, jabatan)
    case OVERTIME  = 'overtime';    // uang lembur
    case DEDUCTION = 'deduction';   // potongan (BPJS, pajak PPh21, kasbon)
 
    public function label(): string
    {
        return match($this) {
            self::EARNING   => 'Pendapatan',
            self::ALLOWANCE => 'Tunjangan',
            self::OVERTIME  => 'Lembur',
            self::DEDUCTION => 'Potongan',
        };
    }
 
    public function color(): string
    {
        return match($this) {
            self::EARNING   => 'green',
            self::ALLOWANCE => 'blue',
            self::OVERTIME  => 'cyan',
            self::DEDUCTION => 'red',
        };
    }
 
    // Apakah tipe ini menambah total (earning) atau mengurangi (deduction)
    public function isAdditive(): bool
    {
        return in_array($this, [self::EARNING, self::ALLOWANCE, self::OVERTIME]);
    }
 
    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->label(),
        ])->values()->toArray();
    }
}
