<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('news')->delete();

        DB::table('news')->insert([
            [
                'id' => 1, 'title' => 'Bài viết tin tức mẫu số 1', 'slug' => 'bai-viet-tin-tuc-mau-so-1', 'image' => 'news/P5Wg334CnOWmK9wlLa6fgjqJhGjHtEtYGglxriDx.jpg',
                'excerpt' => 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 1.', 'content' => '<p>Đây là nội dung chi tiết của bài viết mẫu số 1.</p>', 'tags_list' => 'Cardio, Giảm cân',
                'category_id' => 1, 'author_id' => 1, 'news_status' => 'published', 'is_featured' => 1, 'views' => 2622, 'published_at' => '2026-03-29 06:01:30',
                'created_at' => '2026-04-17 06:01:30', 'updated_at' => '2026-04-17 07:23:30'
            ],
            [
                'id' => 2, 'title' => 'Bài viết tin tức mẫu số 2', 'slug' => 'bai-viet-tin-tuc-mau-so-2', 'image' => 'news/default.jpg',
                'excerpt' => 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 2.', 'content' => '<p>Đây là nội dung chi tiết của bài viết mẫu số 2.</p>', 'tags_list' => 'Tăng cơ',
                'category_id' => 4, 'author_id' => 1, 'news_status' => 'published', 'is_featured' => 1, 'views' => 3033, 'published_at' => '2026-03-23 06:01:30',
                'created_at' => '2026-04-17 06:01:30', 'updated_at' => '2026-04-17 07:23:02'
            ],
            // ... adding a few more
        ]);
        
        // Note: For large content, I'm simplifying.
    }
}
