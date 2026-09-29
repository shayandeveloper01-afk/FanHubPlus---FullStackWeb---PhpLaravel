<?php

namespace App\Support;

use App\Services\MediaImageService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * Resolution order for any record's image:
 *
 *   1. the record's own uploaded file or external URL   (never overridden)
 *   2. an automatic TMDB / Jikan / Steam poster          (real cover art)
 *   3. a category image from public/images/categories/   (NEW)
 *   4. the generated FanHub+ SVG artwork                 (always available)
 */
class ImageArtwork
{
    private const GENERATED_PREFIX = 'catalog-artwork/';

    /** keyword found in category/kind  =>  folder inside public/images/categories */
    private const CATEGORY_FOLDERS = [
        'anime' => 'anime', 'manga' => 'manga',
        'movie' => 'movies', 'film' => 'movies',
        'tv' => 'tv-series', 'series' => 'tv-series', 'television' => 'tv-series',
        'game' => 'gaming', 'gaming' => 'gaming',
        'comic' => 'comics', 'cosplay' => 'cosplay',
        'event' => 'events', 'article' => 'articles',
    ];

    private static array $folderCache = [];

    public static function source(?string $path, string $title, string $category = '', string $kind = 'content', string|int|null $key = null, ?int $year = null, string $type = ''): string
    {
        $path = trim((string) $path);
        $normalized = ltrim(str_replace('\\', '/', $path), '/');
        if (str_starts_with($normalized, 'storage/')) $normalized = substr($normalized, 8);

        $generated = $normalized !== '' && str_starts_with($normalized, self::GENERATED_PREFIX);

        if ($path !== '' && ! $generated) {
            if (filter_var($path, FILTER_VALIDATE_URL) && in_array(strtolower((string) parse_url($path, PHP_URL_SCHEME)), ['http', 'https'], true)) {
                return $path;
            }

            if (Storage::disk('public')->exists($normalized)) return Storage::disk('public')->url($normalized);
        }

        $poster = self::apiPoster($title, $category, $kind, $year, $type);
        if ($poster !== null) return $poster;

        $categoryImage = self::categoryImage($category, $kind, $key ?? $title);
        if ($categoryImage !== null) return $categoryImage;

        if ($generated && Storage::disk('public')->exists($normalized)) return Storage::disk('public')->url($normalized);

        return self::dataUri($title, $category, $kind, $key);
    }

