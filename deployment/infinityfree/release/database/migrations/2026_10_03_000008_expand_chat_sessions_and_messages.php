<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('session_id')->constrained()->nullOnDelete();
            $table->foreignId('profile_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $table->string('title')->nullable();
        });
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->unsignedInteger('tokens_used')->nullable();
            $table->tinyInteger('feedback')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('chat_messages', fn (Blueprint $table) => $table->dropColumn(['tokens_used', 'feedback']));
        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('profile_id');
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn('title');
        });
    }
};
