<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PharmaceuticalResource extends JsonResource
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
            'medicament_name' => $this->medicament_name,
            'amount_spent' => $this->amount_spent,
            'pharmaceutical_form' => $this->pharmaceutical_form,
            'daily_dose' => $this->daily_dose,
            'last_modified_date' => $this->last_modified_date,
            'notes' => $this->notes, 
        ];
    }
}
