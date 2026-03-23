<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePotitionRequest extends FormRequest
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
            'department_id' => ['required', 'ulid', 'exists:departments,id'],
            'name'          => ['required', 'string', 'max:100'],
            'base_salary'   => ['required', 'numeric', 'min:0'],
            'level'         => ['nullable', 'string', Rule::in(['staff', 'supervisor', 'manager', 'director'])],
            'description'   => ['nullable', 'string', 'max:500'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'level.in' => 'Level jabatan harus salah satu dari: staff, supervisor, manager, director.',
        ];
    }
}
