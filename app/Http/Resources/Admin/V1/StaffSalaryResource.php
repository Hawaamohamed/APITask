<?php

namespace App\Http\Resources\Admin\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffSalaryResource extends JsonResource
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
            'salary_no' => $this->salary_no,
            'logo' => $this->logo,
            'staff' => (new StaffResource($this->staff)),
            'salary_address' => $this->salary_address,
            'sending_date' => $this->sending_date,
            'salary' => $this->salary,
            'extra' => $this->extra,
            'discount' => $this->discount,
            'tax' => $this->tax, 
            'message' => $this->message, 
            'salary_status' => $this->salary_status 
        ];
    }
}
