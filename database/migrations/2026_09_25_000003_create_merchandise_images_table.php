<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchandise_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchandise_id')->constrained('merchandise')->cascadeOnDelete();
            $table->string('image_path');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['merchandise_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchandise_images');
    }
};
