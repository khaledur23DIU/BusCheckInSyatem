<?php

namespace App\Http\Controllers\Admin;

use App\AssignChecker;
use App\BusRoute;
use App\BusStop;
use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AssignCheckerController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:assign-checker-list|assign-checker-create|assign-checker-edit|assign-checker-delete', ['only' => ['index','store']]);
         $this->middleware('permission:assign-checker-create', ['only' => ['create','store']]);
         $this->middleware('permission:assign-checker-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:assign-checker-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $assignedCheckers = AssignChecker::orderBy('id','DESC')->get()->load(['checker','checkingPlace']);

        $busRoutes = BusRoute::where('is_active',1)->cursor();
        $excludeChecker = array();
        foreach ($assignedCheckers as $assignChecker) {
        	$excludeChecker[] = $assignChecker->checker_id;
        }
        $checkers = (Role::where('id',2)->first())->users->whereNotIn('id',$excludeChecker);
        return view('admin.assign-checker.index', compact('assignedCheckers','busRoutes','checkers'));
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
            'check_in_place' => 'required',
            'checker' => 'required|unique:assign_checkers,checker_id'
        ]);
    	
    	$busRoute = BusRoute::find($request->bus_route);
    	$checkInPlace = BusStop::find($request->check_in_place);
    	if (!empty($busRoute) && !empty($checkInPlace)) {
    		$dataStored = AssignChecker::create([
	            'checker_id' => $request->checker,
	            'bus_stop_id' => $checkInPlace->id
	        ]);
	        
	        if (!empty($dataStored)) {
	            Toastr::success(__('Record Stored Successfully.'));
	            return redirect()->route('assignChecker.index');
	        }
	        else{
	            Toastr::error(__('Record Stored Failed.'));
	            return redirect()->route('assignChecker.index');
	        }
    	}
    	else{
    		Toastr::warning(__('Invalid Request!'));
            return redirect()->route('assignChecker.index');
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
        $assignedCheckerFind = AssignChecker::find($id);
        if (!empty($assignedCheckerFind)) {
        	$assignedChecker = $assignedCheckerFind;

        	$assignedCheckers = AssignChecker::orderBy('id','DESC')->get()->load(['checker','checkingPlace']);
        	$checkerExclude = AssignChecker::where('id','!=',$id)->get();
        	$busRoutes = BusRoute::where('is_active',1)->cursor();

            $excludeChecker = array();
	        foreach ($checkerExclude as $assignChecker) {
	        	$excludeChecker[] = $assignChecker->checker_id;
	        }
	        $checkers = (Role::where('id',2)->first())->users->whereNotIn('id',$excludeChecker);
            return view('admin.assign-checker.edit',compact('busRoutes','assignedChecker','assignedCheckers','checkers'));
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('assignChecker.index');
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
            'check_in_place' => 'required',
            'checker' => 'required'
        ]);
    
        $assignedChecker = AssignChecker::find($id);
        $checkInPlace = BusStop::find($request->check_in_place);
    	$busRoute = BusRoute::find($request->bus_route);
        if (!empty($assignedChecker) && !empty($checkInPlace) && !empty($busRoute)) {
            $dataUpdated = $assignedChecker->update([
            	'checker_id' => $request->checker,
	            'bus_stop_id' => $checkInPlace->id
        ]);
            if (($dataUpdated) == true) {
                Toastr::success(__('Record Updated Successfully.'));
                return redirect()->route('assignChecker.index');
            }
            else{
                Toastr::error(__('Record Updated Failed.'));
                return redirect()->route('assignChecker.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('assignChecker.index');
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
        $assignChecker = AssignChecker::find($id);
        if (!empty($assignChecker)) {
            $dataDeleted = $assignChecker->forceDelete();
            if (($dataDeleted) == true) {
                Toastr::success(__('Record Deleted Successfully.'));
                return redirect()->route('assignChecker.index');
            }
            else{
                Toastr::error(__('Record Delete Failed.'));
                return redirect()->route('assignChecker.index');
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('assignChecker.index');
        }
        
    }

    public function getCheckInPlace()
    {
        if (isset($_GET['busRoute']) && isset($_GET['busRouteType'])){
            $route = $_GET['busRoute'];
            $routeType = $_GET['busRouteType'];
            $busRoute = BusRoute::where('id',$route)->first();
            if(!empty($busRoute)){
            	
            	$checkInPlaces = BusStop::where('bus_route_id',$busRoute->id)->where('bus_route_type',$routeType)->get();
            	echo json_encode($checkInPlaces);
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
