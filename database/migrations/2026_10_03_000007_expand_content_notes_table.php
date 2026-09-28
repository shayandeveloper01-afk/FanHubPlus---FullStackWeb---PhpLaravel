<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_notes', function (Blueprint $table) {
            $table->unsignedInteger('timestamp_seconds')->nullable();
            $table->boolean('is_spoiler')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('content_notes', fn (Blueprint $table) => $table->dropColumn(['timestamp_seconds', 'is_spoiler']));
    }
};
