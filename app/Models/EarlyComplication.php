<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarlyComplication extends Model
{
    use HasFactory;
    protected $table = "early_complications";
    protected $fillable = [
        'user_id',  "patient_id", "cardiovascular_complications" , "apoplexy" , "complications_in_urinary_system" , "complications_in_nervous_system" , "complications_in_eyes" , "complications_in_feet"  
    ];  

    public static $rules = [
                
        'patient_id' => 'required|exists:patients,id',
        'cardiovascular_complications' => "in:0,1",
        'apoplexy' => "in:0,1",
        'complications_in_urinary_system' => "in:0,1",
        'complications_in_nervous_system' => "in:0,1",
        'complications_in_eyes' => "in:0,1",
        'complications_in_feet' => "in:0,1",
         
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
