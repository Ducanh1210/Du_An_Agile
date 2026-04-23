<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_memberships' => Membership::count(),
            'active_memberships' => Membership::where('is_active', 1)->count(),
            'total_schedules' => Schedule::count(),
            'today_schedules' => Schedule::whereDate('start_time', now()->toDateString())->count(),
            'latest_users' => User::latest()->take(5)->get(),
        ];

        return view('staff.dashboard', $stats);
    }
}
