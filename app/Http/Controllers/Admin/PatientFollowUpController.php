<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PatientFollowUpDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreatePatientFollowUpRequest;
use App\Http\Requests\Admin\UpdatePatientFollowUpRequest;
use App\Models\PatientFollowUp;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class PatientFollowUpController extends Controller
{ 
   
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_patientFollowUps|create_patientFollowUps|update_patientFollowUps|delete_patientFollowUps', ['only' => ['index']]);
        $this->middleware('permission:create_patientFollowUps', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_patientFollowUps', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_patientFollowUps', ['only' => ['delete']]);
    }

 
    public function index(PatientFollowUpDataTable $patientFollowUpDataTable)
    { 
        return $patientFollowUpDataTable->render('admin.patientFollowUps.index');
    }

     
    public function create()
    { 
        return view('admin.patientFollowUps.create');
    }

     
    public function store(CreatePatientFollowUpRequest $request)
    {
        try { 
            $request_data = $request->except('_token');

            // Store Data
            $patientFollowUp = PatientFollowUp::create($request_data);
           
            Alert::success('patientFollowUps.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.patientFollowUps.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('patientFollowUps.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }

    
    public function edit($id)
    {
        /** @var PatientFollowUp $patientFollowUp */
        $patientFollowUp = PatientFollowUp::find($id); 

        if (empty($patientFollowUp)) {
            session()->flash('error','not_found');
            return redirect(route('admin.patientFollowUps.index'));
        }
        return view('admin.patientFollowUps.edit', compact('patientFollowUp'));
    }
 
    public function update($id, UpdatePatientFollowUpRequest $request)
    {
        try {
            /** @var PatientFollowUp $patientFollowUp */
            $patientFollowUp = PatientFollowUp::find($id);

            if (empty($patientFollowUp)) {
                session()->flash('error','not_found');
                return redirect(route('admin.patientFollowUps.index'));
            }

            $request_data = $request->except('_token');

            $patientFollowUp->fill($request_data);
            $patientFollowUp->save();

            Alert::success('patientFollowUps.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.patientFollowUps.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('patientFollowUps.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

     
    public function destroy(PatientFollowUp $patientFollowUp)
    { 
        try { 
            // Delete patientFollowUp
            $patientFollowUp->delete();

            DB::commit();
            Alert::success('patientFollowUps.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.patientFollowUps.index');

        } catch (\Throwable $th) {
            Alert::error('patientFollowUps.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
