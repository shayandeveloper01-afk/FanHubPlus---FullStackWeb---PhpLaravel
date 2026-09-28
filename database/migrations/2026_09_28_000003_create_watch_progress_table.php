<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('watch_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('content_id')->constrained()->cascadeOnDelete();
            // progress_pct: 0-100 integer (avoids storing seconds when duration unknown)
            $table->unsignedTinyInteger('progress_pct')->default(0);
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['profile_id', 'content_id']);
            $table->index(['profile_id', 'updated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('watch_progress');
    }
};
