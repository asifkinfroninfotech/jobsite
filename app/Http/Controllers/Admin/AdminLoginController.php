<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
	public function __construct()
	{
       $this->middleware('guest:admin',['except' => ['logout'] ] );
    }

    

    public function ShowLoginForm()
    {
        return view('admin.login');
    }

    public function Login( Request $request )
    {
    	$this->validate($request, [
           'user_name' => 'required',
           'password' => 'required|min:6'
    	]);
    	


    	if(Auth::guard('admin')
            ->attempt( ['username' => $request->user_name, 'password' => $request->password ], $request->remember)) { 
            if( Auth::guard('admin')->check() ) {
                return redirect()->route('admin.dashboard');
            }
            
        }
          
    	return redirect()->back()->withInput($request->only('email', 'remember'));
    } 

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }

}

