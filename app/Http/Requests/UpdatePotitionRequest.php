<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePotitionRequest extends FormRequest
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
            'department_id' => ['sometimes', 'ulid', 'exists:departments,id'],
            'name'          => ['sometimes', 'string', 'max:100'],
            'base_salary'   => ['sometimes', 'numeric', 'min:0'],
            'level'         => ['nullable', 'string', Rule::in(['staff', 'supervisor', 'manager', 'director'])],
            'description'   => ['nullable', 'string', 'max:500'],
        ];
    }
}
