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
        Schema::table('admin_products', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->after('phone_number'); // Menambahkan kolom price
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_products', function (Blueprint $table) {
            $table->dropColumn('price'); // Menghapus kolom price jika migrasi dibatalkan
        });
    }
};