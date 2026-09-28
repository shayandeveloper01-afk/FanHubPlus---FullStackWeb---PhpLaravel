<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('contents', 'release_date')) {
            Schema::table('contents', function (Blueprint $table): void {
                $table->date('release_date')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('contents', 'release_date')) {
            Schema::table('contents', function (Blueprint $table): void {
                $table->dropColumn('release_date');
            });
        }
    }
};
