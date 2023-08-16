<?php

namespace App\Http\Requests\Admin;

use App\Models\ProcedureForPatient;
use Illuminate\Foundation\Http\FormRequest;

class updateProcedureForPatientRequest extends FormRequest
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
        $rules=  ProcedureForPatient::$rules;
        return $rules;
    }
}
