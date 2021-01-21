<?php

namespace App\Http\Controllers\Admin;

use App\Complain;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComplainController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:complains-list|complains-create|complains-edit|complains-delete', ['only' => ['index','store']]);
         $this->middleware('permission:complains-create', ['only' => ['create','store']]);
         $this->middleware('permission:complains-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:complains-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App\
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $complains = Complain::orderBy('id','DESC')->get()->load('checker');
        return view('admin.complains.index', compact('complains'));
    }


    /**
     * Make the unseen complains seen
     *
     * @param  \App\Complain
     * @return \Illuminate\View\View
     */
    public function complainSeen($id)
    {
        $complain = Complain::where('id',$id)->first();
        if (!empty($complain)) {
        	$complain->update(['is_seen' => true ]);
        	$complain = Complain::where('id',$id)->first()->load('checker');

        	return view('admin.complains.show', compact('complain'));
        }
        else{
        	Toastr::warning('Invalid Request!');
        	return redirect()->route('allComplains.index');
        }
        
    }

}
