<?php

namespace App\Http\Requests\Admin;

use App\Models\Pharmaceutical;
use Illuminate\Foundation\Http\FormRequest;

class createPharmaceuticalRequest extends FormRequest
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
        $rules = Pharmaceutical::$rules; 
        return $rules;
    }
}
