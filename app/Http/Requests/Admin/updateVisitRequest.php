<?php

namespace App\Http\Requests\Admin;
use App\Models\Visit;

use Illuminate\Foundation\Http\FormRequest;

class updateVisitRequest extends FormRequest
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
        $rules=  Visit::$rules;
        return $rules;
    }
}
