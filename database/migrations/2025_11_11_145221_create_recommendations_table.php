<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('suggested_qty');
            $table->integer('interval_days');
            $table->date('next_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('recommendations');
    }
};