<?php

namespace App\Http\Controllers\Admin;

use App\CheckIn;
use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:all-Check-in-list|all-Check-in-create|all-Check-in-edit|all-Check-in-delete', ['only' => ['index','store']]);
         $this->middleware('permission:all-Check-in-create', ['only' => ['create','store']]);
         $this->middleware('permission:all-Check-in-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:all-Check-in-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $checkIns = CheckIn::orderBy('id','DESC')->get()->load(['checkInPassenger','checker','bus','busStop']);
        return view('admin.check-in.index', compact('checkIns'));
    }


    /**
     * Display a listing of all check in by checker
     *
     * @param  \App\CheckIn
     * @return \Illuminate\View\View
     */
    public function checkInsByChecker($id)
    {
        $checker = User::where('id',$id)->first();
        if (!empty($checker)) {
        	$checkIns = CheckIn::orderBy('id','DESC')->where('checker_id',$id)->get()->load(['checkInPassenger','checker','bus','busStop']);

        	return view('admin.checkers.index', compact('checkIns','checker'));
        }
        else{
        	Toastr::warning('Invalid Request!');
        	return redirect()->back();
        }
        
    }
}
