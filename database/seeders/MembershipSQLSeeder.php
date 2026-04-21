<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipSQLSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('memberships')->insert([
            ['id' => 1, 'name' => 'Gym 1 Tháng', 'category' => 'gym', 'description' => 'Tập tự do khu thể hình, không PT', 'duration_days' => 30, 'price' => 300000.00, 'allow_pt' => 0, 'pt_sessions' => 0, 'is_active' => 1, 'created_at' => '2026-04-02 22:34:26', 'updated_at' => '2026-04-02 22:34:26'],
            ['id' => 2, 'name' => 'Gym 1 Tháng + 4 Buổi PT', 'category' => 'gym', 'description' => 'Tập tự do + 4 buổi hướng dẫn cùng PT', 'duration_days' => 30, 'price' => 800000.00, 'allow_pt' => 1, 'pt_sessions' => 4, 'is_active' => 1, 'created_at' => '2026-04-02 22:34:26', 'updated_at' => '2026-04-02 22:34:26'],
            ['id' => 3, 'name' => 'Gym 1 Tháng + 12 Buổi PT', 'category' => 'gym', 'description' => 'Tập tự do + 12 buổi PT, ưu tiên đặt lịch', 'duration_days' => 30, 'price' => 1500000.00, 'allow_pt' => 1, 'pt_sessions' => 12, 'is_active' => 1, 'created_at' => '2026-04-02 22:34:26', 'updated_at' => '2026-04-02 22:34:26'],
            ['id' => 4, 'name' => 'Yoga 1 Tháng', 'category' => 'yoga', 'description' => 'Tham gia không giới hạn lớp yoga trong tháng', 'duration_days' => 30, 'price' => 350000.00, 'allow_pt' => 0, 'pt_sessions' => 0, 'is_active' => 1, 'created_at' => '2026-04-02 22:34:26', 'updated_at' => '2026-04-02 22:34:26'],
            ['id' => 5, 'name' => 'Yoga 1 Tháng + 4 Buổi PT', 'category' => 'yoga', 'description' => 'Lớp yoga + 4 buổi tập riêng cùng HLV yoga', 'duration_days' => 30, 'price' => 900000.00, 'allow_pt' => 1, 'pt_sessions' => 4, 'is_active' => 1, 'created_at' => '2026-04-02 22:34:26', 'updated_at' => '2026-04-02 22:34:26'],
        ]);
    }
}
