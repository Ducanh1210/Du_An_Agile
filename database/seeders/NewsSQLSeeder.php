<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSQLSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed News Categories
        DB::table('news_categories')->insert([
            ['id' => 1, 'name' => 'Khuyến mãi', 'slug' => 'khuyen-mai', 'description' => 'Các chương trình ưu đãi mới nhất.', 'is_active' => 1, 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
            ['id' => 2, 'name' => 'Kiến thức tập luyện', 'slug' => 'kien-thuc-tap-luyen', 'description' => 'Hướng dẫn kỹ thuật và bài tập.', 'is_active' => 1, 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
            ['id' => 3, 'name' => 'Dinh dưỡng', 'slug' => 'dinh-duong', 'description' => 'Chế độ ăn uống lành mạnh.', 'is_active' => 1, 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
            ['id' => 4, 'name' => 'Sự kiện', 'slug' => 'su-kien', 'description' => 'Các sự kiện tại phòng gym.', 'is_active' => 1, 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
        ]);

        // 2. Seed News Tags
        DB::table('news_tags')->insert([
            ['id' => 1, 'name' => 'Giảm cân', 'slug' => 'giam-can', 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
            ['id' => 2, 'name' => 'Tăng cơ', 'slug' => 'tang-co', 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
            ['id' => 3, 'name' => 'Sức khỏe', 'slug' => 'suc-khoe', 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
            ['id' => 4, 'name' => 'Động lực', 'slug' => 'dong-luc', 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
            ['id' => 5, 'name' => 'Lifestyle', 'slug' => 'lifestyle', 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
            ['id' => 6, 'name' => 'Workout', 'slug' => 'workout', 'created_at' => '2026-04-17 13:01:30', 'updated_at' => '2026-04-17 13:01:30'],
        ]);

        // 3. Seed News
        $news = [
            [1, 'Bài viết tin tức mẫu số 1', 'bai-viet-tin-tuc-mau-so-1', 'news/P5Wg334CnOWmK9wlLa6fgjqJhGjHtEtYGglxriDx.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 1.', 1, 1, 'published', 1, 2622],
            [2, 'Bài viết tin tức mẫu số 2', 'bai-viet-tin-tuc-mau-so-2', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 2.', 4, 1, 'published', 1, 3033],
            [3, 'Bài viết tin tức mẫu số 3', 'bai-viet-tin-tuc-mau-so-3', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 3.', 2, 1, 'published', 1, 3968],
            [4, 'Bài viết tin tức mẫu số 4', 'bai-viet-tin-tuc-mau-so-4', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 4.', 3, 1, 'published', 0, 4833],
            [5, 'Bài viết tin tức mẫu số 5', 'bai-viet-tin-tuc-mau-so-5', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 5.', 1, 1, 'published', 0, 1145],
            [6, 'Bài viết tin tức mẫu số 6', 'bai-viet-tin-tuc-mau-so-6', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 6.', 2, 1, 'published', 0, 3192],
            [7, 'Bài viết tin tức mẫu số 7', 'bai-viet-tin-tuc-mau-so-7', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 7.', 3, 1, 'published', 0, 2805],
            [8, 'Bài viết tin tức mẫu số 8', 'bai-viet-tin-tuc-mau-so-8', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 8.', 1, 1, 'published', 0, 2534],
            [9, 'Bài viết tin tức mẫu số 9', 'bai-viet-tin-tuc-mau-so-9', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 9.', 4, 1, 'published', 0, 4174],
            [10, 'Bài viết tin tức mẫu số 10', 'bai-viet-tin-tuc-mau-so-10', 'news/default.jpg', 'Đây là mô tả ngắn cho bài viết tin tức mẫu số 10.', 2, 1, 'published', 0, 3019],
        ];

        foreach ($news as $item) {
            DB::table('news')->insert([
                'id' => $item[0],
                'title' => $item[1],
                'slug' => $item[2],
                'image' => $item[3],
                'excerpt' => $item[4],
                'content' => '<p>Nội dung chi tiết cho ' . $item[1] . '</p>',
                'category_id' => $item[5],
                'author_id' => $item[6],
                'news_status' => $item[7],
                'is_featured' => $item[8],
                'views' => $item[9],
                'created_at' => '2026-04-17 13:01:30',
                'updated_at' => '2026-04-17 13:01:30',
                'published_at' => '2026-04-17 13:01:30',
            ]);
        }

        // 4. Seed Pivot Tags
        DB::table('news_post_tag')->insert([
            ['news_id' => 1, 'news_tag_id' => 4], ['news_id' => 1, 'news_tag_id' => 1],
            ['news_id' => 2, 'news_tag_id' => 5], ['news_id' => 2, 'news_tag_id' => 4],
            ['news_id' => 3, 'news_tag_id' => 3], ['news_id' => 3, 'news_tag_id' => 6],
            ['news_id' => 4, 'news_tag_id' => 3], ['news_id' => 4, 'news_tag_id' => 5],
            ['news_id' => 5, 'news_tag_id' => 6], ['news_id' => 5, 'news_tag_id' => 2],
            ['news_id' => 6, 'news_tag_id' => 5], ['news_id' => 6, 'news_tag_id' => 1],
            ['news_id' => 7, 'news_tag_id' => 2], ['news_id' => 7, 'news_tag_id' => 4],
            ['news_id' => 8, 'news_tag_id' => 1], ['news_id' => 8, 'news_tag_id' => 3],
            ['news_id' => 9, 'news_tag_id' => 6], ['news_id' => 9, 'news_tag_id' => 5],
            ['news_id' => 10, 'news_tag_id' => 6], ['news_id' => 10, 'news_tag_id' => 1],
        ]);
    }
}
