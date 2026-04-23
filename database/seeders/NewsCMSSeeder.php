<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NewsCMSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Tin tức',
            'Dinh dưỡng',
            'Tập luyện',
            'Sức khỏe',
            'Sự kiện'
        ];

        $categoryIds = [];

        foreach ($categories as $cat) {
            $category = NewsCategory::firstOrCreate(
                ['slug' => Str::slug($cat)],
                ['name' => $cat, 'description' => "Danh mục $cat"]
            );
            $categoryIds[$cat] = $category->id;
        }

        $tags = ['Fitness', 'Yoga', 'Cardio', 'Giảm cân', 'Tăng cơ', 'Sống khỏe'];
        foreach ($tags as $tag) {
            NewsTag::firstOrCreate(
                ['slug' => Str::slug($tag)],
                ['name' => $tag]
            );
        }

        // Cập nhật các bài viết cũ nếu đang dùng category string
        // Note: Cột category sẽ bị drop sau migration update_news_table_for_categories
        // nên ta cần chạy script này _trước_ khi chạy migration thứ 5 (nếu muốn giữ data)
        // Nhưng vì migration chạy theo thứ tự file, update_news_table_for_categories sẽ drop `category`
        // Do đó ta sẽ map qua DB data nếu cần.
    }
}
