<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class LateComplicationResource extends JsonResource
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
            'heart_attack' => $this->heart_attack,
            'congestive_heart_failure' => $this->congestive_heart_failure,
            'apoplexy' => $this->apoplexy,
            'renal_failure_in_final_stages' => $this->renal_failure_in_final_stages,
            'blindness' => $this->blindness,
            'amputation' => $this->amputation 
        ];
    }
}
