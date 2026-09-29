<?php

namespace App\Support;

use Illuminate\Support\Facades\Config;

class EventLocations
{
    public static function countryNames(): array
    {
        return array_keys(Config::get('event_locations.countries', []));
    }

    public static function cities(?string $country): array
    {
        $countries = Config::get('event_locations.countries', []);
        return $country ? ($countries[$country]['cities'] ?? []) : [];
    }

    public static function coordinates(?string $country, ?string $city): ?array
    {
        if (! $country || ! $city) return null;
        foreach (self::cities($country) as $name => $coordinates) {
            if (mb_strtolower($name) === mb_strtolower(trim($city))) return $coordinates;
        }
        return null;
    }
}
