<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_stats', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('metric', 80);
            $table->unsignedBigInteger('value')->default(0);
            $table->timestamps();
            $table->unique(['date', 'metric']);
        });
    }

    public function down(): void { Schema::dropIfExists('daily_stats'); }
};
