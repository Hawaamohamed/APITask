<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PatientDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreatePatientRequest;
use App\Http\Requests\Admin\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class PatientController extends Controller
{
   
   
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_patients|create_patients|update_patients|delete_patients', ['only' => ['index']]);
        $this->middleware('permission:create_patients', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_patients', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_patients', ['only' => ['delete']]);
    }

 
    public function index(PatientDataTable $patientDataTable)
    { 
        return $patientDataTable->render('admin.patients.index');
    }
 
    public function create()
    {

        return view('admin.patients.create');
    }
 
    public function store(CreatePatientRequest $request)
    {
        try { 
            $request_data = $request->except('_token');
              
            // Store Data
            $patient = Patient::create($request_data);
           
            Alert::success('patients.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.patients.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('patients.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }

     
    public function edit($id)
    {
        /** @var Patient $patient */
        $patient = Patient::find($id); 

        if (empty($patient)) {
            session()->flash('error','not_found');
            return redirect(route('admin.patients.index'));
        }
        return view('admin.patients.edit', compact('patient'));
    }
 

    public function update($id, UpdatePatientRequest $request)
    {
        try { 
            $patient = Patient::find($id);

            if (empty($patient)) {
                session()->flash('error','not_found');
                return redirect(route('admin.patients.index'));
            }

            $request_data = $request->except('_token');

            $patient->fill($request_data);
            $patient->save();

            Alert::success('patients.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.patients.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('patients.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

     
    public function destroy(Patient $patient)
    { 
        try { 
            // Delete patient
            $patient->delete();

            DB::commit();
            Alert::success('patients.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.patients.index');

        } catch (\Throwable $th) {
            Alert::error('patients.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
