<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('title', 200);
            $table->enum('category', ['gym', 'yoga']);
            $table->foreignId('trainer_id')->nullable()->constrained('users');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->integer('capacity')->default(20);
            $table->integer('current_enrolled')->default(0);
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
