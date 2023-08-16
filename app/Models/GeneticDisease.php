<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneticDisease extends Model
{
    use HasFactory;
    protected $table = "genetic_disease";
    protected $fillable = [
        'user_id',  "patient_id", "hypertension" , "diabetes" , "cancer" , "psychological_disorders" , "family_genetic_diseases"  
    ]; 

    public static $rules = [
                
                'patient_id' => 'required|exists:patients,id', 
                'hypertension' => 'required|in:0,1', 
                'diabetes' => 'required|in:0,1', 
                'cancer' => 'required|in:0,1', 
                'psychological_disorders' => 'required|in:0,1', 
                'family_genetic_diseases' => 'required|in:0,1' 

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
