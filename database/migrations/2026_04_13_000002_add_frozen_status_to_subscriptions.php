<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('pending_payment', 'active', 'expired', 'cancelled', 'frozen') DEFAULT 'pending_payment'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('pending_payment', 'active', 'expired', 'cancelled') DEFAULT 'pending_payment'");
    }
};
