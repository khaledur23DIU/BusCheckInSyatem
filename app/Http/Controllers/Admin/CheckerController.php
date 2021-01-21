<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use Brian2694\Toastr\Facades\Toastr;
use DB;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CheckerController extends Controller
{
    public function __construct()
    {
         
         $this->middleware('auth');
         $this->middleware('permission:checker-list|checker-create|checker-edit|checker-delete', ['only' => ['index','store']]);
         $this->middleware('permission:checker-create', ['only' => ['create','store']]);
         $this->middleware('permission:checker-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:checker-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing 
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $roles = Role::where('id',2)->first();
        $users = $roles->users;
        return view('admin.all-checker.index', compact('users','roles'));
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
            'name' => 'required|string|min:3|max:75',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'status' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $userNewProfile = new UserProfile();
        $userNewProfile->user_id = $user->id;
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
        $userNewProfile->account_status = $status;
        $profile = $userNewProfile->save();
        $user->assignRole($request->input('roles'));
        if (!empty($user) && !empty($profile)) {
            Toastr::success(__('Record Stored Successfully.'));
            Toastr::info(__('Please Assign New Checker To Check In Place'));
        return redirect()->route('checkers.index')
                        ->with('Record Stored Successfully.');
        }
        else{
            Toastr::error(__('Record Stored Failed.'));
            return redirect()->route('checkers.index');
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
        $user = User::findOrFail($id);
        if (!empty($user)) {
            if (Auth::user()->id == 1 && $id == Auth::user()->id) {
                return redirect()->route('profile.edit',Auth::user()->id);
            }
            else{
                $roles = Role::where('id',2)->first();
                $users = $roles->users;
                $userRoles = $user->roles->all();
                $permissions = Permission::orderBy('id','ASC')->get()->groupBy('module');
                return view('admin.all-checker.edit',compact('user','roles','userRoles','permissions','users'));
            }
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('checkers.index');
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
            'name' => 'required|string|min:3|max:75',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'sometimes|same:confirm-password',
            'roles' => 'required',
            'status' => 'required'
        ]);
        
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }
        else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::findOrFail($id);
        if ($user->id == 1) {
            Toastr::warning(__('No Permission To Update!'));
            return redirect()->route('dashboard');
        }
        else{
        if (!empty($user)) {
            $userUpdated = $user->update($input);
            if ($request->has('status')) {
                if ($request->status == '1') {
                    $status = true;
                }
                else if($request->status == '0'){
                    $status = false;
                }
                else{
                    $status = false;
                }

                $profileUpdated = $user->profile()->update(['account_status'=> $status]);
            }
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->input('roles'));
            if ($userUpdated == true && $profileUpdated == true) {

               Toastr::success(__('Record Updated Successfully.'));
                return redirect()->route('checkers.index'); 
            }
            else{
                Toastr::error(__('Record Updated Failed!'));
                return redirect()->route('checkers.index');
            }
            
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('checkers.index');
        }
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
        $user = User::find($id);
        if (!empty($user)) {
            if ($user->id != 1 && Auth::user()->id != $user->id) {

                $user->forceDelete();
            Toastr::success(__('Record Deleted Successfully.'));
            return redirect()->route('checkers.index')
                        ->with('success','Records Deleted Successfully');
            }
            else{
                Toastr::warning(__('Request Not Authorized'));
                return redirect(route('home'));
            }
            
        }
        else{
            Toastr::error(__('Record Not Found!'));
            return redirect()->route('checkers.index');
        }
        
    }
}
