<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role column sits alongside the existing is_admin boolean.
            // is_admin remains the authoritative gate (checked by EnsureIsAdmin middleware).
            // role adds finer-grained labelling (organizer) without breaking existing auth.
            $table->enum('role', ['user', 'organizer', 'admin'])->default('user')->after('is_admin');
        });

        // Back-fill: anyone already flagged as is_admin gets role = 'admin'
        DB::statement("UPDATE users SET role = 'admin' WHERE is_admin = 1");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
