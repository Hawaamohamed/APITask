<?php

namespace App\Http\Requests\Admin;

use App\Models\EarlyComplication;
use Illuminate\Foundation\Http\FormRequest;

class createEarlyComplicationRequest extends FormRequest
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
        $rules = EarlyComplication::$rules; 
        return $rules;
    }
}
