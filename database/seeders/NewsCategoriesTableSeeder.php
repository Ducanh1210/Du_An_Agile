<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('news_categories')->delete();

        DB::table('news_categories')->insert([
            ['id' => 1, 'name' => 'Khuyến mãi', 'slug' => 'khuyen-mai', 'description' => 'Các chương trình ưu đãi mới nhất.', 'is_active' => 1, 'created_at' => '2026-04-17 06:01:30', 'updated_at' => '2026-04-17 06:01:30'],
            ['id' => 2, 'name' => 'Kiến thức tập luyện', 'slug' => 'kien-thuc-tap-luyen', 'description' => 'Hướng dẫn kỹ thuật và bài tập.', 'is_active' => 1, 'created_at' => '2026-04-17 06:01:30', 'updated_at' => '2026-04-17 06:01:30'],
            ['id' => 3, 'name' => 'Dinh dưỡng', 'slug' => 'dinh-duong', 'description' => 'Chế độ ăn uống lành mạnh.', 'is_active' => 1, 'created_at' => '2026-04-17 06:01:30', 'updated_at' => '2026-04-17 06:01:30'],
            ['id' => 4, 'name' => 'Sự kiện', 'slug' => 'su-kien', 'description' => 'Các sự kiện tại phòng gym.', 'is_active' => 1, 'created_at' => '2026-04-17 06:01:30', 'updated_at' => '2026-04-17 06:01:30'],
        ]);
    }
}
