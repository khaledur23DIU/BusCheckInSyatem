<?php

namespace App\Http\Controllers\Checker;

use App\Complain;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplainController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:checker-complain-list|checker-complain-create|checker-complain-edit|checker-complain-delete', ['only' => ['index','store']]);
         $this->middleware('permission:checker-complain-create', ['only' => ['create','store']]);
         $this->middleware('permission:checker-complain-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:checker-complain-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $complains = Complain::orderBy('id','DESC')->where('checker_id',Auth::user()->id)->cursor();
        return view('checker.complain.index', compact('complains'));
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
            'title' => 'required|string|min:5|max:255',
            'body' => 'required|string'
        ]);


        $dataStored = Complain::create([
            'checker_id' => Auth::user()->id,
            'title' => $request->title,
            'complain' => $request->body
        ]);
        
        if (!empty($dataStored)) {
            Toastr::success(__('Record Stored Successfully.'));
            return redirect()->route('checkerComplain.index');
        }
        else{
            Toastr::error(__('Record Stored Failed.'));
            return redirect()->route('checkerComplain.index');
        }
        
    }
    
    /**
     * Show the the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $complainFind = Complain::find($id);
        if (!empty($complainFind)) {
            $complain = $complainFind;
            return view('checker.complain.show',compact('complain'));
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('checkerComplain.index');
        }
        
    }
      
}
