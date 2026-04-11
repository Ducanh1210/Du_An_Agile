<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('trainer_id')->constrained('trainers');
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->comment('Ràng buộc: chỉ review sau buổi tập thực tế');
            $table->integer('rating')->comment('1-5 sao');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
