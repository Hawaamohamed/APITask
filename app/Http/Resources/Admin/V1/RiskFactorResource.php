<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RiskFactorResource extends JsonResource
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
            'obesity' => $this->obesity,
            'smoking' => $this->smoking,
            'level_cholesterol_in_blood' => $this->level_cholesterol_in_blood,
            'lack_of_physical_activity' => $this->lack_of_physical_activity,
            'family_history_of_vascular_injuries' => $this->family_history_of_vascular_injuries,
            'age' => $this->age,
            'degree_of_risk' => $this->degree_of_risk
        ];
    }
}
