<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('back.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required | email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['user_email' => $request->email, 'password' => $request->password])) {
            toastr('Welcome back '. Str::upper(Auth::user()->user_name,'info'));
            return redirect()->route('admin.dashboard');
        }
        else
            return redirect()->route('admin.login')->with('status','Email or password incorrect!');
        
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
