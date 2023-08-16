<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\PatientResource;
use App\Http\Requests\Admin\CreatePatientRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class PatientAPIController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    public function index(Request $request)
    {

        $query = Patient::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $patients = $query->get();
 
        return response()->json([PatientResource::collection($patients), "retrieved patients"]);
    }  
 
    public function store(CreatePatientRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $patient = Patient::create([
                'name' => $request->name,
                'registration_date' => $request->registration_date, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new PatientResource($patient), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 

}
