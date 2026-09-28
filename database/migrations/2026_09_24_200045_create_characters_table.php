<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('alias')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('role', ['protagonist', 'antagonist', 'supporting', 'other'])->default('other');
            $table->unsignedSmallInteger('order_index')->default(0);
            $table->timestamps();
            $table->index('content_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
