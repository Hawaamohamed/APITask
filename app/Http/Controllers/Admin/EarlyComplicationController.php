<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\EarlyComplicationDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateEarlyComplicationRequest;
use App\Http\Requests\Admin\UpdateEarlyComplicationRequest;
use App\Models\EarlyComplication;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class EarlyComplicationController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_earlyComplications|create_earlyComplications|update_earlyComplications|delete_earlyComplications', ['only' => ['index']]);
        $this->middleware('permission:create_earlyComplications', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_earlyComplications', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_earlyComplications', ['only' => ['delete']]);
    }


    /**
     * List Investor
     * @param EarlyComplicationDataTable $EarlyComplicationDataTable
     * @return mixed
     */
    public function index(EarlyComplicationDataTable $earlyComplicationDataTable)
    { 
        return $earlyComplicationDataTable->render('admin.earlyComplications.index'); 
    }
 
    public function create()
    {

        return view('admin.earlyComplications.create');
    }
 
    public function store(CreateEarlyComplicationRequest $request)
    {
        try { 
            $request_data = $request->except('_token'); 

            // Store Data
            $earlyComplication = EarlyComplication::create($request_data);
           
            Alert::success('earlyComplications.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.earlyComplications.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('earlyComplications.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }
 

    public function edit($id)
    { 
        $earlyComplication = EarlyComplication::find($id);
 
        if (empty($earlyComplication)) {
            session()->flash('error','not_found');
            return redirect(route('admin.earlyComplications.index'));
        }
        return view('admin.earlyComplications.edit', compact('earlyComplication'));
    }
 

    public function update($id, UpdateEarlyComplicationRequest $request)
    {
        try { 

            $earlyComplication = EarlyComplication::find($id);

            if (empty($earlyComplication)) {
                session()->flash('error','not_found');
                return redirect(route('admin.earlyComplications.index'));
            }

            $request_data = $request->except('_token');

            $earlyComplication->fill($request_data);
            $earlyComplication->save();

            Alert::success('earlyComplications.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.earlyComplications.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('earlyComplications.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

     
    public function destroy(EarlyComplication $earlyComplication)
    { 
        try {
            // Delete earlyComplication
            $earlyComplication->delete();

            DB::commit();
            Alert::success('earlyComplications.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.earlyComplications.index');

        } catch (\Throwable $th) {
            Alert::error('earlyComplications.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
