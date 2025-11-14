<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('couriers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('vehicle_info', 100)->nullable();
            $table->string('status', 50)->default('available');
            $table->decimal('last_known_lat', 10, 6)->nullable();
            $table->decimal('last_known_lng', 10, 6)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('couriers');
    }
};