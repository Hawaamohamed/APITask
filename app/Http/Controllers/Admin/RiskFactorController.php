<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\RiskFactorDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateRiskFactorRequest;
use App\Http\Requests\Admin\UpdateRiskFactorRequest;
use App\Models\RiskFactor;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class RiskFactorController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_riskFactors|create_riskFactors|update_riskFactors|delete_riskFactors', ['only' => ['index']]);
        $this->middleware('permission:create_riskFactors', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_riskFactors', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_riskFactors', ['only' => ['delete']]);
    }

 
    public function index(RiskFactorDataTable $riskFactorDataTable)
    { 
        return $riskFactorDataTable->render('admin.riskFactors.index');
    }
 
    public function create()
    { 
        return view('admin.riskFactors.create');
    }

    
    public function store(CreateRiskFactorRequest $request)
    {
        try { 
            $request_data = $request->except('_token');
              
            // Store Data
            $riskFactor = RiskFactor::create($request_data);
           
            Alert::success('riskFactors.plural', 'lang.added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.riskFactors.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('riskFactors.plural', $exception->getMessage());
            return redirect()->back();
        } 

    }

    
    public function edit($id)
    {
        /** @var RiskFactor $riskFactor */
        $riskFactor = RiskFactor::find($id); 

        if (empty($riskFactor)) {
            session()->flash('error','not_found');
            return redirect(route('admin.riskFactors.index'));
        }
        return view('admin.riskFactors.edit', compact('riskFactor'));
    }

     
    public function update($id, UpdateRiskFactorRequest $request)
    {
        try { 
            /** @var RiskFactor $riskFactor */
            $riskFactor = RiskFactor::find($id);

            if (empty($riskFactor)) {
                session()->flash('error','not_found');
                return redirect(route('admin.riskFactors.index'));
            }

            $request_data = $request->except('_token');

            $riskFactor->fill($request_data);
            $riskFactor->save();

            Alert::success('riskFactors.plural', 'lang.updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.riskFactors.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('riskFactors.plural', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
 

    public function destroy(RiskFactor $riskFactor)
    { 
        try { 
            // Delete riskFactor
            $riskFactor->delete();

            DB::commit();
            Alert::success('riskFactors.plural', 'lang.deleted_successfully');
            return redirect()->route('admin.riskFactors.index');

        } catch (\Throwable $th) {
            Alert::error('riskFactors.plural', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
