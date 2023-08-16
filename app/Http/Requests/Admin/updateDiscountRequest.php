<?php

namespace App\Http\Requests\Admin;

use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;

class updateDiscountRequest extends FormRequest
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
        $rules=  Discount::$rules;
        return $rules;
    }
}
