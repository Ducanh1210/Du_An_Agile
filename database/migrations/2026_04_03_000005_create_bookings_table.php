<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('subscription_id')->constrained('subscriptions');
            $table->enum('booking_type', ['class', 'pt_session']);
            $table->foreignId('schedule_id')->nullable()->constrained('schedules');
            $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->decimal('price', 12, 2)->default(0.00);
            $table->enum('payment_status', ['free', 'pending', 'paid'])->default('free');
            $table->enum('status', ['confirmed', 'cancelled', 'completed'])->default('confirmed');
            $table->enum('reschedule_status', ['none', 'pending', 'approved', 'rejected'])->default('none');
            $table->text('reschedule_reason')->nullable();
            $table->timestamp('reschedule_at')->nullable();
            $table->text('report_content')->nullable();
            $table->integer('effort_rating')->nullable();
            $table->string('session_intensity')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
