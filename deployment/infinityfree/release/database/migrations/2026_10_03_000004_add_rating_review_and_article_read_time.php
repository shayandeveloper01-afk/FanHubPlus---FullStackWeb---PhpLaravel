<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            $table->text('review')->nullable();
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedSmallInteger('read_time_minutes')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('articles', fn (Blueprint $table) => $table->dropColumn('read_time_minutes'));
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropColumn('review');
        });
    }
};
