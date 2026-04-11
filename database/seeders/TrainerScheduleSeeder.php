<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Trainer;
use App\Models\Schedule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TrainerScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo Users cho HLV
        $trainerData = [
            [
                'name' => 'Nguyễn Minh Tuấn',
                'email' => 'tuan.gym@extrafit.vn',
                'specialization' => 'gym',
                'avatar' => 'https://images.unsplash.com/photo-1567013127542-490d757e51cd?w=500&q=80&auto=format&fit=crop'
            ],
            [
                'name' => 'Trần Thị Lan',
                'email' => 'lan.yoga@extrafit.vn',
                'specialization' => 'yoga',
                'avatar' => 'https://images.unsplash.com/photo-1548690312-e3b507d8c110?w=500&q=80&auto=format&fit=crop'
            ],
            [
                'name' => 'Lê Văn Hùng',
                'email' => 'hung.boxing@extrafit.vn',
                'specialization' => 'gym',
                'avatar' => 'https://images.unsplash.com/photo-1534367507873-d2d7e24c797f?w=500&q=80&auto=format&fit=crop'
            ],
            [
                'name' => 'Phạm Thu Hà',
                'email' => 'ha.fitness@extrafit.vn',
                'specialization' => 'both',
                'avatar' => 'https://images.unsplash.com/photo-1609899537878-49e9196c5bcd?w=500&q=80&auto=format&fit=crop'
            ],
        ];

        foreach ($trainerData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'trainer',
                'avatar_url' => $data['avatar'],
                'is_active' => 1,
            ]);

            $trainer = Trainer::create([
                'user_id' => $user->id,
                'specialization' => $data['specialization'],
                'is_available' => 1,
            ]);

            // 2. Tạo Lịch lớp mẫu cho mỗi HLV
            $titles = [
                'gym' => ['Body Building', 'Power Lifting', 'Core Strength', 'HIIT Cardio'],
                'yoga' => ['Hatha Yoga', 'Vinyasa Flow', 'Meditation', 'Power Yoga'],
                'both' => ['CrossFit', 'Zumba Dance', 'Kick Boxing', 'Yoga Recovery']
            ];

            foreach (range(1, 10) as $i) {
                $category = ($data['specialization'] == 'both') ? (rand(0, 1) ? 'gym' : 'yoga') : $data['specialization'];
                $startTime = Carbon::now()->startOfWeek()->addDays(rand(0, 6))->setHour(rand(6, 20))->setMinute(0);
                
                Schedule::create([
                    'title' => $titles[$data['specialization']][rand(0, 3)],
                    'category' => $category,
                    'trainer_id' => $trainer->id,
                    'start_time' => $startTime,
                    'end_time' => (clone $startTime)->addHours(1),
                    'capacity' => 20,
                    'current_enrolled' => rand(5, 18),
                    'status' => 'upcoming'
                ]);
            }
        }
    }
}
