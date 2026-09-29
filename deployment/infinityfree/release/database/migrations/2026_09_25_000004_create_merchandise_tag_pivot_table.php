<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchandise_tag_pivot', function (Blueprint $table) {
            $table->foreignId('merchandise_id')->constrained('merchandise')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('merchandise_tags')->cascadeOnDelete();
            $table->primary(['merchandise_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchandise_tag_pivot');
    }
};
