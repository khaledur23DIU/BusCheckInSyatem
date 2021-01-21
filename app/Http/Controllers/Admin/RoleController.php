<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
    
class RoleController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::orderBy('id','ASC')->get();
        $permissions = Permission::orderBy('id','ASC')->get()->groupBy('module');
        return view('admin.roles.index',compact('roles','permissions'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
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
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));

        Toastr::success(__('Record Successfully Created'));
        return redirect()->route('roles.index');
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        if (!empty($role) && $role->id != '1') {
            $roles = Role::orderBy('id','ASC')->get();
            $permissions = Permission::orderBy('id','ASC')->get()->groupBy('module');
            $rolePermissions = $role->permissions->all();
            return view('admin.roles.edit',compact('role','permissions','rolePermissions','roles'));
        }
        else{
            Toastr::warning(__('No Permission to Edit!'));
            return redirect(route('roles.index'));
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
            'name' => 'required',
            'permissions' => 'required',
        ]);
    
        $role = Role::find($id);
        if (!empty($role) && $role->id != '1') {
        $role->name = $request->input('name');
        $role->save();
    
        $role->syncPermissions($request->input('permissions'));
        Toastr::success(__('Record Updated Successfully.'));
        return redirect()->route('roles.index');
        }
        else{
            Toastr::warning(__('No Permission to Update!'));
            return redirect(route('roles.index'));
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
        if ($id == 1 || $id == 2 ) {
            Toastr::warning('No Permission to Delete!');
            return redirect(route('roles.index'));
        }
        
        $role = Role::find($id);
        if (!empty($role) && $role->id != '1') {
            $role->delete();
        Toastr::success(__('Record Deleted Successfully'));
        return redirect()->route('roles.index');
        }
        else{
            Toastr::warning(__('No Permission to Delete!'));
            return redirect(route('roles.index'));
        }
    }
}