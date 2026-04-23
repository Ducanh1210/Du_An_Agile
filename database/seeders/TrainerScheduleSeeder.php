<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TrainerScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo Users cho HLV (Chỉ tập trung Gym & Yoga)
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
                'email' => 'hung.bodybuilding@extrafit.vn',
                'specialization' => 'gym',
                'avatar' => 'https://images.unsplash.com/photo-1534367507873-d2d7e24c797f?w=500&q=80&auto=format&fit=crop'
            ],
            [
                'name' => 'Phạm Thu Hà',
                'email' => 'ha.yoga@extrafit.vn',
                'specialization' => 'yoga',
                'avatar' => 'https://images.unsplash.com/photo-1609899537878-49e9196c5bcd?w=500&q=80&auto=format&fit=crop'
            ],
        ];

        foreach ($trainerData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('123456'),
                    'role' => 'trainer',
                    'avatar_url' => $data['avatar'],
                    'is_active' => 1,
                    'specialization' => $data['specialization'],
                    'is_available' => 1,
                ]
            );

            $trainer = $user;

            // 2. Tạo Lịch lớp mẫu thực tế cho 14 ngày tới
            $titles = [
                'gym' => ['Ngực & Tay Sau (Bodybuilding)', 'Lưng Xô & Tay Trước', 'Chân & Mông (Lower Body)', 'Vai & Bụng (Core)'],
                'yoga' => ['Hatha Yoga Cơ Bản', 'Vinyasa Flow Năng Lượng', 'Yoga Trị Liệu Cột Sống', 'Thiền Định & Phục Hồi']
            ];

            for ($day = 0; $day < 14; $day++) {
                $date = Carbon::today()->addDays($day);
                
                // Mỗi HLV dạy 2-3 lớp/ngày
                $slots = [8, 10, 15, 17, 19];
                $dailyClassesCount = rand(2, 3);
                $selectedSlots = (array) array_rand(array_flip($slots), $dailyClassesCount);

                foreach ($selectedSlots as $hour) {
                    $startTime = (clone $date)->setHour($hour)->setMinute(0);
                    
                    Schedule::create([
                        'title' => $titles[$data['specialization']][rand(0, 3)],
                        'category' => $data['specialization'],
                        'trainer_id' => $trainer->id,
                        'start_time' => $startTime,
                        'end_time' => (clone $startTime)->addHours(1),
                        'capacity' => 15,
                        'current_enrolled' => rand(0, 15),
                        'status' => 'upcoming'
                    ]);
                }
            }
        }
    }
}
