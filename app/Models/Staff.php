<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $table = "staff";
    protected $fillable = [
        'user_id', "name", "job"  
    ];

     
 
    public static $rules = [ 
                'name' => 'required|string',
                'job' => 'required|in:doctor,employee' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
