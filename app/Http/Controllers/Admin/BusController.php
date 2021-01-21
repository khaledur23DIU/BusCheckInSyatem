<?php

namespace App\Http\Controllers\Admin;

use App\Bus;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:bus-list|bus-create|bus-edit|bus-delete', ['only' => ['index','store']]);
         $this->middleware('permission:bus-create', ['only' => ['create','store']]);
         $this->middleware('permission:bus-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:bus-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the buses
     *
     * @param  \App\Bus
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $buses = Bus::orderBy('id','DESC')->cursor();
        return view('admin.bus.index', compact('buses'));
    }    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'bus_no' => 'required|string|min:3|max:25|unique:buses,bus_no',
            'status' => 'required'
        ]);
    
        if ($request->has('status')) {
           if($request['status'] == '1')
           {
            $status = true;
           }
           else if($request['status'] == '0')
           {
            $status = false;
           }
           else{
            $status = false;
           }
        }

        $dataStored = Bus::create([
            'bus_no' => $request->bus_no,
            'is_running' => $status
        ]);
        
        if (!empty($dataStored)) {
            Toastr::success(__('Record Stored Successfully.'));
            return redirect()->route('bus.index');
        }
        else{
            Toastr::error(__('Record Stored Failed.'));
            return redirect()->route('bus.index');
        }
        
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bus = Bus::find($id);
        if (!empty($bus)) {
            $buses = Bus::orderBy('id','DESC')->cursor();
            return view('admin.bus.edit',compact('bus','buses'));
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('bus.index');
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
            'bus_no' => 'required|string|min:3|max:25',
            'status' => 'required'
        ]);
    
        if ($request->has('status')) {
           if($request['status'] == '1')
           {
            $status = true;
           }
           else if($request['status'] == '0')
           {
            $status = false;
           }
           else{
            $status = false;
           }
        }

        $bus = Bus::find($id);
        if (!empty($bus)) {
            $dataUpdated = $bus->update([
            'bus_no' => $request->bus_no,
            'is_running' => $status
        ]);
            if (($dataUpdated) == true) {
                Toastr::success(__('Record Updated Successfully.'));
                return redirect()->route('bus.index');
            }
            else{
                Toastr::error(__('Record Updated Failed.'));
                return redirect()->route('bus.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('bus.index');
        }
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bus = Bus::find($id);
        if (!empty($bus)) {
            $dataDeleted = $bus->forceDelete();
            if (($dataDeleted) == true) {
                Toastr::success(__('Record Deleted Successfully.'));
                return redirect()->route('bus.index');
            }
            else{
                Toastr::error(__('Record Delete Failed.'));
                return redirect()->route('bus.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('bus.index');
        }
        
    }
}
