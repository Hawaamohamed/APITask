<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pharmaceutical; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\PharmaceuticalResource;
use App\Http\Requests\Admin\CreatePharmaceuticalRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class PharmaceuticalAPIController extends Controller
{
     
    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    

    public function index(Request $request)
    { 
        $query = Pharmaceutical::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $pharmaceuticals = $query->get();
 
        return response()->json([PharmaceuticalResource::collection($pharmaceuticals),"retrieved pharmaceuticals"]);
    } 
 
    public function store(CreatePharmaceuticalRequest $request)
    {
       try {
            DB::beginTransaction(); 
            // Store Data
            $pharmaceutical = Pharmaceutical::create([
                "medicament_name" => $request->medicament_name,
                "amount_spent" => $request->amount_spent,
                "pharmaceutical_form" => $request->pharmaceutical_form,
                "daily_dose" => $request->daily_dose,
                "last_modified_date" => $request->last_modified_date,
                "notes" => $request->notes, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new PharmaceuticalResource($pharmaceutical), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 

}
