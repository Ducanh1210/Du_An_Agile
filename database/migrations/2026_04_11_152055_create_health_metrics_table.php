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
        Schema::create('health_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->float('weight')->comment('Cân nặng (kg)');
            $table->float('bmi')->comment('Chỉ số BMI');
            $table->float('fat_percent')->nullable()->comment('Phần trăm mỡ (%)');
            $table->enum('recorded_by', ['user', 'trainer'])->default('trainer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_metrics');
    }
};
