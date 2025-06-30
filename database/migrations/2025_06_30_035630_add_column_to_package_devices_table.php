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
        Schema::table('package_devices', function (Blueprint $table) {
            $table->string('no_hp')->nullable()->after('features')->comment('Nomor HP untuk kontak');
            $table->string('link_direct')->nullable()->aflter('no_hp')->comment('Link langsung ke produk atau halaman detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_devices', function (Blueprint $table) {
            //
        });
    }
};
