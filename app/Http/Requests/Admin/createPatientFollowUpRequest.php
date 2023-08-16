<?php

namespace App\Http\Requests\Admin;

use App\Models\PatientFollowUp;
use Illuminate\Foundation\Http\FormRequest;

class createPatientFollowUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = PatientFollowUp::$rules; 
        return $rules;
    }
}
