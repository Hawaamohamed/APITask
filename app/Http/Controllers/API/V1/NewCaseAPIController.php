<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewCase; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\NewCaseResource;
use App\Http\Requests\Admin\CreateNewCaseRequest;
use App\Http\Requests\Admin\UpdateNewCaseRequest;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\Comparator\Factory;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\DB; 

class NewCaseAPIController extends Controller
{ 

    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    
    public function index(Request $request)
    { 
        $query = NewCase::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $newCases = $query->get();
 
        return response()->json([NewCaseResource::collection($newCases), "retrieved newCases"]);
    }
 
    public function store(CreateNewCaseRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $newCase = NewCase::create([
                'name' => $request->name,
                'color' => $request->color,
                'option' => $request->option,
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new NewCaseResource($newCase), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 
}
