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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            // Basic identity
            $table->string('code')->nullable()->unique(); // kode internal, optional
            $table->string('name');                       // nama klien atau perusahaan utama
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Detail organisasi
            $table->string('company_name')->nullable();
            $table->string('industry')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();

            // Status & kategori klien
            $table->enum('status', ['prospect', 'active', 'inactive'])
                  ->default('active'); // untuk filter klien aktif
            $table->string('segment')->nullable(); // misal: 'VIP', 'SME', 'Enterprise' (tagging detail kita buat terpisah nanti)

            // Info tambahan
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
