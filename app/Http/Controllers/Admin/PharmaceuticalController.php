<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PharmaceuticalDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreatePharmaceuticalRequest;
use App\Http\Requests\Admin\UpdatePharmaceuticalRequest;
use App\Models\Pharmaceutical;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class PharmaceuticalController extends Controller
{ 

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_pharmaceuticals|create_pharmaceuticals|update_pharmaceuticals|delete_pharmaceuticals', ['only' => ['index']]);
        $this->middleware('permission:create_pharmaceuticals', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_pharmaceuticals', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_pharmaceuticals', ['only' => ['delete']]);
    }


    
    public function index(PharmaceuticalDataTable $pharmaceuticalDataTable)
    {  
        return $pharmaceuticalDataTable->render('admin.pharmaceuticals.index');
    }

    
    public function create()
    { 
        return view('admin.pharmaceuticals.create');
    }

     
    public function store(CreatePharmaceuticalRequest $request)
    {
        try { 
            $request_data = $request->except('_token');
              
            // Store Data
            $pharmaceutical = Pharmaceutical::create($request_data);
           
            Alert::success('pharmaceuticals.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.pharmaceuticals.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('pharmaceuticals.plural', $exception->getMessage());
            return redirect()->back();
        }


    }

     
    public function edit($id)
    {
        /** @var Pharmaceutical $pharmaceutical */
        $pharmaceutical = Pharmaceutical::find($id);
 
        if (empty($pharmaceutical)) {
            session()->flash('error','not_found');
            return redirect(route('admin.pharmaceuticals.index'));
        }
        return view('admin.pharmaceuticals.edit', compact('pharmaceutical'));
    }

     
    public function update($id, UpdatePharmaceuticalRequest $request)
    {
        try { 
            /** @var Pharmaceutical $pharmaceutical */
            $pharmaceutical = Pharmaceutical::find($id);

            if (empty($pharmaceutical)) {
                session()->flash('error','not_found');
                return redirect(route('admin.pharmaceuticals.index'));
            }

            $request_data = $request->except('_token');

            $pharmaceutical->fill($request_data);
            $pharmaceutical->save();

            Alert::success('pharmaceuticals.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.pharmaceuticals.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('pharmaceuticals.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
 
    public function destroy(Pharmaceutical $pharmaceutical)
    { 
        try { 
            // Delete pharmaceutical
            $pharmaceutical->delete();

            DB::commit();
            Alert::success('pharmaceuticals.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.pharmaceuticals.index');

        } catch (\Throwable $th) {
            Alert::error('pharmaceuticals.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
