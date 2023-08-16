<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedicalExamination; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\MedicalExaminationResource;
use App\Http\Requests\Admin\CreateMedicalExaminationRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class MedicalExaminationAPIController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    public function index(Request $request)
    {

        $query = MedicalExamination::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $medicalExaminations = $query->get();
 
        return response()->json([
            MedicalExaminationResource::collection($medicalExaminations),
            "retrieved medicalExaminations" ]);
    } 
 
    public function store(CreateMedicalExaminationRequest $request)
    {
       try {
            DB::beginTransaction(); 
            // Store Data
            $medicalExamination = MedicalExamination::create([
                "patient_id" => $request->patient_id,
                "date_of_visit" => $request->date_of_visit,
                "time_of_visit" => $request->time_of_visit,
                "type_of_visit" => $request->type_of_visit,
                "weight" => $request->weight,
                "height" => $request->height,
                "body_mass" => $request->body_mass,
                "waistline" => $request->waistline,
                "blood_pressure_measurement" => $request->blood_pressure_measurement, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new MedicalExaminationResource($medicalExamination), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 

}
