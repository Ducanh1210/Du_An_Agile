<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('membership_id')->constrained('memberships');
            $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('final_price', 12, 2)->comment('Giá thực tế khi đăng ký');
            $table->integer('pt_sessions_left')->default(0)->comment('Số buổi PT còn lại');
            $table->enum('status', ['pending_payment', 'active', 'expired', 'cancelled', 'frozen'])->default('pending_payment');
            $table->date('frozen_until')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->datetime('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
