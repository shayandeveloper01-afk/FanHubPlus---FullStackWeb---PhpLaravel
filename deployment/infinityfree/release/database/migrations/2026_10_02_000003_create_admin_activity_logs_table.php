<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->string('action', 100);          // e.g. 'user.ban', 'content.delete'
            $table->string('target_type', 100)->nullable(); // e.g. 'User', 'Content'
            $table->unsignedBigInteger('target_id')->nullable();
            $table->text('notes')->nullable();       // human-readable detail
            $table->timestamp('created_at')->useCurrent();

            $table->index(['admin_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_activity_logs');
    }
};
