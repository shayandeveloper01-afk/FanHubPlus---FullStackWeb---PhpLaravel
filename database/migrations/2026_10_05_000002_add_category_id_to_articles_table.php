<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('articles', 'category_id')) {
            Schema::table('articles', function (Blueprint $table): void {
                $table->foreignId('category_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('articles', 'category_id')) {
            Schema::table('articles', function (Blueprint $table): void {
                $table->dropConstrainedForeignId('category_id');
            });
        }
    }
};
