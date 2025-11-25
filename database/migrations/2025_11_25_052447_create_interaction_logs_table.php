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
        Schema::create('interaction_logs', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->foreignId('client_id')
                  ->constrained('clients')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            // Relasi opsional ke service (kadang interaksi level umum ke klien saja)
            $table->foreignId('service_id')
                  ->nullable()
                  ->constrained('services')
                  ->nullOnDelete()
                  ->cascadeOnUpdate();

            // User yang melakukan / mencatat interaksi
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();

            // Detail interaksi
            $table->enum('type', ['call', 'email', 'meeting', 'chat', 'other'])
                  ->default('other');
            $table->text('notes')->nullable();

            // Next action & reminder
            $table->text('next_action')->nullable();
            $table->dateTime('next_action_due_at')->nullable();

            // Attachment file (nanti disimpan di storage, path disimpan di sini)
            $table->string('attachment_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interaction_logs');
    }
};
