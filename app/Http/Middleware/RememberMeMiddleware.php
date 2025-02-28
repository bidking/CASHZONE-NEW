<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\Siswa;

class RememberMeMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user') && Cookie::has('remember_me')) {
            // Karena cookie dienkripsi secara default oleh Laravel,
            // kita dapat langsung mendapatkan user id dari cookie
            $userId = Cookie::get('remember_me');
            // Cari user di salah satu model: Admin, Guru, atau Siswa
            $user = Admin::find($userId) ?? Guru::find($userId) ?? Siswa::find($userId);
            if ($user) {
                session(['user' => $user, 'status' => $user->status]);
            }
        }
        return $next($request);
    }
}
