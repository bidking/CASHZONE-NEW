<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Jika pengguna sudah login, redirect ke dashboard sesuai statusnya
        if (session()->has('user')) {
            $status = session('status');
            switch ($status) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'guru':
                    return redirect('/guru/dashboard');
                case 'siswa':
                    return redirect('/siswa/dashboard');
            }
        }

        return view('login.login'); // Tampilkan halaman login jika belum login
    }

    public function login(Request $request)
    {
        $request->validate([
            'id'       => 'required',
            'password' => 'required',
        ]);

        // Cek autentikasi dari semua model (Admin, Guru, Siswa)
        $user = $this->authenticateUser($request->id, $request->password);
        if ($user) {
            session(['user' => $user, 'status' => $user->status]);

            // Jika checkbox "Remember me" dicentang, simpan user id ke cookie selama 30 hari (30 hari * 24 jam * 60 menit)
            if ($request->has('remember')) {
                Cookie::queue('remember_me', $user->id, 60 * 24 * 30);
            }

            return redirect()->route($user->status . '.dashboard');
        }

        // Jika autentikasi gagal, kembalikan error
        return back()->withErrors(['error' => 'ID atau Password salah atau status tidak valid']);
    }

    private function authenticateUser($id, $password)
    {
        foreach ([Admin::class, Guru::class, Siswa::class] as $model) {
            $user = $model::where('id', $id)->first();
            if ($user && Hash::check($password, $user->password)) {
                return $user;
            }
        }
        return null;
    }

    public function logout()
    {
        // Hapus cookie remember_me bila ada
        Cookie::queue(Cookie::forget('remember_me'));
        session()->flush();
        return redirect('/');
    }
}
