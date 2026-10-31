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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('gender', 1)->default('w'); // 'w' = زنانه, 'm' = مردانه
            $table->unsignedInteger('price'); // قیمت به تومان
            $table->unsignedInteger('original_price')->nullable(); // قیمت اصلی برای تخفیف
            $table->integer('stock')->default(0);
            $table->json('sizes')->nullable(); // مثلا ['S', 'M', 'L', 'XL']
            $table->string('icon')->default('tee'); // آیکون وکتور: coat, shirt, hoodie, pants, dress, scarf, tee
            $table->json('hues')->nullable(); // مقادیر رنگی HSL مثلا [345, 28, 205]
            $table->string('tag')->nullable(); // جدید، پرفروش
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
