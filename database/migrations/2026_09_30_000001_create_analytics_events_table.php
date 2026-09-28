<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            // Type of event: page_view, content_view, chatbot_used, feedback_submitted,
            // event_rsvp, my_list_added, trailer_hover, chatbot_fallback, etc.
            $table->string('event_type', 50);
            // Nullable — only set when a fandom profile is active (not PII)
            $table->foreignId('profile_id')->nullable()->constrained()->nullOnDelete();
            // Browser/localStorage session identifier — not tied to user account (not PII)
            $table->string('session_id', 64)->nullable();
            // Flexible JSON payload: content_id, category, event_id, faq_id, etc.
            // Never store names, emails, or other PII here — see privacy policy.
            $table->json('metadata')->nullable();
            // The URL that triggered the event (path only, no query string with PII)
            $table->string('url', 500)->nullable();
            $table->timestamp('created_at')->useCurrent();

            // Fast aggregation indexes
            $table->index('event_type');
            $table->index('created_at');
            $table->index(['event_type', 'created_at']);
            $table->index('session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
    }
};
