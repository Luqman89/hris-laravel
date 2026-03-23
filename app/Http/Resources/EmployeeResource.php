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
             'id'             => $this->id,
            'employee_code'  => $this->employee_code,
            'full_name'      => $this->full_name,
            'gender'         => $this->gender,
            'birth_date'     => $this->birth_date?->format('Y-m-d'),
            'age'            => $this->age, // accessor
            'phone'          => $this->phone,
            'address'        => $this->address,
            'hire_date'      => $this->hire_date?->format('Y-m-d'),
            'years_of_service' => $this->years_of_service, // accessor
            'resign_date'    => $this->resign_date?->format('Y-m-d'),
            'status'         => $this->status,
            'photo'          => $this->photo ? asset('storage/' . $this->photo) : null,
            'identity_number' => $this->identity_number,
            'tax_number'     => $this->tax_number,
            'bank_name'      => $this->bank_name,
            'bank_account'   => $this->bank_account,
 
            // Relasi (hanya dimuat jika sudah di-load)
            // 'user'           => new UserResource($this->whenLoaded('user')),
            'department'     => new DepartmentResource($this->whenLoaded('department')),
            'position'       => new PositionResource($this->whenLoaded('position')),
 
            'created_at'     => $this->created_at?->toISOString(),
            'updated_at'     => $this->updated_at?->toISOString(),
        ];
    }
}
