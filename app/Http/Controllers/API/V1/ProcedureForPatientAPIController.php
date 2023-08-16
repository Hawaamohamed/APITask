<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcedureForPatient; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\ProcedureForPatientResource;
use App\Http\Requests\Admin\CreateProcedureForPatientRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class ProcedureForPatientAPIController extends Controller
{ 

    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    
    public function index(Request $request)
    { 
        $query = ProcedureForPatient::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $procedureForPatients = $query->get();
 
        return response()->json([
          ProcedureForPatientResource::collection($procedureForPatients),"retrieved procedureForPatients"]);
    } 
 
    public function store(CreateProcedureForPatientRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $procedureForPatient = ProcedureForPatient::create([
                'name' => $request->name,
                'procedures' => $request->procedures,
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new ProcedureForPatientResource($procedureForPatient), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 
    
}
