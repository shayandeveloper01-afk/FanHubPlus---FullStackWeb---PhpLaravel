<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timeline_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('event_date')->nullable();       // optional real date
            $table->unsignedSmallInteger('order_index')->default(0); // controls display order
            $table->timestamps();
            $table->index(['content_id', 'order_index']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timeline_events');
    }
};
