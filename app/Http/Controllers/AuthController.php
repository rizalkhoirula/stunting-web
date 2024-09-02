<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.pages.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            return redirect('/dashboard')->with('login', 'Login berhasil');
        }

        return redirect()->back()->with('error', 'Email atau Password salah');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('logout', 'Logout berhasil');
    }
}
