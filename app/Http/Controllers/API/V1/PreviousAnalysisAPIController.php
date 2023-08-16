<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PreviousAnalysis; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\PreviousAnalysisResource;
use App\Http\Requests\Admin\CreatePreviousAnalysisRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class PreviousAnalysisAPIController extends Controller
{ 

    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    
    public function index(Request $request)
    { 
        $query = PreviousAnalysis::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $previousAnalysiss = $query->get();
  
        return response()->json([
           PreviousAnalysisResource::collection($previousAnalysiss), "retrieved previousAnalysiss"
        ]);
    }
 
    
 
    public function store(CreatePreviousAnalysisRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $previousAnalysis = PreviousAnalysis::create([
                "patient_id" => $request->patient_id,
                "fasting_sugar" => $request->fasting_sugar,
                "date" => $request->date,
                "glucose_meter" => $request->glucose_meter,
                "cumulative_sugar" => $request->cumulative_sugar,
                "result_of_cumulative_sugar" => $request->result_of_cumulative_sugar,
                "sugar_two_hours_after_eating" => $request->sugar_two_hours_after_eating,
                "random_sugar" => $request->random_sugar, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new PreviousAnalysisResource($previousAnalysis), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 

}
