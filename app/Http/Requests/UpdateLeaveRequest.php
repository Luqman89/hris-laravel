<?php

namespace App\Http\Requests;

use App\Enums\LeaveType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateLeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $leave = $this->route('leave');
        if ($leave && ! $leave->isPending()) {
            abort(422, 'Pengajuan cuti yang sudah diproses tidak dapat diubah.');
        }
    }
 
    public function rules(): array
    {
        return [
            'type'       => ['sometimes', new Enum(LeaveType::class)],
            'start_date' => ['sometimes', 'date', 'after_or_equal:today'],
            'end_date'   => ['sometimes', 'date', 'after_or_equal:start_date'],
            'reason'     => ['sometimes', 'string', 'max:1000'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }
}
