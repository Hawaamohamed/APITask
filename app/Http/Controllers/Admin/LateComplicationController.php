<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\LateComplicationDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateLateComplicationRequest;
use App\Http\Requests\Admin\UpdateLateComplicationRequest;
use App\Models\LateComplication;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert; 

class LateComplicationController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_lateComplications|create_lateComplications|update_lateComplications|delete_lateComplications', ['only' => ['index']]);
        $this->middleware('permission:create_lateComplications', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_lateComplications', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_lateComplications', ['only' => ['delete']]);
    }
 
    public function index(LateComplicationDataTable $lateComplicationDataTable)
    { 
        return $lateComplicationDataTable->render('admin.lateComplications.index');
    }
 
    public function create()
    { 
        return view('admin.lateComplications.create');
    }
 
    public function store(CreateLateComplicationRequest $request)
    {
        try { 
            $request_data = $request->except('_token'); 

            // Store Data
            $lateComplication = LateComplication::create($request_data);
           
            Alert::success('lateComplications.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.lateComplications.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('lateComplications.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }
 

    public function edit($id)
    { 
        $lateComplication = LateComplication::find($id); 

        if (empty($lateComplication)) {
            session()->flash('error','not_found');
            return redirect(route('admin.lateComplications.index'));
        }
        return view('admin.lateComplications.edit', compact('lateComplication'));
    }
 

    public function update($id, UpdateLateComplicationRequest $request)
    {
        try { 
            $lateComplication = LateComplication::find($id);

            if (empty($lateComplication)) {
                session()->flash('error','not_found');
                return redirect(route('admin.lateComplications.index'));
            }

            $request_data = $request->except('_token');

            $lateComplication->fill($request_data);
            $lateComplication->save();

            Alert::success('lateComplications.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.lateComplications.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('lateComplications.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

     
    public function destroy(LateComplication $lateComplication)
    { 
        try { 
            // Delete lateComplication
            $lateComplication->delete();

            DB::commit();
            Alert::success('lateComplications.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.lateComplications.index');

        } catch (\Throwable $th) {
            Alert::error('lateComplications.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
