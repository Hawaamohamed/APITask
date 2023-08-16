<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\NewCaseDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateNewCaseRequest;
use App\Http\Requests\Admin\UpdateNewCaseRequest;
use App\Models\NewCase;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class NewCaseController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_newCases|create_newCases|update_newCases|delete_newCases', ['only' => ['index']]);
        $this->middleware('permission:create_newCases', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_newCases', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_newCases', ['only' => ['delete']]);
    }
 
    public function index(NewCaseDataTable $newCaseDataTable)
    { 
        return $newCaseDataTable->render('admin.newCases.index');
    }

    
    public function create()
    { 
        return view('admin.newCases.create');
    }

    public function store(CreateNewCaseRequest $request)
    {
        try {
            
            $request_data = $request->except('_token');
              
            // Store Data
            $newCase = NewCase::create($request_data);
           
            Alert::success('newCases.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.newCases.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('newCases.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }
 
    public function edit($id)
    {
        /** @var NewCase $newCase */
        $newCase = NewCase::find($id); 

        if (empty($newCase)) {
            session()->flash('error','not_found');
            return redirect(route('admin.newCases.index'));
        }
        return view('admin.newCases.edit', compact('newCase'));
    }

    
    public function update($id, UpdateNewCaseRequest $request)
    {
        try {
           
            /** @var NewCase $newCase */
            $newCase = NewCase::find($id);

            if (empty($newCase)) {
                session()->flash('error','not_found');
                return redirect(route('admin.newCases.index'));
            }

            $request_data = $request->except('_token');

            $newCase->fill($request_data);
            $newCase->save();

            Alert::success('newCases.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.newCases.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('newCases.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

     
    public function destroy(NewCase $newCase)
    { 
        try { 
            // Delete newCase
            $newCase->delete();

            DB::commit();
            Alert::success('newCases.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.newCases.index');

        } catch (\Throwable $th) {
            Alert::error('newCases.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
