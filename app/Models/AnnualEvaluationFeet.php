<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnualEvaluationFeet extends Model
{
    use HasFactory;
    protected $table = "annual_evaluation_feet";
    protected $fillable = [
      'user_id',  "patient_id", "date" , "time" , "skin_color" , "deformities_of_foot" , "dropsy" , "sensation_of_extremities" , "pulse_in_dorsal_artery_foot" , "pulsation_in_bronchial_artery" , "sores" , "amputation" , "evaluation" , "recommendation" , "degree_of_danger" , "transfer_to_hospital" , "notes" 
    ]; 

    public static $rules = [ 
        'patient_id' => 'required|exists:patients,id',
        'skin_color' => "in:normal,Abnormal,see doctor",
        'deformities_of_foot' => "in:normal,Abnormal,see doctor",
        'dropsy' => "in:normal,Abnormal,see doctor",
        'sensation_of_extremities' => "in:normal,Abnormal,see doctor",
        'pulse_in_dorsal_artery_foot' => "in:normal,Abnormal,see doctor",
        'pulsation_in_bronchial_artery' => "in:normal,Abnormal,see doctor",
        'sores' => "in:normal,Abnormal,see doctor",
        'amputation' => "in:normal,Abnormal,see doctor",
        'evaluation' => "in:normal,Abnormal,see doctor" 
    
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
 