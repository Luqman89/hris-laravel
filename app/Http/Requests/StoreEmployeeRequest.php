<?php

namespace App\Http\Requests;

use App\Enums\EmployeeStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
            'user_id'       => 'required|exists:users,id',
            'employee_code' => 'required|string|unique:employees,employee_code',
            'full_name'     => 'required|string|max:255',
            'gender'        => 'nullable|in:male,female',
            'birth_date'    => 'nullable|date',
            'phone'         => 'nullable|string',
            'address'       => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'position_id'   => 'required|exists:positions,id',
            'hire_date'     => 'required|date',
            'status'        => ['required', new Enum(EmployeeStatus::class)],
        ];
    }
}
