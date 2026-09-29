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
        $text = Str::lower($input);
        $romanUrdu = preg_match('/\b(kahan|kaha|kidhar|hai|ha|meri|mera|mujhe|kaise|kese|banau|banegi|karsakta|karsakti|chahiye)\b/u', $text) === 1;

        // Handle common site-navigation tasks even if no hosted AI provider is available.
        if (preg_match('/\b(create|make|new|sign ?up|register|account|id)\b/u', $text)
            && preg_match('/\b(account|id|register|sign ?up|create|make|ban\p{L}*)\b/u', $text)) {
            return $romanUrdu
                ? 'FanHub+ account banane ke liye [Sign up page](' . route('register') . ') kholen, apna naam, email aur password dein. Pehle se account hai? [Yahan login karein](' . route('login') . ').'
                : 'Create your FanHub+ account from the [Sign up page](' . route('register') . '). Add your name, email, and password, then sign in. Already registered? [Log in here](' . route('login') . ').';
        }

        if (preg_match('/\b(bookings?|rsvp|reserved|attending|going|event reservation)\b/u', $text)) {
            if (auth()->check()) {
                $rsvps = auth()->user()->eventRsvps()->with('event')->latest('created_at')->limit(5)->get();
                if ($rsvps->isNotEmpty()) {
                    $items = $rsvps->map(fn ($rsvp) => '- [' . $rsvp->event->title . '](' . route('events.show', $rsvp->event) . ') — ' . ucfirst($rsvp->status))->implode("\n");
                    return $romanUrdu
                        ? "Aapki recent event bookings/RSVPs:\n\n{$items}\n\nMazeed events dekhne ke liye [Events page](" . route('events.index') . ') kholen.'
                        : "Your recent event RSVPs are:\n\n{$items}\n\nBrowse all [Events](" . route('events.index') . ') to manage an RSVP.';
                }
                return $romanUrdu
                    ? 'Aapke account par abhi event booking nahi mili. [Events page](' . route('events.index') . ') par event khol kar Going ya Interested select karein.'
                    : 'I could not find any event RSVPs on your account yet. Browse [Events](' . route('events.index') . ') and choose Going or Interested on an event to RSVP.';
            }
            return $romanUrdu
                ? '[Login](' . route('login') . ') karke [Events](' . route('events.index') . ') par jayein, event kholen aur Going ya Interested dabayein. Booking aapke account mein save hogi.'
                : 'Sign in to RSVP to an event. Browse [Events](' . route('events.index') . '), open an event, and select Going or Interested. RSVPs are saved to your account.';
        }

        if (preg_match('/\b(profile|edit my details|change password|password|my account)\b/u', $text)) {
            return auth()->check()
                ? 'Update your account details and password on [My Profile](' . route('profile.edit') . '). Your saved items are under [Bookmarks](' . route('bookmarks.index') . ').'
                : 'Sign in to manage your profile. [Log in](' . route('login') . ') or [create an account](' . route('register') . ').';
        }

        if (preg_match('/\b(bookmarks?|saved|save for later|my list)\b/u', $text)) {
            return auth()->check()
                ? ($romanUrdu ? 'Aapka saved content [Bookmarks page](' . route('bookmarks.index') . ') par hai. Content card ya page par bookmark icon dabakar save karein.' : 'Your saved content is on the [Bookmarks page](' . route('bookmarks.index') . '). Use the bookmark button on a content card or its page to save it.')
                : 'Sign in to save content to your [Bookmarks](' . route('login') . ').';
        }

        if (preg_match('/\b(contact|message admin|send feedback|report a problem)\b/u', $text)) {
            return 'Send a message through the [Contact & Feedback form](' . route('feedback.create') . '). You can check a submitted message from [My Messages](' . (auth()->check() ? route('feedback.mine') : route('login')) . ').';
        }

        if (preg_match('/\b(hi|hello|hey|salam|assalam|good morning|good evening)\b/u', $text)) {
            return "Hi! I'm your FanHub+ guide. I can help you find pages, manage your account or event RSVPs, and discover content. What can I help you with?";
        }

        [$faqReply, $faqId] = $this->faqs->match($input);
        if ($faqId !== null) {
            return $faqReply;
        }

        if (preg_match('/\b(trend|popular|recommend|suggest|anime|manga|movies?|film|tv|series|show|game|gaming)\b/u', $text)) {
            $categorySlug = match (true) {
                preg_match('/\banime\b/u', $text) === 1 => 'anime',
                preg_match('/\bmanga\b/u', $text) === 1 => 'manga',
                preg_match('/\b(movie|movies|film)\b/u', $text) === 1 => 'movies',
                preg_match('/\b(tv|series|show)\b/u', $text) === 1 => 'tv-series',
                preg_match('/\b(game|gaming)\b/u', $text) === 1 => 'gaming',
                default => null,
            };
            $items = Content::where('status', 'published')
                ->when($categorySlug, fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $categorySlug)))
                ->orderByDesc('views_count')->limit(5)->get(['id', 'title', 'genre']);
            if ($items->isNotEmpty()) {
                $list = $items->map(function (Content $item) {
                    $label = $item->title . ($item->genre ? ' (' . $item->genre . ')' : '');
                    return '- [' . $label . '](' . route('contents.show', $item) . ')';
                })->implode("\n");

                return "Here are some popular picks on FanHub+:\n\n{$list}\n\nTell me a genre or title and I'll narrow these down.";
            }

            return 'I could not find published recommendations in that category yet. Browse [Explore](' . route('explore') . ') or tell me another genre or title.';
        }

        if (preg_match('/\b(where|find|which page|page|navigate|website|section|content|videos?|articles|shop|merchandise|events|faq|help|categories|category|kahan|kaha|kidhar)\b/u', $text)) {
            return $romanUrdu
                ? 'FanHub+ ke pages: [Explore/content](' . route('explore') . '), [Categories](' . route('categories.index') . '), [Events](' . route('events.index') . '), [Shop](' . route('merchandise.index') . '), [FAQs](' . route('faqs.index') . '), aur [Contact/Feedback](' . route('feedback.create') . '). Aap kis cheez ko dhoond rahe hain?'
                : 'Main FanHub+ pages: [Explore content](' . route('explore') . '), [Categories](' . route('categories.index') . '), [Events](' . route('events.index') . '), [Shop](' . route('merchandise.index') . '), [FAQs](' . route('faqs.index') . '), and [Contact & Feedback](' . route('feedback.create') . '). What are you looking for?';
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

        return $romanUrdu
            ? 'Main FanHub+ account, bookings, bookmarks, pages, recommendations aur FAQs mein madad kar sakta hoon. Poochhein “meri bookings kahan hain?” ya [Explore](' . route('explore') . ') dekhein.'
            : "I can help with FanHub+ accounts, events and RSVPs, bookmarks, page navigation, recommendations, and FAQs. Try asking “Where are my bookings?” or browse [Explore](" . route('explore') . ').';
    }
}
