<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\MedicalExaminationDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateMedicalExaminationRequest;
use App\Http\Requests\Admin\UpdateMedicalExaminationRequest;
use App\Models\MedicalExamination;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class MedicalExaminationController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_medicalExaminations|create_medicalExaminations|update_medicalExaminations|delete_medicalExaminations', ['only' => ['index']]);
        $this->middleware('permission:create_medicalExaminations', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_medicalExaminations', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_medicalExaminations', ['only' => ['delete']]);
    }
 
    public function index(MedicalExaminationDataTable $medicalExaminationDataTable)
    {  
        return $medicalExaminationDataTable->render('admin.medicalExaminations.index');
    }
 
    public function create()
    { 
        return view('admin.medicalExaminations.create');
    }

    
    public function store(CreateMedicalExaminationRequest $request)
    {
        try { 
            $request_data = $request->except('_token');
              
            // Store Data
            $medicalExamination = MedicalExamination::create($request_data);
           
            Alert::success('medicalExaminations.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.medicalExaminations.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('medicalExaminations.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }

    
    public function edit($id)
    {
        /** @var MedicalExamination $medicalExamination */
        $medicalExamination = MedicalExamination::find($id); 

        if (empty($medicalExamination)) {
            session()->flash('error','not_found');
            return redirect(route('admin.medicalExaminations.index'));
        }
        return view('admin.medicalExaminations.edit', compact('medicalExamination'));
    }

    
    public function update($id, UpdateMedicalExaminationRequest $request)
    {
        try {
             
            /** @var MedicalExamination $medicalExamination */
            $medicalExamination = MedicalExamination::find($id);

            if (empty($medicalExamination)) {
                session()->flash('error','not_found');
                return redirect(route('admin.medicalExaminations.index'));
            }

            $request_data = $request->except('_token');

            $medicalExamination->fill($request_data);
            $medicalExamination->save();

            Alert::success('medicalExaminations.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.medicalExaminations.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('medicalExaminations.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
 
    public function destroy(MedicalExamination $medicalExamination)
    { 
        try { 
            // Delete medicalExamination
            $medicalExamination->delete();

            DB::commit();
            Alert::success('medicalExaminations.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.medicalExaminations.index');

        } catch (\Throwable $th) {
            Alert::error('medicalExaminations.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
