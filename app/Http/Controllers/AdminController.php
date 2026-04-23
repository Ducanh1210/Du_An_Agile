<?php

namespace App\Http\Controllers;

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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

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

    public function schedules(Request $request)
    {
        $now = now();
        $currentMonth = (int) $request->get('month', $now->month);
        $currentYear = (int) $request->get('year', $now->year);

        // Validate: chỉ cho phép xem tháng hiện tại và 2 tháng tiếp theo
        $allowedMonths = [];
        for ($i = 0; $i < 3; $i++) {
            $d = $now->copy()->addMonths($i);
            $allowedMonths[] = $d->year . '-' . $d->month;
        }

        if (!in_array($currentYear . '-' . $currentMonth, $allowedMonths)) {
            $currentMonth = $now->month;
            $currentYear = $now->year;
        }

        $startOfMonth = \Carbon\Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // Lấy tất cả schedule trong tháng đang xem
        $schedules = Schedule::with('trainer')
            ->whereBetween('start_time', [$startOfMonth, $endOfMonth])
            ->orderBy('start_time', 'asc')
            ->get();

        // Group theo ngày
        $schedulesByDate = $schedules->groupBy(function ($schedule) {
            return \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d');
        });

        $stats = [
            'countAll' => Schedule::count(),
            'countToday' => Schedule::whereDate('start_time', $now->toDateString())->count(),
            'countUpcoming' => Schedule::where('status', 'upcoming')
                ->where('start_time', '>', $now)
                ->count(),
            'countCancelled' => Schedule::where('status', 'cancelled')->count(),
            'countThisMonth' => $schedules->count(),
        ];

        // Build allowed months data for navigation
        $monthsNav = [];
        for ($i = 0; $i < 3; $i++) {
            $d = $now->copy()->addMonths($i);
            $monthsNav[] = [
                'month' => $d->month,
                'year' => $d->year,
                'label' => 'Tháng ' . $d->month . '/' . $d->year,
                'active' => ($d->month == $currentMonth && $d->year == $currentYear),
            ];
        }

        return view('admin.schedules.index', compact(
            'schedules', 'schedulesByDate', 'stats',
            'currentMonth', 'currentYear', 'monthsNav',
            'startOfMonth', 'endOfMonth'
        ));
    }

    public function createSchedule()
    {
        $trainers = User::where('role', 'trainer')->get();
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
        $trainers = User::where('role', 'trainer')->get();
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
