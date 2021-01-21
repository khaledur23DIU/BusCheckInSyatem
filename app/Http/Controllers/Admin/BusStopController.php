<?php

namespace App\Http\Controllers\Admin;

use App\BusRoute;
use App\BusStop;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BusStopController extends Controller
{
    public function __construct()
    {    
         $this->middleware('auth');
         $this->middleware('permission:bus-stops-list|bus-stops-create|bus-stops-edit|bus-stops-delete', ['only' => ['index','store']]);
         $this->middleware('permission:bus-stops-create', ['only' => ['create','store']]);
         $this->middleware('permission:bus-stops-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:bus-stops-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $busStops = BusStop::orderBy('bus_route_type_name','ASC')->get()->load('busRoute');
        $busRoutes = BusRoute::where('is_active',1)->cursor();
        return view('admin.bus-stops.index', compact('busStops','busRoutes'));
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
            'bus_route' => 'required',
            'bus_route_type' => 'required',
            'bus_stop' => 'required|string|min:3|max:25'
        ]);
    	
    	$busRoute = BusRoute::find($request->bus_route);
    	if (!empty($busRoute)) {
            if ($request->bus_route_type == 1) {
                $bus_route_type_name = 'departure';
                $bus_route_type = 1 ;
            }
            else{
                $bus_route_type_name = 'return';
                $bus_route_type = 2 ;
            }
    		$dataStored = BusStop::create([
	            'bus_route_id' => $request->bus_route,
	            'bus_stop' => $request->bus_stop,
                'bus_route_type' => $bus_route_type,
                'bus_route_type_name' => $bus_route_type_name
	        ]);
	        
	        if (!empty($dataStored)) {
	            Toastr::success(__('Record Stored Successfully.'));
	            return redirect()->route('busStop.index');
	        }
	        else{
	            Toastr::error(__('Record Stored Failed.'));
	            return redirect()->route('busStop.index');
	        }
    	}
    	else{
    		Toastr::warning(__('Invalid Request!'));
            return redirect()->route('busStop.index');
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
        $busStop = BusStop::find($id);
        if (!empty($busStop)) {
        	$busStops = BusStop::orderBy('id','DESC')->get()->load('busRoute');
            $busRoutes = BusRoute::orderBy('id','DESC')->cursor();
            return view('admin.bus-stops.edit',compact('busStops','busStop','busRoutes'));
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('busStop.index');
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
            'bus_route' => 'required',
            'bus_stop' => 'required|string|min:3|max:25'
        ]);
    
        $busStop = BusStop::find($id);
        if (!empty($busStop)) {
            if ($request->bus_route_type == 1) {
                $bus_route_type_name = 'departure';
                $bus_route_type = 1 ;
            }
            else{
                $bus_route_type_name = 'return';
                $bus_route_type = 2 ;
            }
            $dataUpdated = $busStop->update([
            	'bus_route_id' => $request->bus_route,
                'bus_stop' => $request->bus_stop,
                'bus_route_type' => $bus_route_type,
                'bus_route_type_name' => $bus_route_type_name
        ]);
            if (($dataUpdated) == true) {
                Toastr::success(__('Record Updated Successfully.'));
                return redirect()->route('busStop.index');
            }
            else{
                Toastr::error(__('Record Updated Failed.'));
                return redirect()->route('busStop.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('busStop.index');
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
        $busStop = BusStop::find($id);
        if (!empty($busStop)) {
            $dataDeleted = $busStop->forceDelete();
            if (($dataDeleted) == true) {
                Toastr::success(__('Record Deleted Successfully.'));
                return redirect()->route('busStop.index');
            }
            else{
                Toastr::error(__('Record Delete Failed.'));
                return redirect()->route('busStop.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('busStop.index');
        }
        
    }
}
