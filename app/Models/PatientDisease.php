<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDisease extends Model
{
    use HasFactory;
    protected $table = "patient_diseases";
    protected $fillable = [
        'user_id', "patient_id", "cancer" , "cancer_details" , "heart_diseases" , "heart_diseases_details" , "disability" , "disability_details" , "endocrine" , "endocrine_details" , "ophthalmology" , "ophthalmology_details" , "digestive" , "digestive_details" , "psychiatric_mental_disorder"  , "psychiatric_mental_disorder_details" , "neurological_diseases" , "neurological_diseases_details" , "prosthetics"  , "prosthetics_details" , "urinary_tract" , "urinary_tract_details" 
    ]; 

    public static $rules = [
                
                'patient_id' => 'required|exists:patients,id', 
                'cancer' => 'required|in:0,1',
                'heart_diseases' => 'required|in:0,1', 
                'disability' => 'required|in:0,1', 
                'endocrine' => 'required|in:0,1',
                'ophthalmology' => 'required|in:0,1',
                'digestive' => 'required|in:0,1',
                'psychiatric_mental_disorder' => 'required|in:0,1',
                'neurological_diseases' => 'required|in:0,1',
                'prosthetics' => 'required|in:0,1',
                'urinary_tract' => 'required|in:0,1' 
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
