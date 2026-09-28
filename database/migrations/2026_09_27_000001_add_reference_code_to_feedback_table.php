<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            // Public-facing fields for guest submissions
            $table->string('name')->nullable()->after('user_id');
            $table->string('email')->nullable()->after('name');
            // Unique reference code for status tracking
            $table->string('reference_code', 12)->unique()->nullable()->after('email');
            // Add 'general' as a valid category (already in controller, just ensure migration matches)
        });
    }

    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'reference_code']);
        });
    }
};
