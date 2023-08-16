<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\VisitResource;
use App\Http\Requests\Admin\CreateVisitRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class VisitAPIController extends Controller
{ 
    
    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    public function index(Request $request)
    { 
        $query = Visit::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $visits = $query->get();
 
        return response()->json([VisitResource::collection($visits), "retrieved visits"]);
    }  

    public function store(CreateVisitRequest $request)
    {
       try {
            DB::beginTransaction(); 
            // Store Data
            $visit = Visit::create([
                "patient_id" => $request->patient_id,
                "date_of_visit" => $request->date_of_visit,
                "time_of_visit" => $request->time_of_visit,
                "type_of_disease" => $request->type_of_disease,
                "type_of_treatment" => $request->type_of_treatment,
                "disease_control_status" => $request->disease_control_status,
                "weight" => $request->weight,
                "height" => $request->height,
                "body_mass" => $request->body_mass,
                "blood_pressure_measurement" => $request->blood_pressure_measurement,
                "degree_of_glucose_measurement" => $request->degree_of_glucose_measurement,
                "fasting_sugar" => $request->fasting_sugar,
                "cumulative_sugar" => $request->cumulative_sugar, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new VisitResource($visit), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 

}
