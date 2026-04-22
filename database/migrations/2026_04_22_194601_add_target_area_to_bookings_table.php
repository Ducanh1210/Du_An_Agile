<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $col) {
            $col->string('target_area')->nullable()->after('booking_type')->comment('Vùng tập: Tay, Chân, Bụng, Ngực, Lưng, Toàn thân...');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $col) {
            $col->dropColumn('target_area');
        });
    }
};
