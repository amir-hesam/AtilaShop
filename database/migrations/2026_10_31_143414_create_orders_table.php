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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('receiver_name');
            $table->string('phone', 20);
            $table->text('address');
            $table->unsignedInteger('total_amount'); // تومان
            $table->string('payment_method'); // online, card_transfer
            $table->string('status')->default('در انتظار پرداخت'); // در انتظار پرداخت، در انتظار تأیید پرداخت، پرداخت شده، پرداخت ناموفق
            $table->string('tracking_code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
