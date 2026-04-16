<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `payments` MODIFY COLUMN `status` ENUM('pending', 'completed', 'refunded', 'cancelled') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `payments` MODIFY COLUMN `status` ENUM('pending', 'completed', 'refunded') DEFAULT 'pending'");
    }
};
