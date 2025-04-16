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
        Schema::create('security_logs', function (Blueprint $table) {
            $table->id();
            $table->json('data')->nullable();
            $table->enum('type', ['login', 'logout', 'failed_login', 'password_change', 'account_creation']);
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('ip_address')->nullable();
            $table->boolean('blocked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_logs');
    }
};
