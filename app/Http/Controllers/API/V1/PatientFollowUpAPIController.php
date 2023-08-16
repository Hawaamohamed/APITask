<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PatientFollowUp; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\PatientFollowUpResource;
use App\Http\Requests\Admin\CreatePatientFollowUpRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class PatientFollowUpAPIController extends Controller
{
      
    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    
    public function index(Request $request)
    { 
        $query = PatientFollowUp::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 
        $patientFollowUps = $query->get();
 
        return response()->json([PatientFollowUpResource::collection($patientFollowUps), "retrieved patientFollowUps"]);
    } 
    
 
    public function store(CreatePatientFollowUpRequest $request)
    {
       try {
            DB::beginTransaction(); 
            // Store Data
            $PatientFollowUp = PatientFollowUp::create([
                "patient_id" => $request->patient_id,
                "type_of_disease" => $request->type_of_disease,
                "date_of_registration" => $request->date_of_registration,
                "diagnosis_date" => $request->diagnosis_date,
                "blood_type" => $request->blood_type,
                "drug_sensitivity" => $request->drug_sensitivity,
                "drug_sensitivity_details" => $request->drug_sensitivity_details,
                "food_sensitivity" => $request->food_sensitivity,
                "food_sensitivity_details" => $request->food_sensitivity_details,
                  
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new PatientFollowUpResource($PatientFollowUp), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 

}
