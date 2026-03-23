<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'type'             => $this->type,
            'start_date'       => $this->start_date?->format('Y-m-d'),
            'end_date'         => $this->end_date?->format('Y-m-d'),
            'total_days'       => $this->total_days,
            'reason'           => $this->reason,
            'attachment'       => $this->attachment ? asset('storage/' . $this->attachment) : null,
            'status'           => $this->status,
            'approved_at'      => $this->approved_at?->toISOString(),
            'rejection_reason' => $this->rejection_reason,
 
            'employee'         => new EmployeeResource($this->whenLoaded('employee')),
            'approved_by'      => new EmployeeResource($this->whenLoaded('approvedBy')),
 
            'created_at'       => $this->created_at?->toISOString(),
            'updated_at'       => $this->updated_at?->toISOString(),
        ];
    }
}
