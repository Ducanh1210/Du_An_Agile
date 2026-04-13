<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Khởi tạo mảng dữ liệu gói tập
        $memSeed = [
            [
                'name' => 'Gym 1 Tháng',
                'category' => 'gym',
                'description' => 'Tập tự do khu thể hình, không PT',
                'duration_days' => 30,
                'price' => 300000,
                'allow_pt' => 0,
                'pt_sessions' => 0,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gym 1 Tháng + 4 Buổi PT',
                'category' => 'gym',
                'description' => 'Tập tự do + 4 buổi hướng dẫn cùng PT',
                'duration_days' => 30,
                'price' => 800000,
                'allow_pt' => 1,
                'pt_sessions' => 4,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gym 1 Tháng + 12 Buổi PT',
                'category' => 'gym',
                'description' => 'Tập tự do + 12 buổi PT, ưu tiên đặt lịch',
                'duration_days' => 30,
                'price' => 1500000,
                'allow_pt' => 1,
                'pt_sessions' => 12,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Yoga 1 Tháng',
                'category' => 'yoga',
                'description' => 'Tham gia không giới hạn lớp yoga trong tháng',
                'duration_days' => 30,
                'price' => 350000,
                'allow_pt' => 0,
                'pt_sessions' => 0,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Yoga 1 Tháng + 4 Buổi PT',
                'category' => 'yoga',
                'description' => 'Lớp yoga + 4 buổi tập riêng cùng HLV yoga',
                'duration_days' => 30,
                'price' => 900000,
                'allow_pt' => 1,
                'pt_sessions' => 4,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Thực hiện insert dữ liệu theo form mẫu
        DB::table(table: 'memberships')->insert($memSeed);
    }
}
