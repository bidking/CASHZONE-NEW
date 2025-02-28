<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next, $status)
    {
        if (!session()->has('user') || session('status') !== $status) {
            return redirect('/'); // Redirect jika status tidak sesuai
        }

        return $next($request);
    }
}