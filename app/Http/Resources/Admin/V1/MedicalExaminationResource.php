<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalExaminationResource extends JsonResource
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
            'date_of_visit' => $this->date_of_visit,
            'time_of_visit' => $this->time_of_visit,
            'type_of_visit' => $this->type_of_visit,
            'weight' => $this->weight,
            'height' => $this->height,
            'body_mass' => $this->body_mass,
            'waistline' => $this->waistline,
            'blood_pressure_measurement' => $this->blood_pressure_measurement, 
        ];
    }
}
