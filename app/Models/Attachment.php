<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory; 
    protected $table = "attachments";
    protected $fillable = [
        "file_name" , "type", "staff_salary_id"  
    ]; 

    public static $rules = [
        'file_name' => "required|string",
        'staff_salary_id' => 'required|exists:staff_salaries,id',  
    ];
   
    public function staff_salary()
    {
        return $this->belongsTo(StaffSalary::class, 'staff_salary_id');
    }
}
