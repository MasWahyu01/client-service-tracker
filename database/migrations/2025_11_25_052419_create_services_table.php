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
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            // Relasi ke client
            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Informasi layanan
            $table->string('name');            // nama / judul layanan
            $table->text('description')->nullable();

            // Timeline & PIC
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->foreignId('pic_user_id')   // user yang jadi PIC layanan
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();

            // Prioritas & status layanan
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])
                  ->default('medium');
            $table->enum('status', ['new', 'in_progress', 'on_hold', 'completed', 'cancelled'])
                  ->default('new');

            // Optional: progress persentase
            $table->unsignedTinyInteger('progress')->default(0); // 0 - 100

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
