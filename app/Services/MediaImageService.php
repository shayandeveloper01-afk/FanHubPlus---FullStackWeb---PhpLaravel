<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * MediaImageService
 *
 * Resolves a *real* poster for a catalog record from a public media API so a
 * card can show genuine cover art instead of the generated FanHub+ artwork.
 * It sits between the stored image and the SVG fallback in
 * App\Support\ImageArtwork::source().
 *
 *   local upload  ->  external URL  ->  [this service]  ->  FanHub+ SVG
 *
 * Provider mapping
 *   anime / manga ........ Jikan v4 (MyAnimeList) — public, no credentials
 *   movie / film / tv / series ... TMDB v3 — Bearer token from .env only
 *   game / gaming ........ Steam Store artwork
 *   anything else ........ no request is made; the SVG fallback stands
 *
 * ── Guarantees ───────────────────────────────────────────────────────────────
 *  1. Never throws. Timeouts, invalid tokens, 429 rate limits and malformed
 *     payloads all resolve to null so the caller falls back to SVG artwork.
 *  2. Never leaves the server. The only URLs returned are public CDN image
 *     URLs; the TMDB token travels in a header and never appears in output.
 *  3. Called at most once per title per cache window. Results *and* misses are
 *     cached, and resolved values are memoised for the request lifetime so a
 *     single page render cannot issue the same lookup twice.
 *  4. Only http(s) URLs from known image hosts are accepted, so a poisoned
 *     API response cannot become a tracking pixel or a javascript: URI.
 *
 * Disable the whole feature with MEDIA_IMAGE_LOOKUP=false (config/services.php).
 */
class MediaImageService
{
    /** Record kinds whose artwork may resolve from the media catalog APIs. */
    private const API_KINDS = ['content', 'article', 'character', 'event', 'merchandise'];

    /** Image hosts we are willing to hand to an <img> tag. */
    private const IMAGE_HOSTS = [
        'image.tmdb.org',
        'cdn.myanimelist.net',
        'api-cdn.myanimelist.net',
        'steamstatic.com',
    ];

    /**
     * Category/type keyword => provider, matched in this order.
     * Anime/Manga come first because they are this app's own top-level
     * categories; an anime film filed under "Anime" is better served by Jikan
     * than by TMDB, which frequently has no record for it.
     */
    private const PROVIDER_KEYWORDS = [
        'anime'      => 'jikan-anime',
        'manga'      => 'jikan-manga',
        'movie'      => 'tmdb-movie',
        'film'       => 'tmdb-movie',
        'tv'         => 'tmdb-tv',
        'television' => 'tmdb-tv',
        'series'     => 'tmdb-tv',
        'game'       => 'steam-game',
        'gaming'     => 'steam-game',
    ];

    /**
     * Trailing editorial clauses that describe the *article* rather than the
     * work itself, stripped before searching: "Elden Ring: Shadow of the
     * Erdtree Review" becomes "Elden Ring".
     */
    private const EDITORIAL_TERMS = [
        'review', 'preview', 'recap', 'breakdown', 'guide', 'deep dive',
        'analysis', 'ranking', 'top 10', 'explained', 'impressions',
        'roundup', 'reaction', 'trailer', 'interview', 'news', 'spoiler',
        'watch', 'retrospective', 'verdict', 'thoughts',
    ];

    /** Resolved URLs for this request, so a page never repeats a lookup. */
    private array $resolved = [];

    /**
     * Return a poster URL for the given record, or null to let the caller fall
     * back to generated SVG artwork.
     */
    public function posterFor(string $title, string $category = '', string $kind = 'content', ?int $year = null, string $type = ''): ?string
    {
        if (! config('services.media_lookup.enabled', true)) {
            return null;
        }

        $provider = $this->providerFor($category, $kind, $type);

        if ($provider === null) {
            return null;
        }

        // The cleaned title usually matches better; the raw title is kept as a
        // second chance so cleaning can never destroy a legitimate title.
        foreach ($this->searchTerms($title) as $term) {
            $url = $this->remember($provider, $term, $year);

            if ($url !== null) {
                return $url;
            }
        }

        return null;
    }

