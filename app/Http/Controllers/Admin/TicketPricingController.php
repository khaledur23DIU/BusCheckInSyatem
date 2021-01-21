<?php

namespace App\Http\Controllers\Admin;

use App\BusRoute;
use App\BusStop;
use App\Http\Controllers\Controller;
use App\TicketPricing;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class TicketPricingController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:ticket-price-list|ticket-price-create|ticket-price-edit|ticket-price-delete', ['only' => ['index','store']]);
         $this->middleware('permission:ticket-price-create', ['only' => ['create','store']]);
         $this->middleware('permission:ticket-price-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:ticket-price-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $ticketPrices = TicketPricing::orderBy('id','ASC')->get()->load(['busRoute','fromWhere','toWhere']);
        $busRoutes = BusRoute::where('is_active',1)->cursor();
        return view('admin.ticket-price.index', compact('ticketPrices','busRoutes'));
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
            'from_where' => 'required',
            'to_where' => 'required',
            'price' => 'required|numeric|min:0'
        ]);
    	
    	$busRoute = BusRoute::find($request->bus_route);
    	if (!empty($busRoute)) {
    		$dataStored = TicketPricing::create([
	            'bus_route_id' => $request->bus_route,
	            'from_where' => $request->from_where,
	            'to_where' => $request->to_where,
	            'price' => $request->price
	        ]);
	        
	        if (!empty($dataStored)) {
	            Toastr::success(__('Record Stored Successfully.'));
	            return redirect()->route('ticketPrice.index');
	        }
	        else{
	            Toastr::error(__('Record Stored Failed.'));
	            return redirect()->route('ticketPrice.index');
	        }
    	}
    	else{
    		Toastr::warning(__('Invalid Request!'));
            return redirect()->route('ticketPrice.index');
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
        $ticketPriceFind = TicketPricing::find($id);
        if (!empty($ticketPriceFind)) {
        	$ticketPrices = TicketPricing::orderBy('id','ASC')->get()->load(['busRoute','fromWhere','toWhere']);
            $busRoutes = BusRoute::where('is_active',1)->cursor();
            $ticketPrice = $ticketPriceFind->load(['busRoute','fromWhere','toWhere']);
            return view('admin.ticket-price.edit',compact('busRoutes','ticketPrice','ticketPrices'));
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('ticketPrice.index');
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
            'from_where' => 'required',
            'to_where' => 'required',
            'price' => 'required|numeric|min:0'
        ]);
    
        $ticketPrice = TicketPricing::find($id);
        if (!empty($ticketPrice)) {
            $dataUpdated = $ticketPrice->update([
            	'bus_route_id' => $request->bus_route,
	            'from_where' => $request->from_where,
	            'to_where' => $request->to_where,
	            'price' => $request->price
        ]);
            if (($dataUpdated) == true) {
                Toastr::success(__('Record Updated Successfully.'));
                return redirect()->route('ticketPrice.index');
            }
            else{
                Toastr::error(__('Record Updated Failed.'));
                return redirect()->route('ticketPrice.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('ticketPrice.index');
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
        $ticketPrice = TicketPricing::find($id);
        if (!empty($ticketPrice)) {
            $dataDeleted = $ticketPrice->forceDelete();
            if (($dataDeleted) == true) {
                Toastr::success(__('Record Deleted Successfully.'));
                return redirect()->route('ticketPrice.index');
            }
            else{
                Toastr::error(__('Record Delete Failed.'));
                return redirect()->route('ticketPrice.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('ticketPrice.index');
        }
        
    }

    public function getBusStopFromWhere()
    {
        if (isset($_GET['busRoute']) && isset($_GET['busRouteType'])){
            $route = $_GET['busRoute'];
            $routeType = $_GET['busRouteType'];
            $busRoute = BusRoute::where('id',$route)->first();
            if(!empty($busRoute)){
            	$ticketPrices = $busRoute->ticketPrices()->get();
            	if (($ticketPrices->isNotEmpty())) {
            		$excludePlace = array();
            		foreach ($ticketPrices as $key => $price) {
            			$excludePlace[] = $price->from_where;
            		}
            		$busStops = BusStop::whereNotIn('id',$excludePlace)->where('bus_route_id',$busRoute->id)->where('bus_route_type',$routeType)->get();
            	}
            	else{
            		$busStops = $busRoute->busStops()->where('bus_route_type',$routeType)->get();
            	}

            echo json_encode($busStops);
            }

            else{
                return response()->json(['error'=>"Records Not Found."]);
                
            }
        }
        else{
            return response()->json(['error'=>"Worng Reuquest."]);
        }
        
    }

    public function getBusStopToWhere()
    {
        if (isset($_GET['busRoute']) && isset($_GET['fromWhere']) && isset($_GET['busRouteType'])){
            $route = $_GET['busRoute'];
            $fromWhere = $_GET['fromWhere'];
            $routeType = $_GET['busRouteType'];
            $busRoute = BusRoute::where('id',$route)->first();
            if(!empty($busRoute)){
            	$ticketPrices = $busRoute->ticketPrices()->get();
            	if (($ticketPrices->isNotEmpty())) {
            		$excludePlace = array();
            		$excludePlace[] = $fromWhere;
            		foreach ($ticketPrices as $key => $price) {
            			$excludePlace[] = $price->from_where;
            		}
            		$busStops = BusStop::whereNotIn('id', $excludePlace)->where('bus_route_id',$busRoute->id)->where('bus_route_type',$routeType)->get();
            	}
            	else{
            		$busStops = BusStop::where('id', '!=', $fromWhere)->where('bus_route_id',$busRoute->id)->where('bus_route_type',$routeType)->get();
            	}
                
            echo json_encode($busStops);
            }
            else{
                return response()->json(['error'=>"Records Not Found."]);
                
            }
        }
        else{
            return response()->json(['error'=>"Worng Reuquest."]);
        }
        
    }
}
