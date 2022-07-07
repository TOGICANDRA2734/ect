<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('layouts.admin.auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'pass' => 'required',
        ]);

        $user = User::where('user', request()->get('user'))->where('pass', request()->pass)->first();

        if($user){
            Auth::login($user);
            return redirect()->route('mp.index');
        }
        return redirect("login")->withSuccess("Login failed");
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();

        return redirect('login');
    }
}
