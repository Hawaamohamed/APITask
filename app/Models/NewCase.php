<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewCase extends Model
{
    use HasFactory;
    protected $table = "new_case";
    protected $fillable = [
        'user_id', "name" , "color" , "option"  
    ];  

    public static $rules = [ 
                'name' => 'required|string', 
                'color' => 'required', 
                'option' => 'in:installed,requires_review'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
