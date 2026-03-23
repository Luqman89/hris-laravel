<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePayrollRequest extends FormRequest
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
        $payroll = $this->route('payroll');
        if ($payroll && ! $payroll->isEditable()) {
            abort(422, 'Payroll yang sudah diproses atau dibayar tidak dapat diubah.');
        }
    }
 
    public function rules(): array
    {
        return [
            'base_salary'    => ['sometimes', 'numeric', 'min:0'],
            'bonus'          => ['nullable', 'numeric', 'min:0'],
            'deduction'      => ['nullable', 'numeric', 'min:0'],
            'working_days'   => ['sometimes', 'integer', 'min:0', 'max:31'],
            'present_days'   => ['sometimes', 'integer', 'min:0', 'max:31'],
            'absent_days'    => ['nullable', 'integer', 'min:0'],
            'leave_days'     => ['nullable', 'integer', 'min:0'],
            'overtime_hours' => ['nullable', 'integer', 'min:0'],
            'note'           => ['nullable', 'string', 'max:1000'],
        ];
    }
}
