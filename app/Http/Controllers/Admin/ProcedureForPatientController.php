<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ProcedureForPatientDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateProcedureForPatientRequest;
use App\Http\Requests\Admin\UpdateProcedureForPatientRequest;
use App\Models\ProcedureForPatient;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class ProcedureForPatientController extends Controller
{ 
   
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_procedureForPatients|create_procedureForPatients|update_procedureForPatients|delete_procedureForPatients', ['only' => ['index']]);
        $this->middleware('permission:create_procedureForPatients', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_procedureForPatients', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_procedureForPatients', ['only' => ['delete']]);
    }


     
    public function index(ProcedureForPatientDataTable $procedureForPatientDataTable)
    {   
        return $procedureForPatientDataTable->render('admin.procedureForPatients.index');
    }

    
    public function create()
    { 
        return view('admin.procedureForPatients.create');
    }

     
    public function store(CreateProcedureForPatientRequest $request)
    {
        try { 
            $request_data = $request->except('_token'); 

            // Store Data
            $procedureForPatient = ProcedureForPatient::create($request_data);
           
            Alert::success('procedureForPatients.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.procedureForPatients.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('procedureForPatients.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }

     
    public function edit($id)
    {
        /** @var ProcedureForPatient $procedureForPatient */
        $procedureForPatient = ProcedureForPatient::find($id); 

        if (empty($procedureForPatient)) {
            session()->flash('error','not_found');
            return redirect(route('admin.procedureForPatients.index'));
        }
        return view('admin.procedureForPatients.edit', compact('procedureForPatient'));
    }

     
    public function update($id, UpdateProcedureForPatientRequest $request)
    {
        try { 
            /** @var ProcedureForPatient $procedureForPatient */
            $procedureForPatient = ProcedureForPatient::find($id);

            if (empty($procedureForPatient)) {
                session()->flash('error','not_found');
                return redirect(route('admin.procedureForPatients.index'));
            }

            $request_data = $request->except('_token');

            $procedureForPatient->fill($request_data);
            $procedureForPatient->save();

            Alert::success('procedureForPatients.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.procedureForPatients.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('procedureForPatients.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
 

    public function destroy(ProcedureForPatient $procedureForPatient)
    { 
        try { 
            // Delete procedureForPatient
            $procedureForPatient->delete();

            DB::commit();
            Alert::success('procedureForPatients.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.procedureForPatients.index');

        } catch (\Throwable $th) {
            Alert::error('procedureForPatients.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
