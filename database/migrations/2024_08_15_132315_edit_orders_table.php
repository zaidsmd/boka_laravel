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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('first_name')->after('status');
            $table->string('last_name')->after('first_name');
            $table->string('city')->nullable()->after('last_name');
            $table->string('address')->nullable()->after('city');
            $table->string('phone_number')->nullable()->after('address');
            $table->enum('type', [0, 1])->default(0)->after('phone_number');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'city', 'address', 'phone_number']);
            $table->dropColumn('type');
        });
    }
};
