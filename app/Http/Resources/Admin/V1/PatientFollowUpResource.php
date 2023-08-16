<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientFollowUpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient' => (new PatientResource($this->patient)),
            'type_of_disease' => $this->type_of_disease,
            'date_of_registration' => $this->date_of_registration,
            'diagnosis_date' => $this->diagnosis_date,
            'blood_type' => $this->blood_type,
            'drug_sensitivity' => $this->drug_sensitivity,
            'drug_sensitivity_details' => $this->drug_sensitivity_details,
            'food_sensitivity' => $this->food_sensitivity,
            'food_sensitivity_details' => $this->food_sensitivity_details 
        ];
    }
}
