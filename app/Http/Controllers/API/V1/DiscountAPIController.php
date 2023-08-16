<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\DiscountResource;
use App\Http\Requests\Admin\CreateDiscountRequest;  
use Illuminate\Support\Facades\DB; 

class DiscountAPIController extends Controller
{  

    public function __construct(){
        
        $this->middleware('auth:api');
    } 
    
    public function index(Request $request)
    {
        $query = Discount::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }
 
        $discounts = $query->get();
 
        return response()->json([DiscountResource::collection($discounts),"retrieved discounts"]);
    } 
 
    public function store(CreateDiscountRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $discount = Discount::create([
                "staff_id" => $request->staff_id,
                "discount" => $request->discount,
                "month" => $request->month,
                "year" => $request->year,
                   
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new DiscountResource($discount), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 
}