    /**
     * Map a record's category/type/kind onto a provider, or null when the
     * record should not trigger an API call.
     */
    public function providerFor(string $category = '', string $kind = 'content', string $type = ''): ?string
    {
        $normalizedKind = strtolower(trim($kind));
        if (! in_array(strtolower(trim($kind)), self::API_KINDS, true)) {
            return null;
        }

        $tokens = preg_split('/[^a-z0-9]+/', strtolower(trim($category).' '.trim($type))) ?: [];

        if ($normalizedKind === 'character') {
            return in_array('anime', $tokens, true) || in_array('manga', $tokens, true)
                ? 'jikan-character'
                : null;
        }

        foreach (self::PROVIDER_KEYWORDS as $keyword => $provider) {
            foreach ($tokens as $token) {
                // Tolerate simple plurals so "Movies" and "TV Series" match.
                if ($token === $keyword || ($token !== '' && rtrim($token, 's') === $keyword)) {
                    return $provider;
                }
            }
        }

        return null;
    }


    /**
     * Resolve one provider lookup, memoised in the cache and then for the rest
     * of the request.
     */
    private function remember(string $provider, string $term, ?int $year): ?string
    {
        $key = 'media-poster:'.$provider.':'.mb_strtolower($term).':'.($year ?: '-');
        $config = str_starts_with($provider, 'tmdb')
            ? 'services.tmdb'
            : ($provider === 'steam-game' ? 'services.steam' : 'services.jikan');

        if (array_key_exists($key, $this->resolved)) {
            return $this->resolved[$key];
        }

        $cached = Cache::get($key);

        if (is_array($cached) && array_key_exists('url', $cached)) {
            return $this->resolved[$key] = $cached['url'] === null ? null : (string) $cached['url'];
        }

        $url = $this->fetch($provider, $term, $year);

        // Misses are cached too, but for a shorter window so a title that gains
        // an entry later can recover without a manual cache flush.
        Cache::put(
            $key,
            ['url' => $url],
            $url === null
                ? (int) config($config.'.cache_ttl_miss', 86400)
                : (int) config($config.'.cache_ttl', 604800)
        );

        return $this->resolved[$key] = $url;
    }

    private function fetch(string $provider, string $term, ?int $year): ?string
    {
        return match ($provider) {
            'jikan-anime' => $this->jikanPoster($term, 'anime'),
            'jikan-manga' => $this->jikanPoster($term, 'manga'),
            'jikan-character' => $this->jikanPoster($term, 'characters'),
            'tmdb-movie'  => $this->tmdbPoster($term, false, $year),
            'tmdb-tv'     => $this->tmdbPoster($term, true, $year),
            'steam-game'  => $this->steamGameImage($term),
            default       => null,
        };
    }

    /** Steam Store artwork for game catalog cards; no browser-side API call or key is needed. */
    private function steamGameImage(string $term): ?string
    {
        $baseUrl = rtrim((string) config('services.steam.base_url', 'https://store.steampowered.com/api'), '/');
        $timeout = (int) config('services.steam.timeout', 5);

        $search = $this->request(
            $baseUrl.'/storesearch',
            ['term' => $term, 'l' => 'english', 'cc' => 'US'],
            [],
            $timeout
        );

        $appId = data_get($search, 'items.0.id');

        if (! is_numeric($appId)) {
            return null;
        }

        $details = $this->request(
            $baseUrl.'/appdetails',
            ['appids' => (string) $appId, 'cc' => 'US', 'l' => 'english'],
            [],
            $timeout
        );

        $headerImage = data_get($details, (string) $appId.'.data.header_image');

        return is_string($headerImage) ? $this->allowedImageUrl($headerImage) : null;
    }

    /** TMDB v3 movie/tv poster. Returns null when unconfigured or on failure. */
    private function tmdbPoster(string $term, bool $tv, ?int $year): ?string
    {
        $token = trim((string) config('services.tmdb.token'));

        // No token configured: skip the call entirely rather than firing a
        // request that is guaranteed to 401.
        if ($token === '') {
            return null;
        }

        $query = [
            'query'         => $term,
            'language'      => 'en-US',
            'include_adult' => 'false',
            'page'          => 1,
        ];

        if ($year !== null && $year >= 1900 && $year <= 2100) {
            $query[$tv ? 'first_air_date_year' : 'year'] = $year;
        }

        $payload = $this->request(
            rtrim((string) config('services.tmdb.base_url'), '/').'/'.($tv ? 'search/tv' : 'search/movie'),
            $query,
            ['Authorization' => 'Bearer '.$token],
            (int) config('services.tmdb.timeout', 5)
        );

        $posterPath = data_get($payload, 'results.0.poster_path');

        if (! is_string($posterPath) || $posterPath === '') {
            return null;
        }

        return $this->allowedImageUrl(sprintf(
            '%s/%s%s',
            rtrim((string) config('services.tmdb.image_base'), '/'),
            config('services.tmdb.poster_size', 'w500'),
            $posterPath
        ));
    }

