<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePayrollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'employee_id'    => [
                'required',
                'ulid',
                'exists:employees,id',
                // Pastikan tidak double entry untuk bulan & tahun yang sama
                Rule::unique('payrolls')->where(fn ($q) =>
                    $q->where('month', $this->month)
                      ->where('year', $this->year)
                ),
            ],
            'month'          => ['required', 'integer', 'between:1,12'],
            'year'           => ['required', 'integer', 'min:2000', 'max:' . now()->year],
            'base_salary'    => ['required', 'numeric', 'min:0'],
            'bonus'          => ['nullable', 'numeric', 'min:0'],
            'deduction'      => ['nullable', 'numeric', 'min:0'],
            'working_days'   => ['required', 'integer', 'min:0', 'max:31'],
            'present_days'   => ['required', 'integer', 'min:0', 'max:31'],
            'absent_days'    => ['nullable', 'integer', 'min:0'],
            'leave_days'     => ['nullable', 'integer', 'min:0'],
            'overtime_hours' => ['nullable', 'integer', 'min:0'],
            'note'           => ['nullable', 'string', 'max:1000'],
 
            // Detail komponen gaji (opsional, bisa ditambah setelah payroll dibuat)
            'details'              => ['nullable', 'array'],
            'details.*.type'       => ['required_with:details', 'string', Rule::in(['earning', 'allowance', 'overtime', 'deduction'])],
            'details.*.description' => ['required_with:details', 'string', 'max:100'],
            'details.*.amount'     => ['required_with:details', 'numeric', 'min:0'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'employee_id.unique'   => 'Payroll untuk karyawan ini di bulan dan tahun tersebut sudah ada.',
            'month.between'        => 'Bulan harus antara 1 sampai 12.',
            'year.max'             => 'Tahun tidak boleh melebihi tahun ini.',
            'present_days.max'     => 'Hari hadir tidak boleh melebihi 31 hari.',
        ];
    }
}
