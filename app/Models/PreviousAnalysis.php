<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousAnalysis extends Model
{
    use HasFactory;
    protected $table = "previous_analysis";
    protected $fillable = [
        'user_id', "patient_id", "fasting_sugar" , "date" , "glucose_meter" , "cumulative_sugar" , "result_of_cumulative_sugar" , "sugar_two_hours_after_eating" , "random_sugar" 
    ]; 
 
    public static $rules = [ 
        'patient_id' => 'required|exists:patients,id',
        'fasting_sugar' => 'in:disciplined,not disciplined',
        'cumulative_sugar' => "in:low,middle,high,very_high,too_high_see_your_doctor",
        'date' => 'date'
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
