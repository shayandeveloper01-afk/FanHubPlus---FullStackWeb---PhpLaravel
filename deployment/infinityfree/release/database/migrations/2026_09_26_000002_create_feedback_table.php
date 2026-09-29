<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type')->default('general'); // bug|suggestion|report|general
            $table->string('subject');
            $table->text('message');
            $table->nullableMorphs('related'); // related_type + related_id
            $table->string('status')->default('new'); // new|reviewed|resolved|dismissed
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index('type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
