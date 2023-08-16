<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalExamination extends Model
{
    use HasFactory;
    protected $table = "medical_examinations";
    protected $fillable = [
        'user_id',  "patient_id", "date_of_visit" , "time_of_visit" , "type_of_visit" , "weight" , "height" , "body_mass" , "waistline" , "blood_pressure_measurement" 
    ]; 

    public static $rules = [
                
                'patient_id' => 'required|exists:patients,id', 
                'date_of_visit' => 'required|date',
                'time_of_visit' => 'required',
                'type_of_visit' => 'required|in:follow-up,periodic',
                'weight' => 'required|integer',
                'height' => 'required|integer',
                'body_mass' => 'required',
                'waistline' => 'in:normal,Abnormal',
                'blood_pressure_measurement' => "in:low,middle,high,very_high,too_high_see_your_doctor"
            ];

            
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
