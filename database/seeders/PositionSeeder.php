<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            // ── Human Resources ──────────────────────────────
            [
                'department' => 'HRD',
                'name'       => 'HR Manager',
                'level'      => 'manager',
                'base_salary' => 12_000_000,
            ],
            [
                'department' => 'HRD',
                'name'       => 'HR Supervisor',
                'level'      => 'supervisor',
                'base_salary' => 8_000_000,
            ],
            [
                'department' => 'HRD',
                'name'       => 'HR Staff',
                'level'      => 'staff',
                'base_salary' => 5_000_000,
            ],
            [
                'department' => 'HRD',
                'name'       => 'Recruitment Staff',
                'level'      => 'staff',
                'base_salary' => 5_000_000,
            ],
 
            // ── Information Technology ────────────────────────
            [
                'department' => 'IT',
                'name'       => 'IT Manager',
                'level'      => 'manager',
                'base_salary' => 15_000_000,
            ],
            [
                'department' => 'IT',
                'name'       => 'IT Supervisor',
                'level'      => 'supervisor',
                'base_salary' => 10_000_000,
            ],
            [
                'department' => 'IT',
                'name'       => 'Software Engineer',
                'level'      => 'staff',
                'base_salary' => 8_000_000,
            ],
            [
                'department' => 'IT',
                'name'       => 'UI/UX Designer',
                'level'      => 'staff',
                'base_salary' => 7_000_000,
            ],
            [
                'department' => 'IT',
                'name'       => 'IT Support',
                'level'      => 'staff',
                'base_salary' => 5_000_000,
            ],
 
            // ── Finance & Accounting ──────────────────────────
            [
                'department' => 'FIN',
                'name'       => 'Finance Manager',
                'level'      => 'manager',
                'base_salary' => 13_000_000,
            ],
            [
                'department' => 'FIN',
                'name'       => 'Finance Supervisor',
                'level'      => 'supervisor',
                'base_salary' => 9_000_000,
            ],
            [
                'department' => 'FIN',
                'name'       => 'Accountant',
                'level'      => 'staff',
                'base_salary' => 6_000_000,
            ],
            [
                'department' => 'FIN',
                'name'       => 'Finance Staff',
                'level'      => 'staff',
                'base_salary' => 5_500_000,
            ],
 
            // ── Marketing ─────────────────────────────────────
            [
                'department' => 'MKT',
                'name'       => 'Marketing Manager',
                'level'      => 'manager',
                'base_salary' => 12_000_000,
            ],
            [
                'department' => 'MKT',
                'name'       => 'Marketing Supervisor',
                'level'      => 'supervisor',
                'base_salary' => 8_000_000,
            ],
            [
                'department' => 'MKT',
                'name'       => 'Marketing Staff',
                'level'      => 'staff',
                'base_salary' => 5_500_000,
            ],
            [
                'department' => 'MKT',
                'name'       => 'Content Creator',
                'level'      => 'staff',
                'base_salary' => 5_000_000,
            ],
 
            // ── Operations ────────────────────────────────────
            [
                'department' => 'OPS',
                'name'       => 'Operations Manager',
                'level'      => 'manager',
                'base_salary' => 12_000_000,
            ],
            [
                'department' => 'OPS',
                'name'       => 'Operations Supervisor',
                'level'      => 'supervisor',
                'base_salary' => 8_000_000,
            ],
            [
                'department' => 'OPS',
                'name'       => 'Operations Staff',
                'level'      => 'staff',
                'base_salary' => 5_000_000,
            ],
 
            // ── Sales ─────────────────────────────────────────
            [
                'department' => 'SLS',
                'name'       => 'Sales Manager',
                'level'      => 'manager',
                'base_salary' => 12_000_000,
            ],
            [
                'department' => 'SLS',
                'name'       => 'Sales Supervisor',
                'level'      => 'supervisor',
                'base_salary' => 8_000_000,
            ],
            [
                'department' => 'SLS',
                'name'       => 'Sales Executive',
                'level'      => 'staff',
                'base_salary' => 5_500_000,
            ],
        ];
 
        // Cache departments agar tidak query berulang
        $departmentCache = Department::pluck('id', 'code');
 
        foreach ($positions as $position) {
            $departmentId = $departmentCache[$position['department']] ?? null;
 
            if (! $departmentId) {
                $this->command->warn("Department {$position['department']} not found, skipping {$position['name']}.");
                continue;
            }
 
            Position::firstOrCreate(
                [
                    'department_id' => $departmentId,
                    'name'          => $position['name'],
                ],
                [
                    'level'       => $position['level'],
                    'base_salary' => $position['base_salary'],
                ]
            );
        }
    }
}
