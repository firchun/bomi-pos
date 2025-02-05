<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('no_invoice')->unique()->after('transaction_time');
            $table->unique('transaction_time');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menghapus constraint unik dan kolom no_invoice
            $table->dropUnique(['transaction_time']);
            $table->dropColumn('no_invoice');
        });
    }
};