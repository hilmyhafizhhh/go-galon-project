<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('order_code', 30)->unique();
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method', 50);
            $table->string('payment_status', 50)->default('pending');
            $table->string('status', 50)->default('waiting');
            $table->foreignUuid('assigned_courier_id')->nullable()->constrained('couriers')->nullOnDelete();
            $table->foreignUuid('address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};