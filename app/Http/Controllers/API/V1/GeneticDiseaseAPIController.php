<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneticDisease;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\GeneticDiseaseResource;
use App\Http\Requests\Admin\createGeneticDiseaseRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class GeneticDiseaseAPIController extends Controller
{  

    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    
    public function index(Request $request)
    { 
        $query = GeneticDisease::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $geneticDiseases = $query->get();
 
        return response()->json([GeneticDiseaseResource::collection($geneticDiseases), 
        "retrieved geneticDiseases"]);
    } 

 
    public function store(CreateGeneticDiseaseRequest $request)
    {
       try {
            DB::beginTransaction(); 
            // Store Data
            $geneticDisease = GeneticDisease::create([
                "patient_id" => $request->patient_id,
                "hypertension" => $request->hypertension,
                "diabetes" => $request->diabetes,
                "cancer" => $request->cancer,
                "psychological_disorders" => $request->psychological_disorders,
                "family_genetic_diseases" => $request->family_genetic_diseases, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new GeneticDiseaseResource($geneticDisease), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 

}
