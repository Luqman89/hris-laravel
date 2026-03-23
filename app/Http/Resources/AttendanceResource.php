<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'month'          => $this->month,
            'year'           => $this->year,
            'period_label'   => $this->period_label, // accessor: "Januari 2024"
            'base_salary'    => $this->base_salary,
            'bonus'          => $this->bonus,
            'deduction'      => $this->deduction,
            'total_salary'   => $this->total_salary,
            'working_days'   => $this->working_days,
            'present_days'   => $this->present_days,
            'absent_days'    => $this->absent_days,
            'leave_days'     => $this->leave_days,
            'overtime_hours' => $this->overtime_hours,
            'status'         => $this->status,
            'paid_at'        => $this->paid_at?->format('Y-m-d'),
            'note'           => $this->note,
 
            'employee'       => new EmployeeResource($this->whenLoaded('employee')),
            'details'        => PayrollDetailResource::collection($this->whenLoaded('details')),
 
            'created_at'     => $this->created_at?->toISOString(),
            'updated_at'     => $this->updated_at?->toISOString(),
        ];
    }
}
