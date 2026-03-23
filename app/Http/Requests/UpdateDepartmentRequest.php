<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department')?->id ?? $this->route('department');
 
        return [
            'name'        => ['sometimes', 'string', 'max:100', Rule::unique('departments', 'name')->ignore($departmentId)],
            'code'        => ['nullable', 'string', 'max:10', 'uppercase', Rule::unique('departments', 'code')->ignore($departmentId)],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
}
