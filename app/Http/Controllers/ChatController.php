<?php

namespace App\Http\Controllers;

use App\Models\ChatSession;
use App\Models\AnalyticsEvent;
use App\Models\Category;
use App\Models\Content;
use App\Models\Profile;
use App\Services\AnalyticsLogger;
use App\Services\ChatbotAssistant;
use App\Services\LocalChatbotAssistant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChatController extends Controller
{
    /** GET /chat/history?session_id=xxx — load persisted messages */
    public function history(Request $request): JsonResponse
    {
        $request->validate([
            'session_id' => 'nullable|string|max:64',
        ]);
        $sessionId = trim((string) $request->input('session_id', ''));
        if ($sessionId === '') return response()->json([]);

        $session = ChatSession::where('session_id', $sessionId)->first();
        if (!$session) return response()->json([]);
        abort_unless($this->ownsSession($session, $request), 403);

        return response()->json(
            $session->messages->map(fn($m) => [
                'id' => $m->id,
                'sender'  => $m->sender,
                'message' => $m->message,
                    'time'    => $m->created_at->format('h:i A'),
                'feedback' => $m->feedback,
            ])
        );
    }

    /** POST /chat/message — process user message, return bot reply */
    public function message(Request $request, AnalyticsLogger $logger, ChatbotAssistant $assistant, LocalChatbotAssistant $localAssistant): StreamedResponse
    {
        $request->validate([
            'session_id' => ['required', 'string', 'max:64', 'regex:/\S/'],
            'message'    => ['required', 'string', 'max:1000', 'regex:/\S/'],
        ]);

        $sessionId = trim((string) $request->input('session_id'));
        $userText  = trim((string) $request->input('message'));

        $profile = $this->activeProfile($request);
        $session = ChatSession::firstOrCreate(['session_id' => $sessionId], [
            'user_id' => $request->user()?->id,
            'profile_id' => $profile?->id,
            'title' => mb_substr($userText, 0, 80),
        ]);
        abort_unless($this->ownsSession($session, $request), 403);
        if ($request->user() && ($session->user_id !== $request->user()->id || $session->profile_id !== $profile?->id)) {
            $session->update(['user_id' => $request->user()->id, 'profile_id' => $profile?->id]);
        }

        $history = $session->messages()->reorder()->latest('created_at')->limit(10)->get()->reverse()
            ->map(fn ($message) => [
                'role' => $message->sender === 'bot' ? 'assistant' : 'user',
                'content' => $message->message,
            ])->values()->all();

        $session->messages()->create([
            'sender'     => 'user',
            'message'    => $userText,
            'created_at' => now(),
        ]);

        $history[] = ['role' => 'user', 'content' => $userText];
        $context = $this->buildContext($request, $profile);

        return response()->stream(function () use ($assistant, $localAssistant, $history, $context, $session, $logger, $sessionId, $userText): void {
            try {
                $reply = $assistant->reply($history, $context);
                $this->logChatEventSafely($logger, 'chatbot_used', [
                    'provider' => config('chatbot.provider'),
                    'session_id' => $sessionId,
                ]);
            } catch (\Throwable $exception) {
                // A missing provider key is an expected setup state. Keep the
                // chat usable with local, database-backed answers offline.
                Log::warning('Chatbot provider request failed; switching to local replies.', [
                    'provider' => config('chatbot.provider'),
                    'exception' => class_basename($exception),
                    'reason' => $exception->getMessage(),
                ]);
                try {
                    $reply = $localAssistant->reply($userText);
                    $this->logChatEventSafely($logger, 'chatbot_local_reply', ['session_id' => $sessionId]);
                } catch (\Throwable $fallbackException) {
                    report($fallbackException);
                    $reply = 'I could not reach the AI assistant right now. Please try again shortly.';
                }
            }

            $botMessage = $session->messages()->create(['sender' => 'bot', 'message' => $reply, 'created_at' => now()]);
            preg_match_all('/.{1,60}/us', $reply, $chunks);
            foreach ($chunks[0] as $chunk) {
                echo 'data: ' . json_encode(['delta' => $chunk], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE) . "\n\n";
                if (ob_get_level() > 0) @ob_flush();
                flush();
            }
            echo 'data: ' . json_encode(['done' => true, 'message_id' => $botMessage->id]) . "\n\n";
            if (ob_get_level() > 0) @ob_flush();
            flush();
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache, no-transform',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    /** POST /chat/clear — delete all messages for a session */
    public function clear(Request $request): JsonResponse
    {
        $request->validate(['session_id' => ['required', 'string', 'max:64', 'regex:/\S/']]);

        $session = ChatSession::where('session_id', trim((string) $request->input('session_id')))->first();
        if ($session) abort_unless($this->ownsSession($session, $request), 403);
        $session?->messages()->delete();

        return response()->json(['ok' => true]);
    }

    public function feedback(Request $request, \App\Models\ChatMessage $message): JsonResponse
    {
        $data = $request->validate([
            'session_id' => ['required', 'string', 'max:64'],
            'score' => ['required', 'integer', 'in:-1,1'],
        ]);
        $session = ChatSession::where('session_id', $data['session_id'])->firstOrFail();
        abort_unless($this->ownsSession($session, $request), 403);
        abort_unless($message->chat_session_id === $session->id && $message->sender === 'bot', 404);
        $message->update(['feedback' => $data['score']]);
        return response()->json(['ok' => true]);
    }

    private function activeProfile(Request $request): ?Profile
    {
        return $request->user()?->profiles()->whereKey(session('active_profile_id'))->first();
    }

    private function ownsSession(ChatSession $session, Request $request): bool
    {
        return $session->user_id === null || $session->user_id === $request->user()?->id;
    }

    private function logChatEventSafely(AnalyticsLogger $logger, string $event, array $metadata): void
    {
        try {
            $logger->log($event, $metadata);
        } catch (\Throwable $exception) {
            Log::warning('Could not record chatbot analytics event.', [
                'event' => $event,
                'exception' => class_basename($exception),
            ]);
        }
    }

    private function buildContext(Request $request, ?Profile $profile): string
    {
        $recentIds = $profile
            ? AnalyticsEvent::query()->where('profile_id', $profile->id)->where('event_type', 'content_view')
                ->latest('created_at')->limit(20)->get()->pluck('metadata')
                ->map(fn ($metadata) => data_get($metadata, 'content_id'))->filter()->unique()->take(5)->values()
            : collect();
        $recent = $recentIds->isNotEmpty()
            ? Content::whereIn('id', $recentIds)->get(['id', 'title'])->pluck('title')->implode(', ')
            : 'none recorded';
        $fandoms = implode(', ', $profile?->fandom_tags ?? []);
        $categories = Category::where('status', 'active')->orderBy('sort_order')->pluck('name')->implode(', ');
        $refererPath = parse_url((string) $request->headers->get('referer'), PHP_URL_PATH) ?: '/';

        return implode("\n", [
            'User: ' . ($request->user()?->name ?? 'Guest'),
            'Active profile: ' . ($profile?->name ?? 'none'),
            'Fandom interests: ' . ($fandoms ?: 'not set'),
            'Current page: ' . $refererPath,
            'Recently viewed content: ' . $recent,
            'Available categories: ' . $categories,
        ]);
    }
}
