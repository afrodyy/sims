<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // dd($request->session());
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);

            // Simpan token JWT ke dalam session
            $request->session()->put('jwt_token', $token);

            // Redirect ke rute /product setelah berhasil login
            return redirect('/products');
        }

        // Jika autentikasi gagal, kembalikan ke halaman login dengan pesan kesalahan
        return redirect()->back()->withErrors(['error' => 'Email atau password salah']);
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function profileUpdate(Request $request)
    {
        dd($request->all());
    }

    public function logout(Request $request)
    {
        $request->session()->forget('jwt_token');
        Auth::logout();

        return redirect('/login')->with('danger', 'Anda telah logout dari sistem');
    }
}
