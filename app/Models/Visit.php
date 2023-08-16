<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $table = "visits";
    protected $fillable = [
       "user_id", "patient_id", "date_of_visit" , "time_of_visit" , "type_of_disease" , "type_of_treatment" , "disease_control_status" , "weight" , "height" , "body_mass" , "blood_pressure_measurement" , "degree_of_glucose_measurement" , "fasting_sugar" , "cumulative_sugar" 
    ];
 
     

    public static $rules = [
                
                'patient_id' => 'required|exists:patients,id',  
                'date_of_visit' => 'required|date',  
                'time_of_visit' => 'required',  
                'type_of_disease' => 'required|string',  
                'type_of_treatment' => 'required|string',  
                'disease_control_status' => 'required|in:controlled,non controlled',  
                'weight' => 'required|integer',  
                'height' => 'required|integer',  
                'body_mass' => 'required',
                'blood_pressure_measurement' => "in:low,middle,high,very_high,too_high_see_your_doctor"
                 
    ];

            
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}
