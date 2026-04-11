<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrainerRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role !== 'trainer' && $request->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập khu vực huấn luyện viên!');
        }

        return $next($request);
    }
}
