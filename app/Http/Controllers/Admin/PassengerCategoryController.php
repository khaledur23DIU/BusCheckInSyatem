<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PassengerCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class PassengerCategoryController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:passenger-category-list|passenger-category-create|passenger-category-edit|passenger-category-delete', ['only' => ['index','store']]);
         $this->middleware('permission:passenger-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:passenger-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:passenger-category-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the passengers category
     *
     * @param  \App\PassengerCategory
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $passCategories = PassengerCategory::orderBy('id','DESC')->cursor();
        return view('admin.passenger-category.index', compact('passCategories'));
    }    
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $passCategory = PassengerCategory::find($id);
        if (!empty($passCategory)) {
            $passCategories = PassengerCategory::orderBy('id','DESC')->cursor();
            return view('admin.passenger-category.edit',compact('passCategory','passCategories'));
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('passengerCategory.index');
        }
        
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cost_in_percentage' => 'required|integer|between:0,100'
        ]);
    

        $passCategory = PassengerCategory::find($id);
        if (!empty($passCategory)) {
            $dataUpdated = $passCategory->update([
            'cost_in_percentage' => $request->cost_in_percentage
        ]);
            if (($dataUpdated) == true) {
                Toastr::success(__('Record Updated Successfully.'));
                return redirect()->route('passengerCategory.index');
            }
            else{
                Toastr::error(__('Record Updated Failed.'));
                return redirect()->route('passengerCategory.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('passengerCategory.index');
        }
        
    }
    
}
