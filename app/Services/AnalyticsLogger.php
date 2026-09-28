<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use Illuminate\Support\Facades\Request;

/**
 * Lightweight analytics logger.
 *
 * Privacy note: this service intentionally avoids logging PII (names, emails,
 * IP addresses). Only profile_id (an internal integer) and an anonymous
 * session_id (from localStorage) are stored. Ensure your privacy policy
 * discloses this anonymous usage tracking.
 */
class AnalyticsLogger
{
    /**
     * Log an analytics event.
     *
     * @param  string  $eventType  e.g. 'page_view', 'content_view', 'chatbot_used'
     * @param  array   $metadata   Flexible extra data — content_id, category, etc. No PII.
     */
    public function log(string $eventType, array $metadata = []): void
    {
        try {
            AnalyticsEvent::create([
                'event_type' => $eventType,
                'profile_id' => session('active_profile_id'),
                'session_id' => $metadata['session_id'] ?? null,
                'metadata'   => array_diff_key($metadata, ['session_id' => '']),
                'url'        => Request::path(),
            ]);
        } catch (\Throwable) {
            // Analytics logging is best-effort — never break the main request
        }
    }
}
