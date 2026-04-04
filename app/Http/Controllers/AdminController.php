<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard chính cho Admin
     */
    public function index()
    {
        $stats = [
            'total_users' => \App\Models\User::count(),
            'total_memberships' => \App\Models\Membership::count(),
            'total_staff' => \App\Models\User::whereIn('role', ['staff', 'trainer', 'admin'])->count(),
            'active_memberships' => \App\Models\Membership::where('is_active', 1)->count(),
            'latest_users' => \App\Models\User::latest()->take(5)->get(),
        ];

        return view('dashboard', $stats);
    }
}
