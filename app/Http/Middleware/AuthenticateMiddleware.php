<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateMiddleware
{
    public function handle(Request $request, Closure $next, $status)
    {
        if (session('status') !== $status) {
            return redirect('/')->withErrors(['error' => 'Akses ditolak.']);
        }

        return $next($request);
    }
}
