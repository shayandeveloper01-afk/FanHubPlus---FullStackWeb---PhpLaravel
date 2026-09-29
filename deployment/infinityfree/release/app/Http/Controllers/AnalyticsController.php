<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * POST /analytics/track
     *
     * Lightweight beacon endpoint — called from JS via navigator.sendBeacon or fetch.
     * Rate-limited (see routes/web.php) to prevent abuse.
     * No auth required — anonymous events are valid.
     *
     * Privacy: only event_type, session_id (anonymous), and non-PII metadata are stored.
     */
    public function track(Request $request, AnalyticsLogger $logger): JsonResponse
    {
        $data = $request->validate([
            'event_type' => ['required', 'in:share_clicked'],
            'session_id' => ['nullable', 'string', 'max:64', 'regex:/^[A-Za-z0-9-]+$/'],
            'metadata' => ['nullable', 'array:content_id,platform'],
            'metadata.content_id' => ['nullable', 'integer', 'exists:contents,id'],
            'metadata.platform' => ['nullable', 'string', 'in:twitter,facebook,whatsapp,reddit,copy'],
        ]);

        $logger->log($data['event_type'], array_merge(
            $data['metadata'] ?? [],
            ['session_id' => $data['session_id'] ?? null]
        ));

        return response()->json(['ok' => true]);
    }
}
