<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchandise', function (Blueprint $table) {
            $table->string('item_type', 24)->default('physical')->after('description');
            $table->string('whatsapp_number', 32)->nullable()->after('external_purchase_link');
            $table->string('instagram_url', 500)->nullable()->after('whatsapp_number');
            $table->string('facebook_url', 500)->nullable()->after('instagram_url');
        });
    }

    public function down(): void
    {
        Schema::table('merchandise', function (Blueprint $table) {
            $table->dropColumn(['item_type', 'whatsapp_number', 'instagram_url', 'facebook_url']);
        });
    }
};
