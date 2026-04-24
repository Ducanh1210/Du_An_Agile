<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MembershipSeeder::class,
            EquipmentSeeder::class,
            NewsCategoriesTableSeeder::class,
            NewsCMSSeeder::class,
            SubscriptionSeeder::class,
            SchedulesTableSeeder::class,
            PaymentsTableSeeder::class,
            BookingsTableSeeder::class,
            HealthMetricsTableSeeder::class,
            NotificationsTableSeeder::class,
        ]);
    }
}
