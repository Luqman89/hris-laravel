<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'employee_code' => $this->employee_code,
            'full_name'     => $this->full_name,
            'status'        => $this->status->value,
            'status_label'  => $this->status->label(),

            'department' => [
                'id'   => $this->department->id,
                'name' => $this->department->name,
            ],

            'position' => [
                'id'   => $this->position->id,
                'name' => $this->position->name,
            ],
        ];
    }
}
