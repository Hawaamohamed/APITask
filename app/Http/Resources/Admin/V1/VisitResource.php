<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class VisitResource extends JsonResource
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
            'type_of_disease' => $this->type_of_disease,
            'type_of_treatment' => $this->type_of_treatment,
            'disease_control_status' => $this->disease_control_status,
            'weight' => $this->weight,
            'height' => $this->height,
            'body_mass' => $this->body_mass, 
            'blood_pressure_measurement' => $this->blood_pressure_measurement,
            'degree_of_glucose_measurement' => $this->degree_of_glucose_measurement,
            'fasting_sugar' => $this->fasting_sugar, 
            'cumulative_sugar' => $this->cumulative_sugar 
        ];
    }
}
