<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiskFactor; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\RiskFactorResource;
use App\Http\Requests\Admin\CreateRiskFactorRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class RiskFactorAPIController extends Controller
{
      
    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    
    public function index(Request $request)
    { 
        $query = RiskFactor::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $riskFactors = $query->get();
 
        return response()->json([RiskFactorResource::collection($riskFactors), "retrieved riskFactors"]);
    }
 
    
 
    public function store(CreateRiskFactorRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $riskFactor = RiskFactor::create([
                "patient_id" => $request->patient_id,
                "obesity" => $request->obesity,
                "smoking" => $request->smoking,
                "level_cholesterol_in_blood" => $request->level_cholesterol_in_blood,
                "lack_of_physical_activity" => $request->lack_of_physical_activity,
                "family_history_of_vascular_injuries" => $request->family_history_of_vascular_injuries,
                "age" => $request->age,
                "degree_of_risk" => $request->degree_of_risk,
                 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new RiskFactorResource($riskFactor), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 

}
