<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name'        => 'Human Resources',
                'code'        => 'HRD',
                'description' => 'Mengelola sumber daya manusia, rekrutmen, dan pengembangan karyawan.',
            ],
            [
                'name'        => 'Information Technology',
                'code'        => 'IT',
                'description' => 'Mengelola infrastruktur teknologi dan pengembangan sistem.',
            ],
            [
                'name'        => 'Finance & Accounting',
                'code'        => 'FIN',
                'description' => 'Mengelola keuangan, akuntansi, dan pelaporan keuangan perusahaan.',
            ],
            [
                'name'        => 'Marketing',
                'code'        => 'MKT',
                'description' => 'Mengelola strategi pemasaran dan hubungan pelanggan.',
            ],
            [
                'name'        => 'Operations',
                'code'        => 'OPS',
                'description' => 'Mengelola operasional dan proses bisnis sehari-hari.',
            ],
            [
                'name'        => 'Sales',
                'code'        => 'SLS',
                'description' => 'Mengelola penjualan dan pencapaian target revenue.',
            ],
        ];
 
        foreach ($departments as $department) {
            Department::firstOrCreate(
                ['code' => $department['code']],
                $department
            );
        }
    }
}