    public static function apiPoster(string $title, string $category = '', string $kind = 'content', ?int $year = null, string $type = ''): ?string
    {
        try {
            return app(MediaImageService::class)->posterFor($title, $category, $kind, $year, $type);
        } catch (Throwable $e) {
            Log::warning('artwork.api_poster_unavailable', [
                'kind'  => $kind,
                'title' => $title,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Pick an image from public/images/categories/<folder>/ for this category.
     * The same record always gets the same image (hash of its key), while
     * different records spread across all images in the folder.
     */
    public static function categoryImage(string $category, string $kind, string|int $key): ?string
    {
        $folder = self::categoryFolder($category, $kind);
        if ($folder === null) return null;

        if (! isset(self::$folderCache[$folder])) {
            $files = File::glob(public_path("images/categories/{$folder}/*.{jpg,jpeg,png,webp,avif}"), GLOB_BRACE) ?: [];
            sort($files);
            self::$folderCache[$folder] = array_map('basename', $files);
        }

        $files = self::$folderCache[$folder];
        if ($files === []) return null;

        $file = $files[crc32($kind.'|'.$key) % count($files)];

        return asset("images/categories/{$folder}/{$file}");
    }

    private static function categoryFolder(string $category, string $kind): ?string
    {
        // 1) exact slug of the category name ("TV Series" -> tv-series)
        $slug = Str::slug($category);
        if ($slug !== '' && is_dir(public_path("images/categories/{$slug}"))) return $slug;

        // 2) keyword match, category first, then kind
        foreach ([$category, $kind] as $text) {
            $tokens = preg_split('/[^a-z0-9]+/', strtolower($text)) ?: [];
            foreach (self::CATEGORY_FOLDERS as $keyword => $folder) {
                foreach ($tokens as $token) {
                    if ($token === $keyword || rtrim($token, 's') === $keyword) return $folder;
                }
            }
        }

        return null;
    }

    public static function dataUri(string $title, string $category = '', string $kind = 'content', string|int|null $key = null): string
    {
        return 'data:image/svg+xml;base64,'.base64_encode(self::svg($title, $category, $kind, $key));
    }

    /** Category artwork for a failed image request, with generated SVG as the final fallback. */
    public static function fallbackSource(string $title, string $category = '', string $kind = 'content', string|int|null $key = null): string
    {
        return self::categoryImage($category, $kind, $key ?? $title)
            ?? self::dataUri($title, $category, $kind, $key);
    }

    public static function svg(string $title, string $category = '', string $kind = 'content', string|int|null $key = null): string
    {
        $hash = hash('sha256', implode('|', [$kind, $category, $title, $key ?? '']));
        $themes = [
            'anime' => ['#f472b6', '#7c3aed'], 'manga' => ['#fb7185', '#6d28d9'],
            'gaming' => ['#22d3ee', '#6d28d9'], 'game' => ['#22d3ee', '#6d28d9'],
            'film' => ['#fb7185', '#4338ca'], 'movie' => ['#fb7185', '#4338ca'],
            'tv' => ['#c084fc', '#312e81'], 'series' => ['#c084fc', '#312e81'],
            'music' => ['#f472b6', '#4f46e5'], 'sports' => ['#34d399', '#4338ca'],
            'art' => ['#fbbf24', '#9333ea'], 'podcast' => ['#38bdf8', '#7e22ce'],
            'event' => ['#f472b6', '#6d28d9'], 'merchandise' => ['#c084fc', '#be185d'],
            'character' => ['#f9a8d4', '#5b21b6'], 'article' => ['#a78bfa', '#be185d'],
            'comic' => ['#34d399', '#0f766e'], 'cosplay' => ['#fb7185', '#9d174d'],
        ];
        $categoryKey = strtolower(trim($category));
        $kindKey = strtolower(trim($kind));
        $palette = null;
        // category wins over kind, so an "Anime" article is pink, not generic article purple
        foreach ($themes as $name => $colors) {
            if ($categoryKey !== '' && str_contains($categoryKey, $name)) { $palette = $colors; break; }
        }
        $palette ??= $themes[$kindKey] ?? ['#c084fc', '#db2777'];
        [$accent, $deep] = $palette;
        $shift = hexdec(substr($hash, 0, 2)) % 360;
        $line1 = self::xml(mb_strimwidth(trim($title) ?: 'FanHub+ Feature', 0, 36, '…'));
        $line2 = self::xml(self::categoryLabel($category, $kind));
        $motifKey = $categoryKey !== '' ? $categoryKey : $kindKey;
        $motif = self::motif($motifKey, $hash, $accent);

        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 540" role="img" aria-label="'.self::xml($title).' artwork">'
            .'<defs><linearGradient id="bg" x1="0" y1="0" x2="1" y2="1"><stop stop-color="#0b0b16"/><stop offset=".55" stop-color="'.$deep.'"/><stop offset="1" stop-color="#10101d"/></linearGradient>'
            .'<radialGradient id="glow"><stop stop-color="'.$accent.'" stop-opacity=".76"/><stop offset="1" stop-color="'.$accent.'" stop-opacity="0"/></radialGradient>'
            .'<pattern id="grid" width="34" height="34" patternUnits="userSpaceOnUse"><path d="M34 0H0V34" fill="none" stroke="#fff" stroke-opacity=".055"/></pattern></defs>'
            .'<rect width="960" height="540" fill="url(#bg)"/><circle cx="'.(650 + ($shift % 130)).'" cy="'.(80 + ($shift % 100)).'" r="300" fill="url(#glow)" opacity=".64"/>'
            .'<rect width="960" height="540" fill="url(#grid)"/><path d="M0 430 420 250 700 540H0Z" fill="#070710" opacity=".34"/>'.$motif
            .'<path d="M58 76h56" stroke="'.$accent.'" stroke-width="5" stroke-linecap="round"/><text x="58" y="111" fill="#e9d5ff" font-family="Arial,sans-serif" font-size="18" font-weight="700" letter-spacing="4">FANHUB+</text>'
            .'<text x="58" y="394" fill="#fff" font-family="Arial,sans-serif" font-size="38" font-weight="800">'.$line1.'</text>'
            .'<text x="60" y="435" fill="'.$accent.'" font-family="Arial,sans-serif" font-size="16" font-weight="700" letter-spacing="3">'.strtoupper($line2).'</text>'
            .'<path d="M58 470h210" stroke="#fff" stroke-opacity=".25"/><text x="58" y="503" fill="#e5e7eb" fill-opacity=".62" font-family="Arial,sans-serif" font-size="13" letter-spacing="2">DISCOVER YOUR NEXT OBSESSION</text>'
            .'</svg>';
    }

    private static function motif(string $kind, string $hash, string $accent): string
    {
        $x = 625 + (hexdec(substr($hash, 2, 2)) % 90);
        return match (true) {
            str_contains($kind, 'anime'), str_contains($kind, 'manga') => '<circle cx="'.$x.'" cy="210" r="136" fill="none" stroke="'.$accent.'" stroke-opacity=".62" stroke-width="2"/><circle cx="'.$x.'" cy="210" r="98" fill="none" stroke="#fff" stroke-opacity=".22"/><path d="M'.$x.' 44v42m0 248v42m-166-166h42m248 0h42m-284-118 30 30m216 216 30 30m0-276-30 30m-216 216-30 30" stroke="'.$accent.'" stroke-width="5" stroke-linecap="round" opacity=".75"/><path d="M'.($x-48).' 238q48-42 96 0-48 56-96 0" fill="#fff" fill-opacity=".15" stroke="#fff" stroke-opacity=".58" stroke-width="3"/>',
            str_contains($kind, 'game') => '<path d="M520 184q10-33 48-33h164q38 0 48 33l32 112q12 42-22 54-20 7-37-12l-30-34H577l-30 34q-17 19-37 12-34-12-22-54z" fill="#090914" fill-opacity=".66" stroke="'.$accent.'" stroke-width="4"/><path d="M602 218v64m-32-32h64" stroke="#fff" stroke-width="10" stroke-linecap="round"/><circle cx="735" cy="232" r="10" fill="'.$accent.'"/><circle cx="764" cy="260" r="10" fill="#fff"/>',
            str_contains($kind, 'film'), str_contains($kind, 'movie'), str_contains($kind, 'tv'), str_contains($kind, 'series') => '<rect x="532" y="125" width="278" height="205" rx="20" fill="#090914" fill-opacity=".55" stroke="'.$accent.'" stroke-width="4"/><rect x="557" y="153" width="228" height="145" rx="8" fill="#fff" fill-opacity=".08"/><path d="m650 190 67 35-67 35z" fill="'.$accent.'"/><path d="M532 125h278l-36 44h-278z" fill="#fff" fill-opacity=".13"/>',
            str_contains($kind, 'music'), str_contains($kind, 'podcast') => self::waveform($hash, $accent),
            str_contains($kind, 'sport') => '<circle cx="680" cy="220" r="126" fill="#fff" fill-opacity=".09" stroke="'.$accent.'" stroke-width="4"/><path d="m680 94 38 48-15 56h-46l-15-56zm-123 89 55 15 18 54-40 29-48-34zm246 0-55 15-18 54 40 29 48-34zm-203 129 30-47h54l30 47m-123-61 36 26h56l36-26" fill="none" stroke="#fff" stroke-opacity=".65" stroke-width="5"/>',
            str_contains($kind, 'character'), str_contains($kind, 'cosplay') => '<circle cx="680" cy="174" r="66" fill="'.$accent.'" fill-opacity=".55"/><path d="M535 337q24-112 145-112t145 112v22H535z" fill="#090914" fill-opacity=".7" stroke="#fff" stroke-opacity=".45" stroke-width="3"/><path d="M614 173q66-83 132 0" fill="none" stroke="#fff" stroke-opacity=".65" stroke-width="7"/>',
            str_contains($kind, 'comic') => '<rect x="530" y="120" width="130" height="100" rx="8" fill="#090914" fill-opacity=".62" stroke="'.$accent.'" stroke-width="4"/><rect x="680" y="120" width="140" height="100" rx="8" fill="#fff" fill-opacity=".1" stroke="'.$accent.'" stroke-width="4"/><rect x="530" y="240" width="290" height="100" rx="8" fill="#090914" fill-opacity=".62" stroke="'.$accent.'" stroke-width="4"/><path d="m640 268 22 30h-14l10 38-40-46h16z" fill="'.$accent.'"/>',
            str_contains($kind, 'article'), str_contains($kind, 'resource') => '<path d="M570 105h166l68 68v190H570z" fill="#090914" fill-opacity=".62" stroke="'.$accent.'" stroke-width="4"/><path d="M736 105v70h68M605 220h158m-158 35h158m-158 35h120" stroke="#fff" stroke-opacity=".56" stroke-width="7" stroke-linecap="round"/>',
            str_contains($kind, 'merch') => '<path d="m564 190 46-57h140l46 57-28 40-27-17v135H619V213l-27 17z" fill="#090914" fill-opacity=".7" stroke="'.$accent.'" stroke-width="4"/><path d="M642 136q0 58 38 58t38-58" fill="none" stroke="#fff" stroke-opacity=".65" stroke-width="6"/>',
            str_contains($kind, 'event') => '<path d="M540 170h280v165H540z" rx="18" fill="#090914" fill-opacity=".65" stroke="'.$accent.'" stroke-width="4"/><path d="M585 170v-35m190 35v-35M540 220h280" stroke="#fff" stroke-opacity=".65" stroke-width="7"/><circle cx="612" cy="270" r="16" fill="'.$accent.'"/><circle cx="680" cy="270" r="16" fill="#fff" fill-opacity=".8"/><circle cx="748" cy="270" r="16" fill="'.$accent.'"/>',
            default => '<path d="M540 280 628 120l80 126 58-73 108 160H530z" fill="#fff" fill-opacity=".13" stroke="'.$accent.'" stroke-opacity=".7" stroke-width="3"/><circle cx="756" cy="145" r="36" fill="'.$accent.'" fill-opacity=".7"/>',
        };
    }

    private static function waveform(string $hash, string $accent): string
    {
        $bars = '';
        for ($i = 0; $i < 21; $i++) {
            $height = 24 + (hexdec(substr($hash, ($i * 2) % 58, 2)) % 116);
            $bars .= '<rect x="'.(535 + $i * 14).'" y="'.(232 - $height / 2).'" width="7" height="'.$height.'" rx="3.5" fill="'.$accent.'" opacity="'.(0.45 + (($i % 4) * .13)).'"/>';
        }
        return '<rect x="510" y="130" width="340" height="205" rx="24" fill="#090914" fill-opacity=".55" stroke="#fff" stroke-opacity=".24"/>'.$bars;
    }

    private static function categoryLabel(string $category, string $kind): string
    {
        return trim($category) !== '' ? $category : ucfirst($kind ?: 'FanHub+');
    }

    private static function xml(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_XML1, 'UTF-8');
    }
}
