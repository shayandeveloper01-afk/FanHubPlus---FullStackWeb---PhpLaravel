<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->string('review_status', 20)->nullable()->after('review')->index();
            $table->text('review_moderation_note')->nullable()->after('review_status');
        });

        // Keep previously published reviews visible; only new and edited reviews wait for moderation.
        DB::table('ratings')
            ->whereNotNull('review')
            ->where('review', '<>', '')
            ->update(['review_status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropIndex(['review_status']);
            $table->dropColumn(['review_status', 'review_moderation_note']);
        });
    }
};
