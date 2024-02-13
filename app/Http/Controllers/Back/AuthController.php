<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::attempt(['admin_email' => $request->email, 'password' => $request->password])) {
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
