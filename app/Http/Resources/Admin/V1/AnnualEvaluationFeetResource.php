<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnualEvaluationFeetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient' => (new PatientResource($this->patient)),
            'date' => $this->date,
            'time' => $this->time, 
            'skin_color' => $this->skin_color,
            'deformities_of_foot' => $this->deformities_of_foot,
            'dropsy' => $this->dropsy,
            'sensation_of_extremities' => $this->sensation_of_extremities, 
            'pulse_in_dorsal_artery_foot' => $this->pulse_in_dorsal_artery_foot,
            'pulsation_in_bronchial_artery' => $this->pulsation_in_bronchial_artery,
            'amputation' => $this->amputation,
            'evaluation' => $this->evaluation,
            'recommendation' => $this->recommendation,
            'degree_of_danger' => $this->degree_of_danger,
            'transfer_to_hospital' => $this->transfer_to_hospital,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
