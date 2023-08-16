<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attachment; 
use App\Http\Resources\Admin\V1\AttachmentResource; 
use App\Http\Controllers\AppBaseController;
use Response;
use App\Http\Requests\Admin\CreateAttachmentRequest; 

use Illuminate\Support\Facades\DB; 

class AttachmentAPIController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth:api');
    } 

    public function index(Request $request)
    { 
        $query = Attachment::query();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        } 

        $attachments = $query->get();
 
        return response()->json([AttachmentResource::collection($attachments), "retrieved"]);
    } 
 
    public function store(CreateAttachmentRequest $request)
    {
       try {
            DB::beginTransaction();
             
            // Store Data
            $attachment = Attachment::create([
                'file_name' => $request->name,
                'type' => $request->type,
                'staff_salary_id' => $request->staff_salary_id 
            ]);  
            // Commit And Redirect on index with Success Message
            DB::commit();
            return response()->json([new AttachmentResource($attachment), "saved successfully"]);
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            return response()->json([$exception->getMessage()]); 
        } 

    } 

}
