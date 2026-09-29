<?php

return [
    'enabled' => env('CHATBOT_ENABLED', true),
    'provider' => env('CHATBOT_PROVIDER', 'openai'),
    'models' => [
        'openai' => env('OPENAI_MODEL', 'gpt-4o-mini'),
        'gemini' => env('GEMINI_MODEL', 'gemini-3.8-flash'),
        'anthropic' => env('ANTHROPIC_MODEL', 'claude-sonnet-4-6'),
    ],
    'timeout' => (int) env('CHATBOT_TIMEOUT', 45),
];
