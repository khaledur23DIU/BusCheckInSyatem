<?php

namespace App\Http\Controllers\Admin;

use App\EmailService;
use App\Http\Controllers\Controller;
use App\SiteSetting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SiteSettingsController extends Controller
{
    public function __construct()
    {
    	 $this->middleware('auth');
    	 $this->middleware('permission:settings-list|settings-create|settings-edit|settings-delete', ['only' => ['settings','updateBasicInfo','language','languageDynamic','updateMeta'.'updateMailService']]);
         $this->middleware('permission:settings-create', ['only' => ['create','store']]);
         $this->middleware('permission:settings-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:settings-delete', ['only' => ['destroy']]);
	     
    }

    public function settings()
    {
    	$settings = SiteSetting::where('id',1)->first();
    	$mailSettings = EmailService::where('active',1)->first();
    	return view('admin.site-setting.index',compact('settings','mailSettings'));
    }

    public function updateBasicInfo(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'site_name' => 'sometimes|nullable|string|max:100',
            'site_email' => 'sometimes|nullable|email',
            'site_address' => 'sometimes|nullable|url',
            'footer_text' => 'sometimes|nullable|string|max:255',
            'site_description' => 'sometimes|nullable|string',
            
			]);

			if ($validator->fails()) {
			    return redirect(url('dashboard/settings'.'#general'))->withErrors($validator)->withInput();
			} 
		else {

			    $setting = SiteSetting::where('id',1)->first();
     			if (!empty($setting)) {

     				$setting->update([
     					'site_name' => $request->site_name,
     					'site_email' => $request->site_email,
     					'site_address' => $request->site_address,
     					'footer_text' => $request->footer_text,
     					'site_description' => $request->site_description,
     				]);

     				Toastr::success(__('Record Updated Successfully'));
     				return redirect(route('siteSetting.settings'));
     			}
     		else{
     				Toastr::error(__('Record Updated Failed'));
     				return redirect(route('dashboard'));
     			}
			}
    }

    
    public function updateMeta(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'meta_title' => 'sometimes|nullable|string|max:255',
            'meta_description' => 'sometimes|nullable|string'
            
			]);

			if ($validator->fails()) {
			    return redirect(url('dashboard/settings'.'#meta'))->withErrors($validator)->withInput();
			} 
		else {

			    $setting = SiteSetting::where('id',1)->first();
     			if (!empty($setting)) {

     				$setting->update([
     					'meta_title' => $request->meta_title,
     					'meta_description' => $request->meta_description
     				]);

     				Toastr::success(__('Record Updated Successfully'));
     				return redirect(route('siteSetting.settings'));
     			}
     		else{
     				Toastr::error(__('Record Updated Failed'));
     				return redirect(route('dashboard'));
     			}
			}
    }

    public function updateMailService(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'driver' => 'required|string|max:75',
            'host' => 'required|string|max:75',
            'port' => 'required|numeric',
            'username' => 'required|string|max:75',
            'password' => 'required',
            'mail_encryption' => 'required|string|max:15',
            'from_address' => 'required|string|max:100',
            'from_name' => 'required|string|max:100',
            
			]);

			if ($validator->fails()) {
			    return redirect(url('dashboard/settings'.'#mail-service'))->withErrors($validator)->withInput();
			} 
		else {

			    $mailService = EmailService::where('active',1)->first();
     			if (!empty($mailService)) {

     				$mailService->update([
     					'driver' => $request->driver,
     					'host' => $request->host,
     					'port' => $request->port,
     					'username' => $request->username,
     					'password' => Hash::make($request->password),
     					'mail_encryption' => $request->mail_encryption,
     					'from_address' => $request->from_address,
     					'from_name' => $request->from_name,
     				]);

     				Toastr::success(__('Record Updated Successfully'));
     				return redirect(route('siteSetting.settings'));
     			}
     		else{
     				Toastr::error(__('Record Updated Failed'));
     				return redirect(route('dashboard'));
     			}
			}
    }
}
