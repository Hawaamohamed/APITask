<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = "discounts";
    protected $fillable = [
        "staff_id", "discount" , "month" , "year"  
    ]; 

    public static $rules = [
                'month' => 'required|integer',
                'year' => 'required|integer',
                'staff_id' => 'required|exists:staff,id',  
    ];
   
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
    
}
