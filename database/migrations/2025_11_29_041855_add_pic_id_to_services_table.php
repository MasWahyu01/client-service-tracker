<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // nullable karena PIC opsional
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pic_id');
        });
    }
};
