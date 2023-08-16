<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class GeneticDiseaseResource extends JsonResource
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
            'hypertension' => $this->hypertension,
            'diabetes' => $this->diabetes,
            'cancer' => $this->cancer,
            'psychological_disorders' => $this->psychological_disorders,
            'family_genetic_diseases' => $this->family_genetic_diseases 
        ];
    }
}
