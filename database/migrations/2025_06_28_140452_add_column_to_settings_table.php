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
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('order_on_table')->default(true)->after('ads')->comment('Apakah meja ini dapat dipesan secara online?');
            $table->string('color_number_table')->nullable()->after('order_on_table')->comment('Warna nomor meja yang ditampilkan pada aplikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};