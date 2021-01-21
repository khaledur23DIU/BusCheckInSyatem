<?php

namespace App\Http\Controllers\Admin;

use App\Bus;
use App\BusRoute;
use App\BusesInRoute;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class BusesInRouteController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:bus-in-Route-list|bus-in-Route-create|bus-in-Route-edit|bus-in-Route-delete', ['only' => ['index','store']]);
         $this->middleware('permission:bus-in-Route-create', ['only' => ['create','store']]);
         $this->middleware('permission:bus-in-Route-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:bus-in-Route-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $busesInRoute = BusesInRoute::orderBy('id','DESC')->get()->load(['busRoute','bus']);
        $busRoutes = BusRoute::where('is_active',1)->cursor();
        $excludeBuses = array();
        foreach ($busesInRoute as $busInRoute) {
        	$excludeBuses[] = $busInRoute->bus_id;
        }
        $buses = Bus::orderBy('id','DESC')->where('is_running',1)->whereNotIn('id',$excludeBuses)->get();
        return view('admin.assignBus-inRoute.index', compact('busesInRoute','busRoutes','buses'));
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
            'bus' => 'required|unique:buses_in_routes,bus_id',
            'bus_route' => 'required'
        ]);
    	
    	$bus = Bus::find($request->bus);
    	$busRoute = BusRoute::find($request->bus_route);
    	if (!empty($busRoute) && !empty($bus)) {
    		$dataStored = BusesInRoute::create([
	            'bus_id' => $bus->id,
	            'bus_route_id' => $busRoute->id
	        ]);
	        
	        if (!empty($dataStored)) {
	            Toastr::success(__('Record Stored Successfully.'));
	            return redirect()->route('busInRoute.index');
	        }
	        else{
	            Toastr::error(__('Record Stored Failed.'));
	            return redirect()->route('busInRoute.index');
	        }
    	}
    	else{
    		Toastr::warning(__('Invalid Request!'));
            return redirect()->route('busInRoute.index');
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
        $busInRouteFind = BusesInRoute::find($id);
        if (!empty($busInRouteFind)) {
        	$busInRoute = $busInRouteFind;
        	$busesInRoute = BusesInRoute::orderBy('id','DESC')->get()->load(['busRoute','bus']);
            $busRoutes = BusRoute::where('is_active',1)->cursor();
            $buses = Bus::orderBy('id','DESC')->where('is_running',1)->get();
            return view('admin.assignBus-inRoute.edit',compact('busRoutes','busInRoute','busesInRoute','buses'));
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('busInRoute.index');
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
            'bus' => 'required|unique:buses_in_routes,bus_id',
            'bus_route' => 'required',
        ]);
    
        $busInRoute = BusesInRoute::find($id);
        $bus = Bus::find($request->bus);
    	$busRoute = BusRoute::find($request->bus_route);
        if (!empty($busInRoute) && !empty($bus) && !empty($busRoute)) {
            $dataUpdated = $busInRoute->update([
            	'bus_id' => $bus->id,
            	'bus_route_id' => $busRoute->id
        ]);
            if (($dataUpdated) == true) {
                Toastr::success(__('Record Updated Successfully.'));
                return redirect()->route('busInRoute.index');
            }
            else{
                Toastr::error(__('Record Updated Failed.'));
                return redirect()->route('busInRoute.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('busInRoute.index');
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
        $busInRoute = BusesInRoute::find($id);
        if (!empty($busInRoute)) {
            $dataDeleted = $busInRoute->forceDelete();
            if (($dataDeleted) == true) {
                Toastr::success(__('Record Deleted Successfully.'));
                return redirect()->route('busInRoute.index');
            }
            else{
                Toastr::error(__('Record Delete Failed.'));
                return redirect()->route('busInRoute.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('busInRoute.index');
        }
        
    }

     
}
