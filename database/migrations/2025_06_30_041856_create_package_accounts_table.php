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
        Schema::create('package_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Economical', 'Monthly', 'Yearly']);
            $table->unsignedBigInteger('price')->default(0);
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_accounts');
    }
};
