<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class ChatbotAssistant
{
    public function reply(array $messages, string $context): string
    {
        abort_unless(config('chatbot.enabled'), 503, 'Chatbot is currently disabled.');

        $provider = config('chatbot.provider', 'openai');
        $system = 'You are FanHub+, a helpful assistant for fans. Recommend content using the supplied FanHub context. Be clear when you do not know something. Do not claim to have performed actions. Context: ' . $context;
        $timeout = config('chatbot.timeout', 45);

        $reply = match ($provider) {
            'openai' => $this->openAi($messages, $system, $timeout),
            'gemini' => $this->gemini($messages, $system, $timeout),
            'claude', 'anthropic' => $this->anthropic($messages, $system, $timeout),
            default => throw new RuntimeException('Unsupported chatbot provider.'),
        };

        $reply = trim($reply);
        if ($reply === '') {
            throw new RuntimeException('The AI provider returned an empty response.');
        }

        return $reply;
    }

    private function openAi(array $messages, string $system, int $timeout): string
    {
        $key = config('services.openai.key');
        if (! $key) throw new RuntimeException('OPENAI_API_KEY is not configured.');

        $baseUrl = rtrim((string) config('services.openai.base_url', 'https://api.openai.com/v1'), '/');
        $response = Http::withToken($key)->acceptJson()->timeout($timeout)->post(
            $baseUrl . '/chat/completions',
            [
                'model' => config('services.openai.model', config('chatbot.models.openai', 'gpt-4o-mini')),
                'messages' => [['role' => 'system', 'content' => $system], ...$messages],
                'temperature' => 0.7,
            ]
        )->throw();

        return (string) $response->json('choices.0.message.content', '');
    }

    private function gemini(array $messages, string $system, int $timeout): string
    {
        $key = config('services.gemini.key');
        if (! $key) throw new RuntimeException('GEMINI_API_KEY is not configured.');

        $contents = array_map(fn ($message) => [
            'role' => $message['role'] === 'assistant' ? 'model' : 'user',
            'parts' => [['text' => $message['content']]],
        ], $messages);
        $response = Http::withHeaders(['x-goog-api-key' => $key])->acceptJson()->timeout($timeout)->post(
            'https://generativelanguage.googleapis.com/v1beta/models/' . config('chatbot.models.gemini') . ':generateContent',
            [
                'systemInstruction' => ['parts' => [['text' => $system]]],
                'contents' => $contents,
                'generationConfig' => ['temperature' => 0.7],
            ]
        )->throw();

        return collect($response->json('candidates.0.content.parts', []))
            ->pluck('text')->filter()->implode('');
    }

    private function anthropic(array $messages, string $system, int $timeout): string
    {
        $key = config('services.anthropic.key');
        if (! $key) throw new RuntimeException('ANTHROPIC_API_KEY is not configured.');

        $response = Http::withHeaders([
            'x-api-key' => $key,
            'anthropic-version' => '2023-06-01',
        ])->acceptJson()->timeout($timeout)->post('https://api.anthropic.com/v1/messages', [
            'model' => config('chatbot.models.anthropic'),
            'max_tokens' => 1200,
            'system' => $system,
            'messages' => $messages,
        ])->throw();

        return collect($response->json('content', []))->pluck('text')->filter()->implode('');
    }
}
