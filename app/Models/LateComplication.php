<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LateComplication extends Model
{
    use HasFactory; 
    protected $table = "late_complications";
    protected $fillable = [
        'user_id',  "patient_id", "heart_attack" , "congestive_heart_failure" , "apoplexy" , "renal_failure_in_final_stages" , "blindness" , "amputation"  
    ]; 

    public static $rules = [
                
                'patient_id' => 'required|exists:patients,id',
                'heart_attack' => 'in:1,0',
                'congestive_heart_failure' => 'in:1,0',
                'apoplexy' => 'in:1,0',
                'renal_failure_in_final_stages' => 'in:1,0',
                'blindness' => 'in:1,0',
                'amputation' => 'in:1,0',
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
