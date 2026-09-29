<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->string('genre')->nullable()->after('status');
            $table->unsignedSmallInteger('year')->nullable()->after('genre');
            $table->string('type')->nullable()->after('year');         // movie|series|anime|music|game|art|podcast|other
            $table->unsignedInteger('views_count')->default(0)->after('type');
            $table->string('thumbnail')->nullable()->after('views_count');

            // Indexes for filtering & sorting
            $table->index('category_id');
            $table->index('genre');
            $table->index('year');
            $table->index('type');
            $table->index('views_count');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropIndex(['category_id']);
            $table->dropIndex(['genre']);
            $table->dropIndex(['year']);
            $table->dropIndex(['type']);
            $table->dropIndex(['views_count']);
            $table->dropIndex(['status']);
            $table->dropColumn(['genre', 'year', 'type', 'views_count', 'thumbnail']);
        });
    }
};
