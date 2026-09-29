<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'openai' => [
        'key' => env('OPENAI_API_KEY'),
        'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
        'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
    ],
    'gemini' => [
        'key' => env('GEMINI_API_KEY'),
    ],
    'anthropic' => [
        'key' => env('ANTHROPIC_API_KEY'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Automatic Poster Lookup (TMDB + Jikan)
    |--------------------------------------------------------------------------
    |
    | Used by App\Services\MediaImageService to put a real poster on a card
    | when the record has no uploaded image. Contacts happen server-side only,
    | so these credentials are never rendered into Blade or JavaScript.
    |
    | Jikan is the public MyAnimeList API and needs no credentials. TMDB needs
    | a v3 read access token; when it is blank, TMDB lookups are skipped
    | entirely (no request is made) and the FanHub+ SVG artwork is used.
    |
    */

    'media_lookup' => [
        'enabled' => filter_var(env('MEDIA_IMAGE_LOOKUP', true), FILTER_VALIDATE_BOOL),
    ],

    'tmdb' => [
        'token'          => env('TMDB_API_TOKEN'),
        'base_url'       => env('TMDB_BASE_URL', 'https://api.themoviedb.org/3'),
        'image_base'     => env('TMDB_IMAGE_BASE_URL', 'https://image.tmdb.org/t/p'),
        'poster_size'    => env('TMDB_POSTER_SIZE', 'w500'),
        'timeout'        => (int) env('TMDB_TIMEOUT', 5),
        'cache_ttl'      => (int) env('TMDB_CACHE_TTL', 604800),
        'cache_ttl_miss' => (int) env('TMDB_CACHE_TTL_MISS', 86400),
    ],

    'jikan' => [
        'base_url'       => env('JIKAN_BASE_URL', 'https://api.jikan.moe/v4'),
        'timeout'        => (int) env('JIKAN_TIMEOUT', 5),
        'sfw'            => filter_var(env('JIKAN_SFW', true), FILTER_VALIDATE_BOOL),
        'cache_ttl'      => (int) env('JIKAN_CACHE_TTL', 604800),
        'cache_ttl_miss' => (int) env('JIKAN_CACHE_TTL_MISS', 86400),
    ],

    'steam' => [
        'base_url' => env('STEAM_STORE_API_BASE_URL', 'https://store.steampowered.com/api'),
        'timeout'  => (int) env('STEAM_STORE_API_TIMEOUT', 5),
        'cache_ttl' => (int) env('STEAM_IMAGE_CACHE_TTL', 604800),
        'cache_ttl_miss' => (int) env('STEAM_IMAGE_CACHE_TTL_MISS', 86400),
    ],

];
