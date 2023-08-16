<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EarlyComplication; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\EarlyComplicationResource;
use App\Http\Requests\Admin\CreateEarlyComplicationRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class EarlyComplicationAPIController extends Controller
{ 

    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    
    public function index(Request $request)
    {

        $query = EarlyComplication::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $earlyComplications = $query->get();
 
        return response()->json([
            EarlyComplicationResource::collection($earlyComplications), "retrieved earlyComplications.plural"
        ]);
    }  
 
    public function store(CreateEarlyComplicationRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $earlyComplication = EarlyComplication::create([
                "patient_id" => $request->patient_id,
                "cardiovascular_complications" => $request->cardiovascular_complications,
                "apoplexy" => $request->apoplexy,
                "complications_in_urinary_system" => $request->complications_in_urinary_system,
                "complications_in_nervous_system" => $request->complications_in_nervous_system,
                "complications_in_eyes" => $request->complications_in_eyes,
                "complications_in_feet" => $request->complications_in_feet, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new EarlyComplicationResource($earlyComplication), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 

}
