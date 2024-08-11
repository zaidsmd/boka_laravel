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
        Schema::create('cart_lines', function (Blueprint $table) {
            $table->id();
            $table->string('article');
            $table->integer('quantity')->default(0);
            $table->foreignId('article_id')->nullable()->references('id')->on('articles')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('cart_id')->references('id')->on('carts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_lines');
    }
};
