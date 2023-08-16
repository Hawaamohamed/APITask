<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\GeneticDiseaseDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateGeneticDiseaseRequest;
use App\Http\Requests\Admin\UpdateGeneticDiseaseRequest;
use App\Models\GeneticDisease;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class GeneticDiseaseController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_geneticDiseases|create_geneticDiseases|update_geneticDiseases|delete_geneticDiseases', ['only' => ['index']]);
        $this->middleware('permission:create_geneticDiseases', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_geneticDiseases', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_geneticDiseases', ['only' => ['delete']]);
    }
 

    public function index(GeneticDiseaseDataTable $geneticDiseaseDataTable)
    { 
        return $geneticDiseaseDataTable->render('admin.geneticDiseases.index'); 
    }

     
    public function create()
    { 
        return view('admin.geneticDiseases.create');
    }
 
    public function store(CreateGeneticDiseaseRequest $request)
    {
        try { 
            $request_data = $request->except('_token'); 
            // Store Data
            $geneticDisease = GeneticDisease::create($request_data);
           
            Alert::success('geneticDiseases.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.geneticDiseases.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('geneticDiseases.plural', $exception->getMessage());
            return redirect()->back();
        } 
    }
 
    public function edit($id)
    { 
        $geneticDisease = GeneticDisease::find($id); 

        if (empty($geneticDisease)) {
            session()->flash('error','not_found');
            return redirect(route('admin.geneticDiseases.index'));
        }
        return view('admin.geneticDiseases.edit', compact('geneticDisease'));
    }

     
    public function update($id, UpdateGeneticDiseaseRequest $request)
    {
        try { 
            $geneticDisease = GeneticDisease::find($id);

            if (empty($geneticDisease)) {
                session()->flash('error','not_found');
                return redirect(route('admin.geneticDiseases.index'));
            }

            $request_data = $request->except('_token');

            $geneticDisease->fill($request_data);
            $geneticDisease->save();

            Alert::success('geneticDiseases.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.geneticDiseases.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('geneticDiseases.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
 
    public function destroy(GeneticDisease $geneticDisease)
    { 
        try { 
            // Delete geneticDisease
            $geneticDisease->delete();

            DB::commit();
            Alert::success('geneticDiseases.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.geneticDiseases.index');

        } catch (\Throwable $th) {
            Alert::error('geneticDiseases.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
