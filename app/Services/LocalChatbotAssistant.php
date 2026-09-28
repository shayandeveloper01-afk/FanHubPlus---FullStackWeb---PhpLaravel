<?php

namespace App\Services;

use App\Models\Content;
use Illuminate\Support\Str;

/** Local, database-backed replies used when no hosted AI provider is configured. */
class LocalChatbotAssistant
{
    public function __construct(private FaqMatcherService $faqs) {}

    public function reply(string $input): string
    {
        [$faqReply, $faqId] = $this->faqs->match($input);
        if ($faqId !== null) {
            return $faqReply;
        }

        $text = Str::lower($input);
        if (preg_match('/\b(hi|hello|hey|salam|assalam|good morning|good evening)\b/u', $text)) {
            return "Hi! I'm the FanHub assistant. I can recommend popular content, search titles, or answer questions from the FanHub FAQs. What are you in the mood for?";
        }

        if (preg_match('/\b(trend|popular|recommend|suggest|anime|movie|show|content)\b/u', $text)) {
            $items = Content::where('status', 'published')->orderByDesc('views_count')->limit(5)->get(['id', 'title', 'genre']);
            if ($items->isNotEmpty()) {
                $list = $items->map(function (Content $item) {
                    $label = $item->title . ($item->genre ? ' (' . $item->genre . ')' : '');
                    return '- [' . $label . '](' . route('contents.show', $item) . ')';
                })->implode("\n");

                return "Here are some popular picks on FanHub+:\n\n{$list}\n\nTell me a genre or title and I'll narrow these down.";
            }

            return "I couldn't find published recommendations yet. Try browsing [Explore](" . route('explore') . ') or tell me a title you like.';
        }

        $words = collect(preg_split('/[^\pL\pN]+/u', $text) ?: [])
            ->filter(fn ($word) => mb_strlen($word) >= 3)
            ->unique()->take(6)->values();
        $matches = Content::where('status', 'published')->where(function ($query) use ($words) {
            foreach ($words as $word) {
                $query->orWhere('title', 'like', '%' . $word . '%')
                    ->orWhere('genre', 'like', '%' . $word . '%');
            }
        })->orderByDesc('views_count')->limit(4)->get(['id', 'title', 'genre']);

        if ($matches->isNotEmpty()) {
            $list = $matches->map(fn (Content $item) => '- [' . $item->title . '](' . route('contents.show', $item) . ')')
                ->implode("\n");
            return "I found these FanHub+ matches for you:\n\n{$list}\n\nWant recommendations in a specific genre?";
        }

        return "I can help you discover FanHub+ content and answer questions covered by our FAQs. Try asking for popular recommendations, or mention a title or genre. You can also browse [Explore](" . route('explore') . ').';
    }
}
