<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    //
    public function index(){
        return view("client.trangChu");    
    }

    public function trainers()
    {
        $trainers = Trainer::with('user')->where('is_available', 1)->get();
        return view("client.huanLuyenVien", compact('trainers'));
    }

    public function schedule(Request $request)
    {
        // Nhóm lịch theo ngày trong tuần (2 -> 8)
        $schedules = Schedule::with('trainer.user')
            ->where('status', 'upcoming')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->start_time)->dayOfWeek + 1; // 1 (Sun) to 7 (Sat) in PHP, we want 2 to 8
            });

        return view("client.lichLop", compact('schedules'));
    }

    public function contact(){
        return view("client.lienHe");
    }

    public function news(){
        return view("client.tinTuc");
    }

    public function newsDetail($id){
        return view("client.tinTucChiTiet");
    }
}
