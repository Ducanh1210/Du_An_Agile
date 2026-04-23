<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StaffRole
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role !== 'staff') {
            return redirect('/')->with('error', 'Trang này chỉ dành cho nhân viên!');
        }

        return $next($request);
    }
}
