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
            UsersTableSeeder::class,
            MembershipsTableSeeder::class,
            EquipmentsTableSeeder::class,
            SchedulesTableSeeder::class,
            SubscriptionsTableSeeder::class,
            PaymentsTableSeeder::class,
            BookingsTableSeeder::class,
            NewsCategoriesTableSeeder::class,
            NewsTableSeeder::class,
            HealthMetricsTableSeeder::class,
            NotificationsTableSeeder::class,
        ]);
    }
}
