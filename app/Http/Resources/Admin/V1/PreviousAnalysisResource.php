<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class PreviousAnalysisResource extends JsonResource
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
            'fasting_sugar' => $this->fasting_sugar,
            'date' => $this->date,
            'glucose_meter' => $this->glucose_meter,
            'cumulative_sugar' => $this->cumulative_sugar,
            'result_of_cumulative_sugar' => $this->result_of_cumulative_sugar,
            'sugar_two_hours_after_eating' => $this->sugar_two_hours_after_eating,
            'random_sugar' => $this->random_sugar 
        ];
    }
}
