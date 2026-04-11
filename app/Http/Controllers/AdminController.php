<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard chính cho Admin
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_memberships' => Membership::count(),
            'total_staff' => User::whereIn('role', ['staff', 'trainer', 'admin'])->count(),
            'active_memberships' => Membership::where('is_active', 1)->count(),
            'latest_users' => User::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $stats);
    }

    /* Quản lý Lịch lớp (Schedules) */

    public function schedules()
    {
        $schedules = Schedule::with('trainer.user')->latest()->paginate(10);
        
        $stats = [
            'countAll' => Schedule::count(),
            'countToday' => Schedule::whereDate('start_time', now()->toDateString())->count(),
            'countUpcoming' => Schedule::where('status', 'upcoming')->count(),
            'countCancelled' => Schedule::where('status', 'cancelled')->count(),
        ];

        return view('admin.schedules.index', compact('schedules', 'stats'));
    }

    public function createSchedule()
    {
        $trainers = Trainer::with('user')->get();
        return view('admin.schedules.create', compact('trainers'));
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'trainer_id' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        Schedule::create($request->all());

        return redirect()->route('admin.schedules.index')->with('success', 'Tạo lịch lớp thành công!');
    }

    public function editSchedule($id)
    {
        $schedule = Schedule::findOrFail($id);
        $trainers = Trainer::with('user')->get();
        return view('admin.schedules.edit', compact('schedule', 'trainers'));
    }

    public function updateSchedule(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->route('admin.schedules.index')->with('success', 'Cập nhật lịch lớp thành công!');
    }

    public function deleteSchedule($id)
    {
        Schedule::findOrFail($id)->delete();
        return back()->with('success', 'Xóa lịch lớp thành công!');
    }
}
