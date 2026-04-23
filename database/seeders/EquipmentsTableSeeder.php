<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('equipments')->delete();

        DB::table('equipments')->insert([
            [
                'id' => 1,
                'name' => 'Máy chạy bộ Matrix T50',
                'description' => 'Máy chạy bộ cao cấp cho khu vực cardio',
                'status' => 'active',
                'last_maintained_at' => '2026-03-01',
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
            [
                'id' => 2,
                'name' => 'Xe đạp tập Gym Life',
                'description' => 'Xe đạp có màn hình theo dõi nhịp tim',
                'status' => 'active',
                'last_maintained_at' => '2026-03-15',
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
            [
                'id' => 3,
                'name' => 'Giàn tạ đa năng 4 mặt',
                'description' => 'Hệ thống tạ kéo lưng, chân, ngực',
                'status' => 'maintenance',
                'last_maintained_at' => '2026-04-10',
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
            [
                'id' => 4,
                'name' => 'Tạ tay Iron Bull (20kg)',
                'description' => 'Bộ tạ tay cao su cao cấp',
                'status' => 'active',
                'last_maintained_at' => null,
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
            [
                'id' => 5,
                'name' => 'Thảm tập Yoga Reebok',
                'description' => 'Thảm chống trượt 6mm',
                'status' => 'active',
                'last_maintained_at' => null,
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
            [
                'id' => 6,
                'name' => 'Bóng tập Gym Ball 65cm',
                'description' => 'Sử dụng cho các bài tập core',
                'status' => 'broken',
                'last_maintained_at' => '2026-04-12',
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
            [
                'id' => 7,
                'name' => 'Máy ép ngực thủy lực',
                'description' => 'Máy chuyên dụng tập cơ ngực',
                'status' => 'active',
                'last_maintained_at' => '2026-02-20',
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
            [
                'id' => 8,
                'name' => 'Gậy tập Pilates',
                'description' => 'Dụng cụ hỗ trợ giữ thăng bằng',
                'status' => 'active',
                'last_maintained_at' => null,
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
            [
                'id' => 9,
                'name' => 'Dây kháng lực TRX',
                'description' => 'Dụng cụ tập luyện treo người',
                'status' => 'active',
                'last_maintained_at' => '2026-04-01',
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
            [
                'id' => 10,
                'name' => 'Máy kéo xô King Fitness',
                'description' => 'Thiết bị tập cơ lưng xô chuyên nghiệp',
                'status' => 'active',
                'last_maintained_at' => '2026-03-20',
                'created_at' => '2026-04-13 05:39:19',
                'updated_at' => '2026-04-13 05:39:19',
            ],
        ]);
    }
}
