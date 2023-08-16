<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PreviousAnalysisDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreatePreviousAnalysisRequest;
use App\Http\Requests\Admin\UpdatePreviousAnalysisRequest;
use App\Models\PreviousAnalysis;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class PreviousAnalysisController extends Controller
{ 
   
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_previousAnalysiss|create_previousAnalysiss|update_previousAnalysiss|delete_previousAnalysiss', ['only' => ['index']]);
        $this->middleware('permission:create_previousAnalysiss', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_previousAnalysiss', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_previousAnalysiss', ['only' => ['delete']]);
    }

 
    public function index(PreviousAnalysisDataTable $previousAnalysisDataTable)
    { 
        return $previousAnalysisDataTable->render('admin.previousAnalysiss.index'); 
    }
 
    public function create()
    { 
        return view('admin.previousAnalysiss.create');
    }

     
    public function store(CreatePreviousAnalysisRequest $request)
    {
        try { 
            $request_data = $request->except('_token');
              
            // Store Data
            $previousAnalysis = PreviousAnalysis::create($request_data);
           
            Alert::success('previousAnalysiss.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.previousAnalysiss.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('previousAnalysiss.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }

     
    public function edit($id)
    {
        /** @var PreviousAnalysis $previousAnalysis */
        $previousAnalysis = PreviousAnalysis::find($id); 

        if (empty($previousAnalysis)) {
            session()->flash('error','not_found');
            return redirect(route('admin.previousAnalysiss.index'));
        }
        return view('admin.previousAnalysiss.edit', compact('previousAnalysis'));
    }

     
    public function update($id, UpdatePreviousAnalysisRequest $request)
    {
        try { 
            /** @var PreviousAnalysis $previousAnalysis */
            $previousAnalysis = PreviousAnalysis::find($id);

            if (empty($previousAnalysis)) {
                session()->flash('error','not_found');
                return redirect(route('admin.previousAnalysiss.index'));
            }

            $request_data = $request->except('_token');

            $previousAnalysis->fill($request_data);
            $previousAnalysis->save();

            Alert::success('previousAnalysiss.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.previousAnalysiss.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('previousAnalysiss.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

    
    public function destroy(PreviousAnalysis $previousAnalysis)
    { 
        try { 
            // Delete previousAnalysis
            $previousAnalysis->delete();

            DB::commit();
            Alert::success('previousAnalysiss.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.previousAnalysiss.index');

        } catch (\Throwable $th) {
            Alert::error('previousAnalysiss.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
