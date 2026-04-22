<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')->constrained('subscriptions');
            $table->decimal('amount', 12, 2);
            $table->enum('method', ['cash', 'transfer', 'e_wallet']);
            $table->enum('status', ['pending', 'completed', 'refunded', 'cancelled'])->default('pending');
            $table->string('invoice_code', 100)->nullable()->comment('Mã hóa đơn tự sinh');
            $table->text('note')->nullable();
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->comment('Nhân viên xác nhận');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
