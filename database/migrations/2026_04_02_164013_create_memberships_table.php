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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->comment('Tên gói (VD: Gym Cơ Bản, Yoga 1 Tháng)');
            $table->enum('category', ['gym', 'yoga'])->comment('Loại gói: thể hình hoặc yoga');
            $table->text('description')->nullable();
            $table->integer('duration_days')->comment('Số ngày hiệu lực');
            $table->decimal('price', 12, 2)->comment('Giá cố định');
            $table->tinyInteger('allow_pt')->default(0)->comment('Gói có kèm PT không');
            $table->integer('pt_sessions')->default(0)->comment('Số buổi PT đi kèm (nếu có)');
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
