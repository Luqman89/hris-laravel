<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'name'        => ['required', 'string', 'max:100', 'unique:departments,name'],
            'code'        => ['nullable', 'string', 'max:10', 'uppercase', 'unique:departments,code'],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'name.unique' => 'Nama departemen sudah digunakan.',
            'code.unique' => 'Kode departemen sudah digunakan.',
        ];
    }
}
