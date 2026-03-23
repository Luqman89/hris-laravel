<?php

namespace App\Enums;

enum AttendanceStatus: string
{
    case PRESENT          = 'present';
    case LATE             = 'late';
    case ABSENT           = 'absent';
    case LEAVE            = 'leave';
    case HOLIDAY          = 'holiday';          // TAMBAH: hari libur nasional
    case WORK_FROM_HOME   = 'work_from_home';   // TAMBAH: WFH
 
    public function label(): string
    {
        return match($this) {
            self::PRESENT        => 'Hadir',
            self::LATE           => 'Terlambat',
            self::ABSENT         => 'Tidak Hadir',
            self::LEAVE          => 'Cuti',
            self::HOLIDAY        => 'Hari Libur',
            self::WORK_FROM_HOME => 'Work From Home',
        };
    }
 
    // TAMBAH: warna badge untuk UI (Tailwind / CSS class)
    public function color(): string
    {
        return match($this) {
            self::PRESENT        => 'green',
            self::LATE           => 'yellow',
            self::ABSENT         => 'red',
            self::LEAVE          => 'blue',
            self::HOLIDAY        => 'purple',
            self::WORK_FROM_HOME => 'cyan',
        };
    }
 
    // TAMBAH: apakah status ini dianggap "hadir" untuk kalkulasi payroll
    public function isPresent(): bool
    {
        return in_array($this, [self::PRESENT, self::LATE, self::WORK_FROM_HOME]);
    }
 
    public static function options(): array
    {
        return collect(self::cases())->map(fn($item) => [
            'value' => $item->value,
            'label' => $item->label(),
        ])->values()->toArray();
    }
}