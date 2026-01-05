<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user login? Jika tidak, lempar ke login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Cek apakah role-nya BUKAN admin?
        if (Auth::user()->role !== 'admin') {
            return redirect('dashboard')->with('error', 'Akses ditolak! Halaman ini khusus Admin.');
        }

        // 3. Jika lolos semua, silakan lanjut
        return $next($request);
    }
}