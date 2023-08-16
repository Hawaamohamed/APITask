<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class EarlyComplicationResource extends JsonResource
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
            'cardiovascular_complications' => $this->cardiovascular_complications,
            'apoplexy' => $this->apoplexy,
            'complications_in_urinary_system' => $this->complications_in_urinary_system,
            'complications_in_nervous_system' => $this->complications_in_nervous_system,
            'complications_in_eyes' => $this->complications_in_eyes,
            'complications_in_feet' => $this->complications_in_feet, 
        ];
    }
}
