<?php

namespace App\Http\Controllers\Checker;

use App\Bus;
use App\CheckIn;
use App\CheckInIncome;
use App\CheckInPassenger;
use App\DailyIncomeEntry;
use App\Http\Controllers\Controller;
use App\PassengerCategory;
use App\TicketPricing;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:check-in-list|check-in-create|check-in-edit|check-in-delete', ['only' => ['index','store']]);
         $this->middleware('permission:check-in-create', ['only' => ['create','store']]);
         $this->middleware('permission:check-in-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:check-in-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
          if (empty(Auth::user()->checkIn)) {
          	Toastr::warning(__('You Are Not Assigned To Check In Place Yet! Contact System Administration'));
          	return redirect()->route('home');
          }
          $lastCheckInBus = CheckIn::latest('created_at')->where('bus_stop_id',Auth::user()->checkIn->checkingPlace->id)->first();
          
         $checkIns = CheckIn::orderBy('id','DESC')->where('checker_id',Auth::user()->id)->where('bus_stop_id',Auth::user()->checkIn->checkingPlace->id)->get()->load('checkInPassenger');

         $busesOnCurrentRoute = Auth::user()->checkIn->checkingPlace->busRoute->busInRoute;
         $busesBetween = array();
         foreach ($busesOnCurrentRoute as $busId) {
         	$busesBetween[] = $busId->id;
         }

         if (!empty($lastCheckInBus)) {
         	$buses = Bus::orderBy('id','ASC')->whereIn('id',$busesBetween)->where('id','!=',$lastCheckInBus->bus_id)->where('is_running',1)->cursor();
         	
         }
         else{
         	$buses = Bus::orderBy('id','ASC')->whereIn('id',$busesBetween)->where('is_running',1)->cursor();
         }
        
        return view('checker.check-in.index',compact('buses','checkIns'));
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
            'bus' => 'required',
            'staff' => 'sometimes|nullable|numeric|min:0|lte:total',
            'student' => 'sometimes|nullable|numeric|min:0|lte:total',
            'physical' => 'sometimes|nullable|numeric|min:0|lte:total',
            'total' => 'required|numeric|min:0',
        ]);
    	   	
    	
    	$bus = Bus::where('id',$request->bus_route)->where('is_running',1)->get();
    	if (!empty($bus)) {
    		$checkInDataStored = CheckIn::create([
	            'checker_id' => Auth::user()->id,
	            'bus_id' => $request->bus,
	            'bus_stop_id' => Auth::user()->checkIn->checkingPlace->id
	        ]);	        

	        if (!empty($checkInDataStored)) {
	        	if ($request->has('student') && $request->student != null) {
	        		$student = $request->student;
	        	}
	        	else{
	        		$student = 0;
	        	}
	        	
	        	if ($request->has('staff') && $request->staff != null) {
	        		$staff = $request->staff;
	        	}
	        	else{
	        		$staff = 0;
	        	}

	        	if ($request->has('physical') && $request->physical != null) {
	        		$physical = $request->physical;
	        	}
	        	else{
	        		$physical = 0;
	        	}

	        	$passengersDataStored = CheckInPassenger::create([
	        		'checkIn_id' => $checkInDataStored->id,
	        		'student' => $student,
	        		'staff' => $staff,
	        		'physically_disabled' => $physical,
	        		'total' => $request->total
	        	]);

	        	if (!empty($passengersDataStored)) {
	        		// Check if its the starting place or not
	        		$place = $checkInDataStored->bus_stop_id;
	        		$checkPlace = TicketPricing::where('to_where',$place)->first();

	        		if (!empty($checkPlace)) {
	        			$regular = PassengerCategory::where('passenger_category','Regular')->first('cost_in_percentage');
	        			$student = PassengerCategory::where('passenger_category','Student')->first('cost_in_percentage');
	        			$staff = PassengerCategory::where('passenger_category','Staff')->first('cost_in_percentage');
	        			$physicallyDisabled = PassengerCategory::where('passenger_category','Physically Disabled')->first('cost_in_percentage');
	        			$checkInIncome = (($regular->cost_in_percentage / 100) * $passengersDataStored->total * $checkPlace->price) - (($student->cost_in_percentage / 100) * $passengersDataStored->student * $checkPlace->price) - (($staff->cost_in_percentage / 100) * $passengersDataStored->staff * $checkPlace->price) - (($physicallyDisabled->cost_in_percentage / 100) * $passengersDataStored->physically_disabled * $checkPlace->price);

	        			$checkInIncomeDataStored = CheckInIncome::create([
	        				'checkInPass_id' => $passengersDataStored->id,
	        				'income' => $checkInIncome
	        			]);

	        		}
	        		else{
	        			$checkInIncome = 0 ;
	        			$checkInIncomeDataStored = CheckInIncome::create([
	        				'checkInPass_id' => $passengersDataStored->id,
	        				'income' => $checkInIncome
	        			]);
	        		}

	        		$busEntryCurrentDate = DailyIncomeEntry::where('bus_id',$checkInDataStored->bus_id)->whereDate('created_at',$checkInDataStored->created_at)->first();
	        		if (!empty($busEntryCurrentDate)) {

	        			$checkIds = array();
	        			foreach ($busEntryCurrentDate->check_in_ids as $id) {
	        				$checkIds[] = $id;
	        			}
	        			$checkIds[] = $checkInDataStored->id;

	        			$checkPlaces = array();
	        			foreach ($busEntryCurrentDate->check_in_places as $place) {
	        				$checkPlaces[] = $place;
	        			}
	        			$checkPlaces[] = $checkInDataStored->bus_stop_id;

	        			$incomeEntryDataStored = $busEntryCurrentDate->update([
	        				'income' => $busEntryCurrentDate->income + $checkInIncomeDataStored->income,
	        				'check_in_ids' => $checkIds,
	        				'check_in_places' => $checkPlaces
	        			]);
	        		}
	        		else{
	        				$checkIds = array();
	        				$checkPlaces = array();
	        				$checkIds[] = $checkInDataStored->id;
	        				$checkPlaces[] = $checkInDataStored->bus_stop_id;
	        		$incomeEntryDataStored = DailyIncomeEntry::create([	        				
	        				'bus_id' => $checkInDataStored->bus_id,
	        				'income' => $checkInIncomeDataStored->income,
	        				'check_in_ids' => $checkIds,
	        				'check_in_places' => $checkPlaces,
	        			]);
	        		}

	        		if (!empty($incomeEntryDataStored)) {
	        			Toastr::success(__('Record Stored Successfully.'));
	        			return redirect()->route('checkIn.index');
	        		}
	        		else{
	        			Toastr::error(__('Record Stored Failed.'));
	            		return redirect()->route('checkIn.index');
	        		}

	        	}
	        	else{
	        		Toastr::error(__('Record Stored Failed.'));
	            	return redirect()->route('checkIn.index');
	        	}
	        }
	        else{
	            Toastr::error(__('Record Stored Failed.'));
	            return redirect()->route('checkIn.index');
	        }
    	}
    	else{
    		Toastr::warning(__('Invalid Request!'));
            return redirect()->route('checkIn.index');
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
    	if (empty(Auth::user()->checkIn)) {
          	Toastr::warning(__('You Are Not Assigned To Check In Place Yet! Contact System Administration'));
          	return redirect()->route('home');
          }
          
        $checkIn = CheckIn::find($id);
        if (!empty($checkIn)) {
        	
        	$checkIns = CheckIn::orderBy('id','DESC')->where('checker_id',Auth::user()->id)->where('bus_stop_id',Auth::user()->checkIn->checkingPlace->id)->get()->load('checkInPassenger');

        	$busesOnCurrentRoute = Auth::user()->checkIn->checkingPlace->busRoute->busInRoute;

	        $busesBetween = array();
	        foreach ($busesOnCurrentRoute as $busId) {
	         	$busesBetween[] = $busId->id;
	        }

			$buses = Bus::orderBy('id','ASC')->whereIn('id',$busesBetween)->where('is_running',1)->cursor();

            return view('checker.check-in.edit',compact('checkIn','checkIns','buses'));
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('checkIn.index');
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
            'bus' => 'required',
            'staff' => 'sometimes|nullable|numeric|min:0|lte:total',
            'student' => 'sometimes|nullable|numeric|min:0|lte:total',
            'physical' => 'sometimes|nullable|numeric|min:0|lte:total',
            'total' => 'required|numeric|min:0',
        ]);
    	   	
    	
    	$bus = Bus::where('id',$request->bus_route)->where('is_running',1)->get();
    	$checkInFind = CheckIn::where('id',$id)->first();
    	if (!empty($bus) && !empty($checkInFind)) {
    		$checkInDataUpdated = $checkInFind->update([
	            'checker_id' => Auth::user()->id,
	            'bus_id' => $request->bus,
	            'bus_stop_id' => Auth::user()->checkIn->checkingPlace->id
	        ]);	        
    		$checkIn = CheckIn::where('id',$id)->first();
	        if ($checkInDataUpdated == true) {
	        	if ($request->has('student') && $request->student != null) {
	        		$student = $request->student;
	        	}
	        	else{
	        		$student = 0;
	        	}
	        	
	        	if ($request->has('staff') && $request->staff != null) {
	        		$staff = $request->staff;
	        	}
	        	else{
	        		$staff = 0;
	        	}

	        	if ($request->has('physical') && $request->physical != null) {
	        		$physical = $request->physical;
	        	}
	        	else{
	        		$physical = 0;
	        	}

	        	$passengersDataUpdated = $checkIn->checkInPassenger()->update([
	        		'checkIn_id' => $checkIn->id,
	        		'student' => $student,
	        		'staff' => $staff,
	        		'physically_disabled' => $physical,
	        		'total' => $request->total
	        	]);

	        	if ($passengersDataUpdated == true) {
	        		// Check if its the starting place or not
	        		$place = $checkIn->bus_stop_id;
	        		$checkPlace = TicketPricing::where('to_where',$place)->first();

	        		if (!empty($checkPlace)) {

	        			$oldCheckInIncome = $checkIn->checkInPassenger->checkInIncome->income;

	        			$regular = PassengerCategory::where('passenger_category','Regular')->first('cost_in_percentage');
	        			$student = PassengerCategory::where('passenger_category','Student')->first('cost_in_percentage');
	        			$staff = PassengerCategory::where('passenger_category','Staff')->first('cost_in_percentage');
	        			$physicallyDisabled = PassengerCategory::where('passenger_category','Physically Disabled')->first('cost_in_percentage');
	        			$checkInIncome = (($regular->cost_in_percentage / 100) * $checkIn->checkInPassenger->total * $checkPlace->price) - (($student->cost_in_percentage / 100) * $checkIn->checkInPassenger->student * $checkPlace->price) - (($staff->cost_in_percentage / 100) * $checkIn->checkInPassenger->staff * $checkPlace->price) - (($physicallyDisabled->cost_in_percentage / 100) * $checkIn->checkInPassenger->physically_disabled * $checkPlace->price);

	        			$checkInIncomeDataStored = $checkIn->checkInPassenger->checkInIncome->update([
	        				'checkInPass_id' => $checkIn->checkInPassenger->id,
	        				'income' => $checkInIncome
	        			]);

	        		}
	        		else{
	        			$checkInIncome = 0 ;
	        			$checkInIncomeDataStored = $checkIn->checkInPassenger->checkInIncome->update([
	        				'checkInPass_id' => $checkIn->checkInPassenger->id,
	        				'income' => $checkInIncome
	        			]);
	        		}

	        		$busEntryCurrentDate = DailyIncomeEntry::where('bus_id',$checkIn->bus_id)->whereDate('created_at',$checkIn->created_at)->first();
	        		if (!empty($busEntryCurrentDate)) {

	        			$checkIds = array();
	        			foreach ($busEntryCurrentDate->check_in_ids as $id) {
	        				$checkIds[] = $id;
	        			}
	        			$checkIds[] = $checkIn->id;

	        			$checkPlaces = array();
	        			foreach ($busEntryCurrentDate->check_in_places as $place) {
	        				$checkPlaces[] = $place;
	        			}
	        			$checkPlaces[] = $checkIn->bus_stop_id;

	        			$incomeEntryDataUpdated = $busEntryCurrentDate->update([
	        				'income' => $busEntryCurrentDate->income - $oldCheckInIncome + $checkIn->checkInPassenger->checkInIncome->income
	        			]);
	        		}
	        		else{
	        				$checkIds = array();
	        				$checkPlaces = array();
	        				$checkIds[] = $checkIn->id;
	        				$checkPlaces[] = $checkIn->bus_stop_id;
	        				$incomeEntryDataStored = DailyIncomeEntry::create([	        				
	        				'bus_id' => $checkIn->bus_id,
	        				'income' => $checkIn->checkInPassenger->checkInIncome->income,
	        				'check_in_ids' => $checkIds,
	        				'check_in_places' => $checkPlaces,
	        				]);

	        		}

	        		if ($incomeEntryDataUpdated == true || !empty($incomeEntryDataStored)) {
	        			Toastr::success(__('Record Update Successfully.'));//orginal
	        			return redirect()->route('checkIn.index');
	        		}
	        		else{
	        			Toastr::error(__('Record Update Failed.'));
	            		return redirect()->route('checkIn.index');
	        		}

	        	}
	        	else{
	        		Toastr::error(__('Record Update Failed.'));
	            	return redirect()->route('checkIn.index');
	        	}
	        }
	        else{
	            Toastr::error(__('Record Update Failed.'));
	            return redirect()->route('checkIn.index');
	        }
    	}
    	else{
    		Toastr::warning(__('Invalid Request!'));
            return redirect()->route('checkIn.index');
    	}
        
    }

}
