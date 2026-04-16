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
        Schema::create('trial_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->enum('status', ['pending', 'contacted', 'converted', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamps();
            
            // Chống spam: 1 SĐT không đăng ký tập thử cùng 1 lớp 2 lần
            $table->unique(['phone', 'schedule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trial_registrations');
    }
};
