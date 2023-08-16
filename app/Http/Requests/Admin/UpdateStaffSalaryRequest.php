<?php

namespace App\Http\Requests\Admin;

use App\Models\StaffSalary;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffSalaryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
      $rules=  StaffSalary::$rules;
        return $rules;
    }
}
