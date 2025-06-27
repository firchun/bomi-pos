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
        Schema::create('account_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nama paket akun');
            $table->string('type')->default('Free Account');
            $table->string('price')->default('FREE');
            $table->string('duration')->default('Monthly')->comment('Durasi paket, misalnya 1 bulan, 1 tahun, dll.');
            $table->json('features')->comment('Fitur-fitur yang termasuk dalam paket ini, disimpan sebagai JSON');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_packages');
    }
};