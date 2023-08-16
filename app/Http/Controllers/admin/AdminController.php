<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        return view('admin.login');
    }

    public function authenticate(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->get('remember'))){

            $admin = Auth::guard('admin')->user();

            if($admin->role == 1){
                Auth::guard('admin')->logout();
                return back()->with('msg', 'You are not Authorized to access admin panel')
                            ->with('type', 'warning');
            }
            return redirect()->route('admin.dashboard');
        }
        
        return back()->with('msg', 'Email or password is invailid!')
                    ->with('type', 'danger')
                    ->withInput($request->only('email'));
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
