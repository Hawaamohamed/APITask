<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\DiscountDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateDiscountRequest;
use App\Http\Requests\Admin\UpdateDiscountRequest;
use App\Models\Discount;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB; 
use RealRashid\SweetAlert\Facades\Alert;

class DiscountController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('permission:read_discounts|create_discounts|update_discounts|delete_discounts', ['only' => ['index']]);
        $this->middleware('permission:create_discounts', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_discounts', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_discounts', ['only' => ['delete']]);
    }
 
    public function index(DiscountDataTable $discountDataTable)
    { 
        return $discountDataTable->render('admin.discounts.index'); 
    }
 
    public function create()
    {

        return view('admin.discounts.create');
    }
 
    public function store(CreateDiscountRequest $request)
    {
        try { 
            $request_data = $request->except('_token');  
            // Store Data
            $discount = Discount::create($request_data);
           
            Alert::success('discounts', ' added_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect()->route('admin.discounts.index');
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            DB::rollBack();
            Alert::error('discounts', $exception->getMessage());
            return redirect()->back();
        } 

    }

     
    public function edit($id)
    { 
        $discount = Discount::find($id); 

        if (empty($discount)) {
            session()->flash('error', 'not_found');
            return redirect(route('admin.discounts.index'));
        }
        return view('admin.discounts.edit', compact('discount'));
    }
 
    public function update($id, UpdateDiscountRequest $request)
    {
        try { 
            /** @var Discount $discount */
            $discount = Discount::find($id);

            if (empty($discount)) {
                session()->flash('error','not_found');
                return redirect(route('admin.discounts.index'));
            }

            $request_data = $request->except('_token');

            $discount->fill($request_data);
            $discount->save();

            Alert::success('discounts ', 'updated_successfully');
            // Commit And Redirect on index with Success Message
            DB::commit();
            return redirect(route('admin.discounts.index'));
        } catch (\Exception $exception) {
            // Rollback & Return Error Message
            Alert::error('discounts', $exception->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
 
    public function destroy(Discount $discount)
    { 
        try { 
            // Delete discount
            $discount->delete();

            DB::commit();
            Alert::success('discounts', 'deleted_successfully');
            return redirect()->route('admin.discounts.index');

        } catch (\Throwable $th) {
            Alert::error('discounts', $th->getMessage());

            DB::rollBack();
            return redirect()->back();
        }
    }
}
