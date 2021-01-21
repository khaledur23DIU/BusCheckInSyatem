<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request, $user)
    {
        if ($user->profile->account_status == 1) {
            if (Auth::user()->roles[0]->id != 2) {
                Toastr::success(__('Welcome to Dashboard'));
                return redirect(route('home'));
            }
            else if(Auth::user()->roles[0]->id == 2 && empty(Auth::user()->checkIn)== false ){
                Toastr::success(__('Welcome to Dashboard'));
                return redirect(route('home'));
            }
            else{
                
                $this->logout($request, $user)->with('message', 'Oops! You Are Not Assigned To Any Check In Place!!! Please Contact With Administration.');
                return redirect(route('login'));
            }
        }
        else{
            $this->logout($request, $user)->with('message', 'Oops! This Account Is Currently Inactive!!! Please Contact With Administration.');
            return redirect(route('login'));
        }
        
    }
}
