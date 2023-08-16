<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffSalary; 
use App\Models\Attachment; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Resources\Admin\V1\StaffSalaryResource;
use App\Http\Requests\Admin\CreateStaffSalaryRequest;  
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;

class StaffSalaryAPIController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    public function index(Request $request)
    { 
        $query = StaffSalary::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $staffSalarys = $query->get();
 
        return response()->json([StaffSalaryResource::collection($staffSalarys), "retrieved staffSalarys"]);
    }
 
    
 
    public function store(CreateStaffSalaryRequest $request)
    {
       try {
            DB::beginTransaction(); 
             

            // Store Data
            $staffSalary = StaffSalary::create([
                "salary_no" => $request->salary_no, 
                "staff_id" => $request->staff_id,
                "logo" => config('app.logo'),
                "salary_address" => $request->salary_address,
                "sending_date" => $request->sending_date,
                "salary" => $request->salary,
                "extra" => $request->extra,
                "discount" => $request->discount,
                "tax" => $request->tax,
                "message" => $request->message,
                "salary_status" => $request->salary_status, 
                'user_id' => Auth::guard('api')->user()->id
            ]);  
            
            //upload multiple attachments
            if($request->hasFile('attachments'))
            {
                $attachments = $request->file('attachments');
                foreach($attachments as $attachment)
                {  
                    $path = $attachment->store('public/uploads');  
                    //store Attachment file into  db
                    Attachment::create([
                        'file_name' => $path,
                        'staff_salary_id' => $staffSalary->id
                    ]); 
                }
            }

            if(isset($request->signed)){
                
                $folderPath = public_path('uploads/'); 

                $image_parts = explode(";base64,", $request->signed); 
                $image_type_aux = explode("image/", $image_parts[0]); 

                $image_type = $image_type_aux[1]; 
                $image_base64 = base64_decode($image_parts[1]); 
                $file = $folderPath . uniqid() . '.'.$image_type; 
                file_put_contents($file, $image_base64); 
            }
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new StaffSalaryResource($staffSalary), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]);
             
        } 

    }
 
    
}
