<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PatientDisease; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\PatientDiseaseResource;
use App\Http\Requests\Admin\CreatePatientDiseaseRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class PatientDiseaseAPIController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    public function index(Request $request)
    { 
        $query = PatientDisease::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 
        $patientDiseases = $query->get();
 
        return response()->json([PatientDiseaseResource::collection($patientDiseases), "retrieved patientDiseases"]);
    } 
 
    public function store(CreatePatientDiseaseRequest $request)
    {
       try {
            DB::beginTransaction(); 
            // Store Data
            $patientDisease = PatientDisease::create([
                "patient_id" => $request->patient_id,
                "cancer" => $request->cancer,
                "cancer_details" => $request->cancer_details,
                "heart_diseases" => $request->heart_diseases,
                "heart_diseases_details" => $request->heart_diseases_details,
                "disability" => $request->disability,
                "disability_details" => $request->disability_details,
                "endocrine" => $request->endocrine,
                "endocrine_details" => $request->endocrine_details,
                "ophthalmology" => $request->ophthalmology,
                "ophthalmology_details" => $request->ophthalmology_details,
                "digestive" => $request->digestive,
                "digestive_details" => $request->digestive_details,
                "psychiatric_mental_disorder" => $request->psychiatric_mental_disorder,
                "psychiatric_mental_disorder_details" => $request->psychiatric_mental_disorder_details,
                "neurological_diseases" => $request->neurological_diseases,
                "neurological_diseases_details" => $request->neurological_diseases_details,
                "prosthetics" => $request->prosthetics,
                "prosthetics_details" => $request->prosthetics_details,
                "urinary_tract" => $request->urinary_tract,
                "urinary_tract_details" => $request->urinary_tract_details, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new PatientDiseaseResource($patientDisease), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 
 
}
