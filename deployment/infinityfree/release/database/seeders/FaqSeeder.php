<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // ── Core account / auth ───────────────────────────────────────────
            [
                'question'   => 'How do I create an account?',
                'keywords'   => ['register', 'sign up', 'account', 'join', 'create account'],
                'answer'     => 'Click "Join Free" on the homepage or visit /register. Fill in your name, email, and password to get started!',
                'sort_order' => 1,
            ],
            [
                'question'   => 'How do I reset my password?',
                'keywords'   => ['password', 'reset', 'forgot', 'lost password', 'change password'],
                'answer'     => 'Click "Forgot your password?" on the login page and enter your email. You\'ll receive a reset link within a few minutes.',
                'sort_order' => 2,
            ],
            [
                'question'   => 'How do I edit my profile?',
                'keywords'   => ['profile', 'edit', 'avatar', 'bio', 'username', 'settings'],
                'answer'     => 'Go to Dashboard → click your name → Profile. You can update your display name, avatar, and bio from there.',
                'sort_order' => 3,
            ],

            // ── Content ───────────────────────────────────────────────────────
            [
                'question'   => 'How do I submit content?',
                'keywords'   => ['submit', 'upload', 'post', 'add content', 'create content', 'share'],
                'answer'     => 'Go to Dashboard → My Content → Create. You can add fan fiction, art, videos, and more. Make sure you\'re logged in first.',
                'sort_order' => 4,
            ],
            [
                'question'   => 'How do I bookmark content?',
                'keywords'   => ['bookmark', 'save', 'favourite', 'favorite', 'watchlist'],
                'answer'     => 'Click the bookmark icon on any content card or detail page. View all your bookmarks under Dashboard → Bookmarks.',
                'sort_order' => 5,
            ],
            [
                'question'   => 'How do I rate content?',
                'keywords'   => ['rate', 'rating', 'stars', 'review', 'score'],
                'answer'     => 'Open any content page and use the star rating widget. You must be logged in to leave a rating.',
                'sort_order' => 6,
            ],
            [
                'question'   => 'What content categories are available?',
                'keywords'   => ['categories', 'types', 'genre', 'anime', 'manga', 'movies', 'games'],
                'answer'     => 'FanHub+ supports Anime, Manga, Movies, TV Shows, Games, Books, and more. Browse all categories on the Explore page.',
                'sort_order' => 7,
            ],

            // ── Feedback / support ────────────────────────────────────────────
            [
                'question'   => 'How do I report inappropriate content?',
                'keywords'   => ['report', 'inappropriate', 'abuse', 'flag', 'offensive', 'spam'],
                'answer'     => 'Use the "Report" option on any content page, or submit a report via the Feedback form with category "Report".',
                'sort_order' => 8,
            ],
            [
                'question'   => 'How do I track my feedback submission?',
                'keywords'   => ['track', 'feedback', 'status', 'reference', 'check feedback'],
                'answer'     => 'Visit /feedback/status and enter your reference code (shown after submission) or your email address to see the current status.',
                'sort_order' => 9,
            ],
            [
                'question'   => 'How do I contact support?',
                'keywords'   => ['contact', 'support', 'help', 'email', 'admin'],
                'answer'     => 'Use the Feedback form at /feedback to reach our team. Select "General" for general enquiries or "Bug" to report an issue.',
                'sort_order' => 10,
            ],

            // ── Events ────────────────────────────────────────────────────────
            [
                'question'   => 'How do I RSVP to an event?',
                'keywords'   => ['rsvp', 'event', 'attend', 'going', 'interested', 'register event'],
                'answer'     => 'Open any event page and click "Going" or "Interested". You must be logged in. You can change your RSVP at any time from the same page.',
                'sort_order' => 11,
            ],
            [
                'question'   => 'How do I add an event to my calendar?',
                'keywords'   => ['calendar', 'ics', 'download', 'google calendar', 'export event'],
                'answer'     => 'On any event detail page, click "Add to Calendar" to download an .ics file compatible with Google Calendar, Outlook, and Apple Calendar.',
                'sort_order' => 12,
            ],

            // ── My List ───────────────────────────────────────────────────────
            [
                'question'   => 'What is My List and how do I use it?',
                'keywords'   => ['my list', 'watchlist', 'list', 'add to list', 'saved content', 'queue'],
                'answer'     => 'My List is your personal content queue. Click the "+" icon on any content card to add it. Access your list from your fandom profile page.',
                'sort_order' => 13,
            ],

            // ── Fandom profiles ───────────────────────────────────────────────
            [
                'question'   => 'What are fandom profiles and how do I create one?',
                'keywords'   => ['fandom profile', 'profile', 'create profile', 'switch profile', 'multiple profiles'],
                'answer'     => 'Fandom profiles let you keep separate watch histories and lists for different fandoms. Go to /profiles to create or switch between profiles.',
                'sort_order' => 14,
            ],

            // ── Merchandise ───────────────────────────────────────────────────
            [
                'question'   => 'How do I browse merchandise?',
                'keywords'   => ['merchandise', 'merch', 'shop', 'buy', 'store', 'products'],
                'answer'     => 'Visit /merchandise to browse all available fan merchandise. You can filter by tag or search by name. Click any item for full details.',
                'sort_order' => 15,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::firstOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, ['is_published' => true])
            );
        }
    }
}
