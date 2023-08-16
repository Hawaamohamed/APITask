<?php

namespace App\Http\Controllers\API\V1; 

use App\Http\Resources\Admin\V1\AnnualEvaluationFeetResource;
use App\Models\AnnualEvaluationFeet;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Requests\Admin\CreateAnnualEvaluationFeetRequest;
use App\Http\Requests\Admin\UpdateAnnualEvaluationFeetRequest;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 

class AnnualEvaluationFeetAPIController extends AppBaseController
{   
    
    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    public function index(Request $request)
    { 
        $query = AnnualEvaluationFeet::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 
        
        $annualEvaluationFeets = $query->get();
 
        return response()->json([AnnualEvaluationFeetResource::collection($annualEvaluationFeets), "retrieved annualEvaluationFeets"]);
    } 
 
    public function store(CreateAnnualEvaluationFeetRequest $request)
    {
       try {
            DB::beginTransaction(); 
            // Store Data
            $annualEvaluationFeet = AnnualEvaluationFeet::create([
                "patient_id" => $request->patient_id,
                "date" => $request->date,
                "time" => $request->time,
                "skin_color" => $request->skin_color,
                "deformities_of_foot" => $request->deformities_of_foot,
                "dropsy" => $request->dropsy,
                "sensation_of_extremities" => $request->sensation_of_extremities,
                "pulse_in_dorsal_artery_foot" => $request->pulse_in_dorsal_artery_foot,
                "pulsation_in_bronchial_artery" => $request->pulsation_in_bronchial_artery,
                "sores" => $request->sores,
                "amputation" => $request->amputation,
                "evaluation" => $request->evaluation,
                "recommendation" => $request->recommendation,
                "degree_of_danger" => $request->degree_of_danger,
                "transfer_to_hospital" => $request->transfer_to_hospital,
                "notes" => $request->notes, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new AnnualEvaluationFeetResource($annualEvaluationFeet), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]); 
        } 

    } 

}
