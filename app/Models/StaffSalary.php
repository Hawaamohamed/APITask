<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalary extends Model
{
    use HasFactory;
    protected $table = "staff_salaries";
    protected $fillable = [
        'user_id', "salary_no", "logo" , "staff_id" , "salary_address" , "sending_date" , "salary" , "extra" , "discount" , "tax" , "message" , "salary_status"
    ];
  
    public static $rules = [ 
        'staff_id' => 'required|exists:staff,id',  
        'salary' => 'required',
        'sending_date' => 'required|date',
        'salary_status' => 'required|in:in_progress,close,disapproval' 
    ];  

    public function Staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
            
}
