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
        Schema::create('parametres_slider', function (Blueprint $table) {
            $table->id();
            $table->integer('transition_time')->default(500); // Temps de transition en millisecondes
            $table->boolean('autoplay')->default(false); // Activer ou désactiver l'autoplay
            $table->integer('autoplay_interval')->nullable(); // Intervalle pour l'autoplay si activé
            $table->timestamps(); // Champs created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
