<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\StaffDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateStaffRequest;
use App\Http\Requests\Admin\UpdateStaffRequest;
use App\Models\Staff;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert; 

class StaffController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_staffs|create_staffs|update_staffs|delete_staffs', ['only' => ['index']]);
        $this->middleware('permission:create_staffs', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_staffs', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_staffs', ['only' => ['delete']]);
    }

 
    public function index(StaffDataTable $staffDataTable)
    {  
        return $staffDataTable->render('admin.staffs.index');
    }

    
    public function create()
    { 
        return view('admin.staffs.create');
    }

     
    public function store(CreateStaffRequest $request)
    {
        try { 
            $request_data = $request->except('_token'); 

            // Store Data
            $staff = Staff::create($request_data);
           
            Alert::success('staffs.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.staffs.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('staffs.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }

     
    public function edit($id)
    {
        /** @var Staff $staff */
        $staff = Staff::find($id); 

        if (empty($staff)) {
            session()->flash('error','not_found');
            return redirect(route('admin.staffs.index'));
        }
        return view('admin.staffs.edit', compact('staff'));
    }

     
    public function update($id, UpdateStaffRequest $request)
    {
        try { 
            /** @var Staff $staff */
            $staff = Staff::find($id);

            if (empty($staff)) {
                session()->flash('error','not_found');
                return redirect(route('admin.staffs.index'));
            }

            $request_data = $request->except('_token');

            $staff->fill($request_data);
            $staff->save();

            Alert::success('staffs.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.staffs.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('staffs.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

     
    public function destroy(Staff $staff)
    { 
        try { 
            // Delete staff
            $staff->delete();

            DB::commit();
            Alert::success('staffs.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.staffs.index');

        } catch (\Throwable $th) {
            Alert::error('staffs.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
