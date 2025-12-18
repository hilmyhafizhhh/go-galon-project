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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_id')->constrained()->cascadeOnDelete();
            $table->uuid('courier_id')->nullable()->constrained('users');
            $table->uuid('customer_id')->nullable()->constrained('users');
            $table->date('pickup_date')->nullable();
            $table->string('status')->default('pending'); // pending | picked_up | completed
            $table->timestamps();

            $table->index('courier_id');
            $table->index('customer_id');
            $table->index('status');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            $table->foreign('courier_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table->foreign('customer_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
