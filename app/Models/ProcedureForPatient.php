<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureForPatient extends Model
{
    use HasFactory;
    protected $table = "procedure_for_patient";
    protected $fillable = [
        'user_id', "name", "procedures" 
    ]; 

    public static $rules = [ 
        'name' => 'required|string',
        'procedures' => 'required|in:consultation,operationsdetection,follow-up,Payment received,reimbursement_request,login,logout' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}
