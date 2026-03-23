<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
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
            'status'        => 'required|in:active,inactive',
        ];
    }
}