    /** Jikan v4 anime/manga cover. Returns null on failure or no match. */
    private function jikanPoster(string $term, string $type): ?string
    {
        $payload = $this->request(
            rtrim((string) config('services.jikan.base_url'), '/').'/'.$type,
            [
                'q'     => $term,
                'limit' => 1,
                'sfw'   => config('services.jikan.sfw', true) ? 'true' : 'false',
            ],
            [],
            (int) config('services.jikan.timeout', 5)
        );

        foreach (['large_image_url', 'image_url', 'small_image_url'] as $size) {
            $image = data_get($payload, 'data.0.images.jpg.'.$size);

            if (is_string($image) && $image !== '') {
                return $this->allowedImageUrl($image);
            }
        }

        return null;
    }

    /**
     * Perform a JSON GET, returning the decoded body or null.
     *
     * Never throws: connection errors, timeouts, 401 (bad token) and 429
     * (rate limited) all become null so the page still renders. Credentials are
     * never written to the log.
     */
    private function request(string $url, array $query, array $headers, int $timeout): ?array
    {
        $timeout = max(1, $timeout);

        try {
            $response = Http::acceptJson()
                ->withHeaders($headers)
                ->connectTimeout(min(3, $timeout))
                ->timeout($timeout)
                ->get($url, $query);

            if (! $response->successful()) {
                Log::warning('media.poster_lookup_rejected', [
                    'url'    => $url,
                    'status' => $response->status(),
                ]);

                return null;
            }

            $payload = $response->json();

            return is_array($payload) ? $payload : null;
        } catch (Throwable $e) {
            Log::warning('media.poster_lookup_failed', [
                'url'   => $url,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Only http(s) URLs served by a known image CDN are allowed through, so a
     * malformed or hostile API response cannot become an <img> src.
     */
    private function allowedImageUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        $parts = parse_url($url);

        if (! is_array($parts) || ! isset($parts['scheme'], $parts['host'])) {
            return null;
        }

        if (! in_array(strtolower($parts['scheme']), ['https', 'http'], true)) {
            return null;
        }

        $host = strtolower($parts['host']);

        foreach (self::IMAGE_HOSTS as $allowed) {
            if ($host === $allowed || str_ends_with($host, '.'.$allowed)) {
                return $url;
            }
        }

        Log::warning('media.poster_url_rejected', ['host' => $host]);

        return null;
    }



    /**
     * Search terms to try, best guess first. The cleaned title leads; the raw
     * title is always kept as a fallback so cleaning can never destroy a
     * legitimate title.
     *
     * @return list<string>
     */
    private function searchTerms(string $title): array
    {
        $raw = trim((string) preg_replace('/\s+/u', ' ', $title));

        if ($raw === '') {
            return [];
        }

        $terms = [];

        foreach ([$this->cleanTitle($raw), $raw] as $candidate) {
            $candidate = trim($candidate);

            if ($candidate !== '' && ! in_array(mb_strtolower($candidate), array_map('mb_strtolower', $terms), true)) {
                $terms[] = $candidate;
            }
        }

        return $terms;
    }

    /**
     * Strip bracketed asides and a trailing editorial clause.
     *
     *   "Elden Ring: Shadow of the Erdtree Review" -> "Elden Ring"
     *   "Frieren: Beyond Journey's End"            -> unchanged
     *   "Interstellar (2014)"                      -> "Interstellar"
     *
     * Only splits on a *spaced* dash or colon, so hyphenated titles such as
     * "Spider-Man: Across the Spider-Verse" keep their real title.
     */
    private function cleanTitle(string $title): string
    {
        $title = (string) preg_replace('/[\(\[\{][^\)\]\}]*[\)\]\}]/u', ' ', $title);

        $segments = preg_split('/\s+[—–-]\s+|\s+:\s+/u', $title) ?: [$title];

        $kept = [];

        foreach ($segments as $index => $segment) {
            $segment = trim($segment);

            if ($segment === '') {
                continue;
            }

            if ($index > 0 && $this->looksEditorial($segment)) {
                break;
            }

            $kept[] = $segment;
        }

        return trim((string) preg_replace('/[\s,;:\-–—]+$/u', '', implode(' — ', $kept)));
    }

    /** True when a segment reads like commentary rather than a work's title. */
    private function looksEditorial(string $segment): bool
    {
        $normalised = mb_strtolower($segment);

        foreach (self::EDITORIAL_TERMS as $term) {
            if (str_contains($normalised, $term)) {
                return true;
            }
        }

        return false;
    }
}
{}
