<?php

namespace App\Http\Requests;

use App\Enums\EmployeeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class StoreEmployeeRequest extends FormRequest
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
        return [
            'user_id'         => ['required', 'ulid', 'exists:users,id', 'unique:employees,user_id'],
            'department_id'   => ['required', 'ulid', 'exists:departments,id'],
            'position_id'     => ['required', 'ulid', 'exists:positions,id'],
            'employee_code'   => ['required', 'string', 'max:50', 'unique:employees,employee_code'],
            'full_name'       => ['required', 'string', 'max:100'],
            'gender'          => ['required', Rule::in(['male', 'female'])],
            'birth_date'      => ['required', 'date', 'before:today'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'address'         => ['nullable', 'string', 'max:500'],
            'hire_date'       => ['required', 'date'],
            'status'          => ['required', new Enum(EmployeeStatus::class)],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'identity_number' => ['nullable', 'string', 'digits:16', 'unique:employees,identity_number'],
            'tax_number'      => ['nullable', 'string', 'max:20', 'unique:employees,tax_number'],
            'bank_name'       => ['nullable', 'string', 'max:50'],
            'bank_account'    => ['nullable', 'string', 'max:30'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'user_id.unique'          => 'User ini sudah terdaftar sebagai karyawan.',
            'employee_code.unique'    => 'Kode karyawan sudah digunakan.',
            'identity_number.digits'  => 'NIK KTP harus 16 digit.',
            'identity_number.unique'  => 'NIK KTP sudah terdaftar.',
            'birth_date.before'       => 'Tanggal lahir harus sebelum hari ini.',
            'photo.max'               => 'Ukuran foto maksimal 2MB.',
        ];
    }
}
