<?php

return [
    'default_location' => [
        'name' => env('EVENTS_DEFAULT_LOCATION_NAME', 'Karachi, Pakistan'),
        'city' => env('EVENTS_DEFAULT_LOCATION_CITY', 'Karachi'),
        'latitude' => env('EVENTS_DEFAULT_LOCATION_LATITUDE') ?: 24.8607,
        'longitude' => env('EVENTS_DEFAULT_LOCATION_LONGITUDE') ?: 67.0011,
    ],
];
