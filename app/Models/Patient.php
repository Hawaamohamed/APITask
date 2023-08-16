<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table = "patients";
    protected $fillable = [
        'user_id', "name", "registration_date"  
    ]; 

    public static $rules = [
                
                'name' => 'required|string', 
                'registration_date' => 'required|date' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
