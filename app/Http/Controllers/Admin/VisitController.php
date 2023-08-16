<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\VisitDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateVisitRequest;
use App\Http\Requests\Admin\UpdateVisitRequest;
use App\Models\Visit;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class VisitController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_visits|create_visits|update_visits|delete_visits', ['only' => ['index']]);
        $this->middleware('permission:create_visits', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_visits', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_visits', ['only' => ['delete']]);
    }

 
    public function index(VisitDataTable $visitDataTable)
    {        
        return $visitDataTable->render('admin.visits.index');
    }

  
    public function create()
    { 
        return view('admin.visits.create');
    }

     
    public function store(CreateVisitRequest $request)
    {
        try { 
            $request_data = $request->except('_token');
              
            // Store Data
            $visit = Visit::create($request_data);
           
            Alert::success('visits.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.visits.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('visits.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }

     
    public function edit($id)
    {
        /** @var Visit $visit */
        $visit = Visit::find($id);
 
        if (empty($visit)) {
            session()->flash('error','not_found');
            return redirect(route('admin.visits.index'));
        }
        return view('admin.visits.edit', compact('visit'));
    }

     
    public function update($id, UpdateVisitRequest $request)
    {
        try { 
            /** @var Visit $visit */
            $visit = Visit::find($id);

            if (empty($visit)) {
                session()->flash('error','not_found');
                return redirect(route('admin.visits.index'));
            }

            $request_data = $request->except('_token');

            $visit->fill($request_data);
            $visit->save();

            Alert::success('visits.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.visits.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('visits.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

     
    public function destroy(Visit $visit)
    { 
        try { 
            // Delete visit
            $visit->delete();

            DB::commit();
            Alert::success('visits.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.visits.index');

        } catch (\Throwable $th) {
            Alert::error('visits.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
