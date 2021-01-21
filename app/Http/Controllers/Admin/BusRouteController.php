<?php

namespace App\Http\Controllers\Admin;

use App\BusRoute;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BusRouteController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:bus-route-list|bus-route-create|bus-route-edit|bus-route-delete', ['only' => ['index','store']]);
         $this->middleware('permission:bus-route-create', ['only' => ['create','store']]);
         $this->middleware('permission:bus-route-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:bus-route-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function index()
    {   
        $busRoutes = BusRoute::orderBy('id','DESC')->cursor();
        return view('admin.bus-route.index', compact('busRoutes'));
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
            'departure_starting_place' => 'required|string|min:3|max:25',
            'departure_ending_place' => 'required|string|min:3|max:25',
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

        $dataStored = BusRoute::create([
            'departure_starting_place' => $request->departure_starting_place,
            'departure_ending_place' => $request->departure_ending_place,
            'return_starting_place' => $request->departure_ending_place,
            'return_ending_place' => $request->departure_starting_place,
            'is_active' => $status
        ]);
        
        if (!empty($dataStored)) {
            Toastr::success(__('Record Stored Successfully.'));
            return redirect()->route('busRoute.index');
        }
        else{
            Toastr::error(__('Record Stored Failed.'));
            return redirect()->route('busRoute.index');
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
        $busRoute = BusRoute::find($id);
        if (!empty($busRoute)) {
            $busRoutes = BusRoute::orderBy('id','DESC')->cursor();
            return view('admin.bus-route.edit',compact('busRoute','busRoutes'));
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('busRoute.index');
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
            'departure_starting_place' => 'required|string|min:3|max:25',
            'departure_ending_place' => 'required|string|min:3|max:25',
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

        $busRoute = BusRoute::find($id);
        if (!empty($busRoute)) {
            $dataUpdated = $busRoute->update([
            'departure_starting_place' => $request->departure_starting_place,
            'departure_ending_place' => $request->departure_ending_place,
            'return_starting_place' => $request->departure_ending_place,
            'return_ending_place' => $request->departure_starting_place,
            'is_active' => $status
        ]);
            if (($dataUpdated) == true) {
                Toastr::success(__('Record Updated Successfully.'));
                return redirect()->route('busRoute.index');
            }
            else{
                Toastr::error(__('Record Updated Failed.'));
                return redirect()->route('busRoute.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('busRoute.index');
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
        $busRoute = BusRoute::find($id);
        if (!empty($busRoute)) {
            $dataDeleted = $busRoute->forceDelete();
            if (($dataDeleted) == true) {
                Toastr::success(__('Record Deleted Successfully.'));
                return redirect()->route('busRoute.index');
            }
            else{
                Toastr::error(__('Record Delete Failed.'));
                return redirect()->route('busRoute.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('busRoute.index');
        }
        
    }
}
