<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Http\Requests\CreateUsersRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('front.customer.login');
    }

    public function loginAuthenticate(LoginRequest $request){

        $request->authenticate();
        $request->session()->regenerate();

        // $user = $request->user();
        Cart::moveCartItemsIntoDb();

        if(session()->has('url.intended')){
            return redirect(session()->get('url.intended'));
        }
        return redirect()->route('user.profile');
    }

    public function register(){
        return view('front.customer.register');
    }

    public function store(CreateUsersRequest $request){
        $data = $request->all();
        $user = User::create($data);

        event(new Registered($user));

        Auth::login($user);
        Cart::moveCartItemsIntoDb();
        
        return redirect()->route('user.profile');
    }

    public function profile(Request $request){
        $user = $request->user();
        return view('front.customer.profile', compact('user'));
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }
}
