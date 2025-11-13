<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type', 50);
            $table->text('message');
            $table->timestamp('sent_at')->nullable();
            $table->boolean('read_flag')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};