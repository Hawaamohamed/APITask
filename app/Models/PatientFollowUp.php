<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientFollowUp extends Model
{
    use HasFactory;
    protected $table = "patient_follow_up";
    protected $fillable = [
        'user_id', "patient_id", "type_of_disease" , "date_of_registration" , "diagnosis_date" , "blood_type" , "drug_sensitivity" , "drug_sensitivity_details" , "food_sensitivity" , "food_sensitivity_details" 
    ]; 
  
    public static $rules = [ 
        'patient_id' => 'required|exists:patients,id',  
        'type_of_disease' => 'required',
        'blood_type'=>'in:A+,O+,B+,AB+,A-,O-,B-,AB-',
        'drug_sensitivity' => "in:0,1",
        'food_sensitivity' => "in:0,1",
        'date_of_registration' => 'date',
        'diagnosis_date' => 'date'
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
