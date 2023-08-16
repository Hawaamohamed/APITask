<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmaceutical extends Model
{
    use HasFactory;
    protected $table = "pharmaceutical";
    protected $fillable = [
        'user_id', "medicament_name", "amount_spent" , "pharmaceutical_form" , "daily_dose" , "last_modified_date" , "notes"
    ]; 

    public static $rules = [ 
        'medicament_name' => 'required|string', 
        'amount_spent' => 'required',
        'pharmaceutical_form' => 'required',
        'daily_dose' => 'required',
        'last_modified_date' => 'date' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
