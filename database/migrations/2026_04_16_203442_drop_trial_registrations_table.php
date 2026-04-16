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
        Schema::dropIfExists('trial_registrations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('trial_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
            $table->enum('status', ['pending', 'contacted', 'converted', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamps();
            
            $table->unique(['phone', 'schedule_id']);
        });
    }
};
