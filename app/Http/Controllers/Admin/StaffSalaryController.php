<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\StaffSalaryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateStaffSalaryRequest;
use App\Http\Requests\Admin\UpdateStaffSalaryRequest;
use App\Models\StaffSalary;
use App\Models\Attachment;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use RealRashid\SweetAlert\Facades\Alert;

class StaffSalaryController extends Controller
{ 
    
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_staffSalarys|create_staffSalarys|update_staffSalarys|delete_staffSalarys', ['only' => ['index']]);
        $this->middleware('permission:create_staffSalarys', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_staffSalarys', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_staffSalarys', ['only' => ['delete']]);
    }
 
    public function index(StaffSalaryDataTable $staffSalaryDataTable)
    {
        return $staffSalaryDataTable->render('admin.staffSalarys.index');
    }

     
    public function create()
    {
        return view('admin.staffSalarys.create');
    }

     
    public function store(CreateStaffSalaryRequest $request)
    {
        try { 
            $request_data = $request->except('_token');
              
            // Store Data
            $staffSalary = StaffSalary::create($request_data);
           //upload multiple attachments
           if($request->hasFile('attachments'))
           {
               $attachments = $request->file('attachments');
               foreach($attachments as $attachment)
               { 
                  $path = uploadImage($attachment, 'uploads'); 
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

            Alert::success('staffSalarys.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.staffSalarys.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('staffSalarys.plural', $exception->getMessage());
            return redirect()->back();
        }


    }

    /**
     * Edit Investor
     * @param $id
     * @return Factory|View|RedirectResponse|Redirector
     */
    public function edit($id)
    {
        /** @var StaffSalary $staffSalary */
        $staffSalary = StaffSalary::find($id);


        if (empty($staffSalary)) {
            session()->flash('error','not_found');
            return redirect(route('admin.staffSalarys.index'));
        }
        return view('admin.staffSalarys.edit', compact('staffSalary'));
    }

    /**
     * Update Investor
     * @param $id
     * @param UpdateStaffSalaryRequest $request
     * @return RedirectResponse
     *
     */
    public function update($id, UpdateStaffSalaryRequest $request)
    {
        try { 
            /** @var StaffSalary $staffSalary */
            $staffSalary = StaffSalary::find($id);

            if (empty($staffSalary)) {
                session()->flash('error','not_found');
                return redirect(route('admin.staffSalarys.index'));
            }

            $request_data = $request->except('_token');

            $staffSalary->fill($request_data);
            $staffSalary->save();

            Alert::success('staffSalarys.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.staffSalarys.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('staffSalarys.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

    /**
     * Delete StaffSalary
     * @param StaffSalary $StaffSalary
     * @return RedirectResponse
     */
    public function destroy(StaffSalary $staffSalary)
    { 
        try { 
            // Delete staffSalary
            $staffSalary->delete();

            DB::commit();
            Alert::success('staffSalarys.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.staffSalarys.index');

        } catch (\Throwable $th) {
            Alert::error('staffSalarys.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
