<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HealthMetricsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('health_metrics')->delete();

        DB::table('health_metrics')->insert([
            ['id' => 1, 'user_id' => 3, 'trainer_id' => 5, 'weight' => 60.00, 'bmi' => 0.00, 'fat_percent' => 12.00, 'recorded_by' => 'trainer', 'created_at' => '2026-04-23 03:07:24', 'updated_at' => '2026-04-23 03:07:24'],
        ]);
    }
}
