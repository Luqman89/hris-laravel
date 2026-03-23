<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ApproveLeaveRequest extends FormRequest
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
            abort(422, 'Hanya pengajuan cuti dengan status pending yang dapat diproses.');
        }
    }
 
    public function rules(): array
    {
        return [
            'approved_by_id'   => ['required', 'ulid', 'exists:employees,id'],
            // rejection_reason wajib diisi hanya jika action = reject
            'rejection_reason' => [
                $this->input('action') === 'reject' ? 'required' : 'nullable',
                'string',
                'max:500',
            ],
            'action' => ['required', \Illuminate\Validation\Rule::in(['approve', 'reject'])],
        ];
    }
 
    public function messages(): array
    {
        return [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
            'action.in'                 => 'Aksi harus berupa approve atau reject.',
        ];
    }
}
