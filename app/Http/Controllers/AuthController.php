<?php

namespace App\Http\Controllers;

use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
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
        return redirect('login')->with('danger', 'Email atau password yang anda masukkan salah!');
    }

    public function profile()
    {
        return view('auth.profile');
    }

    public function profileUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        if ($request->hasFile('image')) {
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpg,png',
            ]);

            if ($user->image_path !== null) {
                $response = Cloudinary::destroy($user->image_public_id);
            }

            // Simpan gambar ke cloudinary
            $imagePath = Cloudinary::upload($request->file('image')->getRealPath());
            $user->avatar = $imagePath->getSecurePath();
            $user->public_image_id = $imagePath->getPublicId();
        }

        $user->update();

        return redirect('/profile')->with('success', 'Avatar berhasil diperbarui.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('jwt_token');
        Auth::logout();

        return redirect('/login')->with('danger', 'Anda telah logout dari sistem');
    }
}
