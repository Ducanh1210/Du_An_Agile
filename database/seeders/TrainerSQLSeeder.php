<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainerSQLSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('trainers')->insert([
            ['id' => 1, 'user_id' => 5, 'specialization' => 'gym', 'price_per_session' => 500000.00, 'is_available' => 1, 'created_at' => '2026-04-10 23:00:39', 'updated_at' => '2026-04-10 23:00:39'],
            ['id' => 2, 'user_id' => 6, 'specialization' => 'yoga', 'price_per_session' => 500000.00, 'is_available' => 1, 'created_at' => '2026-04-10 23:00:40', 'updated_at' => '2026-04-10 23:00:40'],
            ['id' => 3, 'user_id' => 7, 'specialization' => 'gym', 'price_per_session' => 500000.00, 'is_available' => 1, 'created_at' => '2026-04-10 23:00:40', 'updated_at' => '2026-04-10 23:00:40'],
            ['id' => 4, 'user_id' => 8, 'specialization' => 'both', 'price_per_session' => 500000.00, 'is_available' => 1, 'created_at' => '2026-04-10 23:00:40', 'updated_at' => '2026-04-10 23:00:40'],
            ['id' => 5, 'user_id' => 9, 'specialization' => 'both', 'price_per_session' => 500000.00, 'is_available' => 1, 'created_at' => '2026-04-11 07:15:38', 'updated_at' => '2026-04-11 07:15:38'],
            ['id' => 6, 'user_id' => 12, 'specialization' => 'gym', 'price_per_session' => 500000.00, 'is_available' => 1, 'created_at' => '2026-04-16 03:42:41', 'updated_at' => '2026-04-16 03:42:41'],
            ['id' => 7, 'user_id' => 13, 'specialization' => 'yoga', 'price_per_session' => 500000.00, 'is_available' => 1, 'created_at' => '2026-04-16 03:42:41', 'updated_at' => '2026-04-16 03:42:41'],
        ]);
    }
}
