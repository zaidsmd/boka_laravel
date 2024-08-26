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
        Schema::create('slider_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slider_id')->constrained('parametres_slider')->onDelete('cascade');
            $table->foreignId('image_id')->constrained('media')->onDelete('cascade');
            $table->integer('order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slider_order');
    }
};
