<?php

namespace App\Http\Requests;

use App\Enums\AttendanceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateAttendaceRequest extends FormRequest
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
            'check_in'         => ['nullable', 'date_format:H:i:s'],
            'check_out'        => ['nullable', 'date_format:H:i:s', 'after:check_in'],
            'status'           => ['sometimes', new Enum(AttendanceStatus::class)],
            'late_minutes'     => ['nullable', 'integer', 'min:0'],
            'overtime_minutes' => ['nullable', 'integer', 'min:0'],
            'leave_id'         => ['nullable', 'ulid', 'exists:leaves,id'],
            'note'             => ['nullable', 'string', 'max:500'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'check_out.after' => 'Jam keluar harus setelah jam masuk.',
        ];
    }
}
