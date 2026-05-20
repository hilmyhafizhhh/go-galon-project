<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_token')->nullable()->after('payment_status');
            $table->string('snap_url')->nullable()->after('payment_token');
            $table->string('transaction_id')->nullable()->after('snap_url');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_token', 'snap_url', 'transaction_id']);
        });
    }
};
