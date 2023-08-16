<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AnnualEvaluationFeetDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateAnnualEvaluationFeetRequest; 
use App\Http\Requests\Admin\UpdateAnnualEvaluationFeetRequest; 
use App\Models\AnnualEvaluationFeet;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class AnnualEvaluationFeetController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_annualEvaluationFeets|create_annualEvaluationFeets|update_annualEvaluationFeets|delete_annualEvaluationFeets', ['only' => ['index']]);
        $this->middleware('permission:create_annualEvaluationFeets', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_annualEvaluationFeets', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_annualEvaluationFeets', ['only' => ['delete']]);
    } 

    /**
     * List Investor
     * @param AnnualEvaluationFeetDataTable $AnnualEvaluationFeetDataTable
     * @return mixed
     */
    public function index(AnnualEvaluationFeetDataTable $annualEvaluationFeetDataTable)
    { 
        return $annualEvaluationFeetDataTable->render('admin.annualEvaluationFeets.index');
    }
 

    public function create()
    {

        return view('admin.annualEvaluationFeets.create');
    }
 

    public function store(CreateAnnualEvaluationFeetRequest $request)
    {
        try { 
            $request_data = $request->except('_token');  
            // Store Data
            $annualEvaluationFeet = AnnualEvaluationFeet::create($request_data);
           
            Alert::success('annualEvaluationFeets added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.annualEvaluationFeets.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('annualEvaluationFeets', $exception->getMessage());
            return redirect()->back();
        } 

    }

     
    public function edit($id)
    {
        /** @var AnnualEvaluationFeet $annualEvaluationFeet */
        $annualEvaluationFeet = AnnualEvaluationFeet::find($id); 

        if (empty($annualEvaluationFeet)) {
            session()->flash('error', 'lang.not_found');
            return redirect(route('admin.annualEvaluationFeets.index'));
        }
        return view('admin.annualEvaluationFeets.edit', compact('annualEvaluationFeet'));
    }

     
    public function update($id, UpdateAnnualEvaluationFeetRequest $request)
    {
        try { 
            /** @var AnnualEvaluationFeet $annualEvaluationFeet */
            $annualEvaluationFeet = AnnualEvaluationFeet::find($id);

            if (empty($annualEvaluationFeet)) {
                session()->flash('error', 'lang.not_found');
                return redirect(route('admin.annualEvaluationFeets.index'));
            }

            $request_data = $request->except('_token');

            $annualEvaluationFeet->fill($request_data);
            $annualEvaluationFeet->save();

            Alert::success('annualEvaluationFeets.plural', 'updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.annualEvaluationFeets.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('annualEvaluationFeets.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }

     
    public function destroy(AnnualEvaluationFeet $annualEvaluationFeet)
    { 
        try { 
            // Delete annualEvaluationFeet
            $annualEvaluationFeet->delete();

            DB::commit();
            Alert::success('annualEvaluationFeets', 'deleted_successfully');
            return redirect()->route('admin.annualEvaluationFeets.index');

        } catch (\Throwable $th) {
            Alert::error('annualEvaluationFeets', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
