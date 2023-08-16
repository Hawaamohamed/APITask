<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LateComplication; 
use App\Http\Controllers\AppBaseController;
use Response; 
use App\Http\Resources\Admin\V1\LateComplicationResource;
use App\Http\Requests\Admin\CreateLateComplicationRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class LateComplicationAPIController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    public function index(Request $request)
    { 
        $query = LateComplication::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $lateComplications = $query->get();
 
        return response()->json([LateComplicationResource::collection($lateComplications), "retrieved"]);
    }
     
    public function store(CreateLateComplicationRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $lateComplication = LateComplication::create([
                "patient_id" => $request->patient_id,
                "heart_attack" => $request->heart_attack,
                "congestive_heart_failure" => $request->congestive_heart_failure,
                "apoplexy" => $request->apoplexy,
                "renal_failure_in_final_stages" => $request->renal_failure_in_final_stages,
                "blindness" => $request->blindness,
                "amputation" => $request->amputation, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new LateComplicationResource($lateComplication), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 
}
