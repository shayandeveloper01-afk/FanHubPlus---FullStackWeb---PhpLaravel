<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->text('admin_reply')->nullable()->after('review_moderation_note');
            $table->string('admin_reaction', 20)->nullable()->after('admin_reply');
        });
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn(['admin_reply', 'admin_reaction']);
        });
    }
};
