<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskFactor extends Model
{
    use HasFactory;
    protected $table = "risk_factors";
    protected $fillable = [
        'user_id', "patient_id", "obesity" , "smoking" , "level_cholesterol_in_blood" , "lack_of_physical_activity" , "family_history_of_vascular_injuries" , "age" , "degree_of_risk"
    ]; 
 
    public static $rules = [
                
                'patient_id' => 'required|exists:patients,id',  
                'smoking' => 'required|in:1,0',
                'age' => 'required',  
                'degree_of_risk' => 'required', 
                'degree_of_risk' => "in:low,middle,high,very_high,too_high_see_your_doctor",
                'obesity' => 'in:1,0',
                'lack_of_physical_activity' => 'in:1,0' 
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
