<?php

namespace App\Http\Requests;

use App\Enums\EmployeeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')?->id ?? $this->route('employee');
 
        return [
            'department_id'   => ['sometimes', 'ulid', 'exists:departments,id'],
            'position_id'     => ['sometimes', 'ulid', 'exists:positions,id'],
            'employee_code'   => ['sometimes', 'string', 'max:50', Rule::unique('employees', 'employee_code')->ignore($employeeId)],
            'full_name'       => ['sometimes', 'string', 'max:100'],
            'gender'          => ['sometimes', Rule::in(['male', 'female'])],
            'birth_date'      => ['sometimes', 'date', 'before:today'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'address'         => ['nullable', 'string', 'max:500'],
            'hire_date'       => ['sometimes', 'date'],
            'status'          => ['sometimes', new Enum(EmployeeStatus::class)],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'identity_number' => ['nullable', 'string', 'digits:16', Rule::unique('employees', 'identity_number')->ignore($employeeId)],
            'tax_number'      => ['nullable', 'string', 'max:20', Rule::unique('employees', 'tax_number')->ignore($employeeId)],
            'bank_name'       => ['nullable', 'string', 'max:50'],
            'bank_account'    => ['nullable', 'string', 'max:30'],
            'resign_date'     => ['nullable', 'date', 'after_or_equal:hire_date'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'resign_date.after_or_equal' => 'Tanggal resign tidak boleh sebelum tanggal masuk.',
            'identity_number.digits'     => 'NIK KTP harus 16 digit.',
            'identity_number.unique'     => 'NIK KTP sudah terdaftar.',
        ];
    }
}
