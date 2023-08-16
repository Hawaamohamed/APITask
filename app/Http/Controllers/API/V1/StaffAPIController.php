<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Staff; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\StaffResource;
use App\Http\Requests\Admin\CreateStaffRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class StaffAPIController extends Controller
{ 

    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    
    public function index(Request $request)
    { 
        $query = Staff::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $staffs = $query->get();
 
        return response()->json([StaffResource::collection($staffs), "retrieved staffs"]);
    } 
 
    public function store(CreateStaffRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $staff = Staff::create([
                'name' => $request->name,
                'job' => $request->job, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new StaffResource($staff), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 
    
}
