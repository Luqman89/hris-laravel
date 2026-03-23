<?php

namespace App\Http\Requests;

use App\Enums\LeaveType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
class StoreLeaveRequest extends FormRequest
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
            'employee_id' => ['required', 'ulid', 'exists:employees,id'],
            'type'        => ['required', new Enum(LeaveType::class)],
            // 'start_date'  => ['required', 'date', 'after_or_equal:today'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'reason'      => ['required', 'string', 'max:1000'],
            'attachment'  => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // 5MB
 
            // Pastikan tidak ada cuti lain yang overlap di rentang tanggal yang sama
            'start_date'  => [
                'required',
                'date',
                'after_or_equal:today',
                function ($attribute, $value, $fail) {
                    $overlap = \App\Models\Leave::where('employee_id', $this->employee_id)
                        ->whereIn('status', ['pending', 'approved'])
                        ->where(function ($q) {
                            $q->whereBetween('start_date', [$this->start_date, $this->end_date])
                              ->orWhereBetween('end_date', [$this->start_date, $this->end_date])
                              ->orWhere(function ($q) {
                                  $q->where('start_date', '<=', $this->start_date)
                                    ->where('end_date', '>=', $this->end_date);
                              });
                        })->exists();
 
                    if ($overlap) {
                        $fail('Karyawan sudah memiliki pengajuan cuti di rentang tanggal tersebut.');
                    }
                },
            ],
        ];
    }
 
    public function messages(): array
    {
        return [
            'start_date.after_or_equal' => 'Tanggal mulai cuti tidak boleh di masa lalu.',
            'end_date.after_or_equal'   => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'attachment.max'            => 'Ukuran lampiran maksimal 5MB.',
            'attachment.mimes'          => 'Lampiran harus berupa file JPG, PNG, atau PDF.',
        ];
    }
}
