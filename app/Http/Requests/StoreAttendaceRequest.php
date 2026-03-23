<?php

namespace App\Http\Requests;

use App\Enums\AttendanceStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;

class StoreAttendaceRequest extends FormRequest
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
            'employee_id'      => [
                'required',
                'ulid',
                'exists:employees,id',
                // Pastikan belum ada record absensi di tanggal yang sama
                Rule::unique('attendances')->where(fn ($q) =>
                    $q->where('date', $this->date)
                ),
            ],
            'date'             => ['required', 'date', 'before_or_equal:today'],
            'check_in'         => ['nullable', 'date_format:H:i:s'],
            'check_out'        => ['nullable', 'date_format:H:i:s', 'after:check_in'],
            'status'           => ['required', new Enum(AttendanceStatus::class)],
            'late_minutes'     => ['nullable', 'integer', 'min:0'],
            'overtime_minutes' => ['nullable', 'integer', 'min:0'],
            'leave_id'         => [
                // Wajib diisi jika status = leave
                $this->input('status') === AttendanceStatus::LEAVE->value ? 'required' : 'nullable',
                'ulid',
                'exists:leaves,id',
            ],
            'note'             => ['nullable', 'string', 'max:500'],
        ];
    }
 
    public function messages(): array
    {
        return [
            'employee_id.unique'   => 'Data absensi karyawan ini untuk tanggal tersebut sudah ada.',
            'date.before_or_equal' => 'Tanggal absensi tidak boleh di masa depan.',
            'check_out.after'      => 'Jam keluar harus setelah jam masuk.',
            'leave_id.required'    => 'ID cuti wajib diisi jika status absensi adalah cuti.',
        ];
    }
}
