<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PatientDiseaseDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreatePatientDiseaseRequest;
use App\Http\Requests\Admin\UpdatePatientDiseaseRequest;
use App\Models\PatientDisease;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class PatientDiseaseController extends Controller
{
   
   
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_patientDiseases|create_patientDiseases|update_patientDiseases|delete_patientDiseases', ['only' => ['index']]);
        $this->middleware('permission:create_patientDiseases', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_patientDiseases', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_patientDiseases', ['only' => ['delete']]);
    }

 
    public function index(PatientDiseaseDataTable $patientDiseaseDataTable)
    { 
        return $patientDiseaseDataTable->render('admin.patientDiseases.index');
    }

     
    public function create()
    {

        return view('admin.patientDiseases.create');
    }

     
    public function store(CreatePatientDiseaseRequest $request)
    {
        try {
            
            $request_data = $request->except('_token');
              
            // Store Data
            $patientDisease = PatientDisease::create($request_data);
           
            Alert::success('patientDiseases.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.patientDiseases.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('patientDiseases.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }

     
    public function edit($id)
    {
        /** @var PatientDisease $patientDisease */
        $patientDisease = PatientDisease::find($id); 

        if (empty($patientDisease)) {
            session()->flash('error','not_found');
            return redirect(route('admin.patientDiseases.index'));
        }
        return view('admin.patientDiseases.edit', compact('patientDisease'));
    }
 

    public function update($id, UpdatePatientDiseaseRequest $request)
    {
        try {
            
            /** @var PatientDisease $patientDisease */
            $patientDisease = PatientDisease::find($id);

            if (empty($patientDisease)) {
                session()->flash('error','not_found');
                return redirect(route('admin.patientDiseases.index'));
            }

            $request_data = $request->except('_token');

            $patientDisease->fill($request_data);
            $patientDisease->save();

            Alert::success('patientDiseases.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.patientDiseases.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('patientDiseases.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
 
    public function destroy(PatientDisease $patientDisease)
    { 
        try { 
            // Delete patientDisease
            $patientDisease->delete();

            DB::commit();
            Alert::success('patientDiseases.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.patientDiseases.index');

        } catch (\Throwable $th) {
            Alert::error('patientDiseases.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
