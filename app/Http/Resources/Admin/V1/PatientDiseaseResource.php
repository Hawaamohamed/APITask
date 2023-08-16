<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientDiseaseResource extends JsonResource
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
            'cancer' => $this->cancer,
            'cancer_details' => $this->cancer_details,
            'heart_diseases' => $this->heart_diseases,
            'heart_diseases_details' => $this->heart_diseases_details,
            'disability' => $this->disability,
            'disability_details' => $this->disability_details,
            'endocrine' => $this->endocrine,
            'endocrine_details' => $this->endocrine_details, 
            'ophthalmology' => $this->ophthalmology,
            'ophthalmology_details' => $this->ophthalmology_details, 
            'digestive' => $this->digestive,
            'digestive_details' => $this->digestive_details, 
            'psychiatric_mental_disorder' => $this->psychiatric_mental_disorder,
            'psychiatric_mental_disorder_details' => $this->psychiatric_mental_disorder_details, 
            'neurological_diseases' => $this->neurological_diseases,
            'neurological_diseases_details' => $this->neurological_diseases_details, 
            'prosthetics' => $this->prosthetics,
            'prosthetics_details' => $this->prosthetics_details, 
            'urinary_tract' => $this->urinary_tract, 
            'urinary_tract_details' => $this->urinary_tract_details 
        ];
    }
}
