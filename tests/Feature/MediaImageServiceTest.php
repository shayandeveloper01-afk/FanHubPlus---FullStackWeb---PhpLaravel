<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Content;
use App\Models\User;
use App\Support\ImageArtwork;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Covers the full ImageArtwork resolution chain:
 *
 *   local upload -> external URL -> TMDB/Jikan poster -> FanHub+ SVG
 */
class MediaImageServiceTest extends TestCase
{
    use RefreshDatabase;

    private const TOKEN = 'super-secret-tmdb-token';

    private const JIKAN_POSTER = 'https://cdn.myanimelist.net/images/anime/4/19644.jpg';

    private const TMDB_POSTER = 'https://image.tmdb.org/t/p/w500/abc123.jpg';

    protected function setUp(): void
    {
        parent::setUp();

        // Re-enable the feature that phpunit.xml switches off by default, and
        // make any unfaked outbound request fail loudly instead of reaching the
        // real network.
        config([
            'services.media_lookup.enabled' => true,
            'services.tmdb.token' => self::TOKEN,
        ]);

        Http::preventStrayRequests();
        Cache::flush();
    }

    public function test_anime_title_resolves_a_jikan_poster(): void
    {
        Http::fake(['api.jikan.moe/v4/anime*' => Http::response([
            'data' => [['images' => ['jpg' => ['large_image_url' => self::JIKAN_POSTER]]]],
        ])]);

        $url = ImageArtwork::source(null, 'Frieren: Beyond Journeys End', 'Anime', 'content', 1, 2023, 'anime');

        $this->assertSame(self::JIKAN_POSTER, $url);
        Http::assertSent(fn (Request $r) => str_contains($r->url(), 'api.jikan.moe/v4/anime'));
    }

    public function test_manga_title_resolves_through_the_jikan_manga_endpoint(): void
    {
        Http::fake(['api.jikan.moe/v4/manga*' => Http::response([
            'data' => [['images' => ['jpg' => ['image_url' => self::JIKAN_POSTER]]]],
        ])]);

        $url = ImageArtwork::source(null, 'Berserk', 'Manga', 'content', 2, 1989, 'manga');

        $this->assertSame(self::JIKAN_POSTER, $url);
        Http::assertSent(fn (Request $r) => str_contains($r->url(), 'api.jikan.moe/v4/manga'));
    }

    public function test_movie_title_resolves_a_tmdb_poster_using_bearer_auth(): void
    {
        Http::fake(['api.themoviedb.org/3/search/movie*' => Http::response([
            'results' => [['poster_path' => '/abc123.jpg']],
        ])]);

        $url = ImageArtwork::source(null, 'Interstellar (2014)', 'Movies', 'content', 3, 2014, 'movie');

        $this->assertSame(self::TMDB_POSTER, $url);

        Http::assertSent(function (Request $r) {
            // The token travels in a header, never in the query string.
            return $r->hasHeader('Authorization', 'Bearer '.self::TOKEN)
                && ! str_contains($r->url(), self::TOKEN)
                && (string) $r['year'] === '2014'
                && $r['include_adult'] === 'false';
        });
    }

    public function test_tv_series_title_uses_the_tmdb_tv_endpoint(): void
    {
        Http::fake(['api.themoviedb.org/3/search/tv*' => Http::response([
            'results' => [['poster_path' => '/tv456.jpg']],
        ])]);

        $url = ImageArtwork::source(null, 'Breaking Bad', 'TV Series', 'content', 4, 2008, 'series');

        $this->assertSame('https://image.tmdb.org/t/p/w500/tv456.jpg', $url);
        Http::assertSent(fn (Request $r) => str_contains($r->url(), '/search/tv') && (string) $r['first_air_date_year'] === '2008');
    }

    public function test_a_title_with_no_api_result_falls_back_to_generated_svg_artwork(): void
    {
        Http::fake([
            'api.jikan.moe/*' => Http::response(['data' => []]),
            'api.themoviedb.org/*' => Http::response(['results' => []]),
        ]);

        $url = ImageArtwork::source(null, 'Zzzqq Not A Real Franchise', 'Anime', 'content', 5);

        $this->assertStringStartsWith('data:image/svg+xml;base64,', $url);
    }

    public function test_api_failures_never_break_rendering_and_still_fall_back_to_svg(): void
    {
        foreach ([500, 401, 429] as $status) {
            Cache::flush();
            Http::fake(['*' => Http::response(['status_message' => 'nope'], $status)]);

            $url = ImageArtwork::source(null, 'Cowboy Bebop', 'Anime', 'content', 6);

            $this->assertStringStartsWith('data:image/svg+xml;base64,', $url, "status {$status} should fall back");
        }
    }

    public function test_a_connection_timeout_falls_back_to_svg_without_throwing(): void
    {
        Http::fake(fn () => throw new ConnectionException('Connection timed out'));

        $url = ImageArtwork::source(null, 'Planetes', 'Anime', 'content', 7);

        $this->assertStringStartsWith('data:image/svg+xml;base64,', $url);
    }

    public function test_game_title_resolves_a_steam_store_image(): void
    {
        Http::fake([
            'store.steampowered.com/api/storesearch*' => Http::response([
                'items' => [['id' => 1245620, 'name' => 'Elden Ring']],
            ]),
            'store.steampowered.com/api/appdetails*' => Http::response([
                '1245620' => ['success' => true, 'data' => ['header_image' => 'https://cdn.akamai.steamstatic.com/steam/apps/1245620/header.jpg']],
            ]),
        ]);

        $url = ImageArtwork::source(null, 'Elden Ring', 'Gaming', 'content', 8, 2022, 'game');

        $this->assertSame('https://cdn.akamai.steamstatic.com/steam/apps/1245620/header.jpg', $url);
        Http::assertSentCount(2);
    }

    public function test_events_and_merchandise_can_resolve_media_posters(): void
    {
        Http::fake(['api.jikan.moe/v4/anime*' => Http::response([
            'data' => [['images' => ['jpg' => ['large_image_url' => self::JIKAN_POSTER]]]],
        ])]);

        $this->assertSame(self::JIKAN_POSTER, ImageArtwork::source(null, 'Tokyo Anime Festival', 'Anime', 'event', 9));
        $this->assertSame(self::JIKAN_POSTER, ImageArtwork::source(null, 'Kaneda Jacket', 'Anime', 'merchandise', 10));
        Http::assertSentCount(2);
    }

    public function test_a_local_upload_wins_and_is_never_replaced_by_an_api_poster(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('content/poster.jpg', 'binary');
        Http::fake();

        $url = ImageArtwork::source('content/poster.jpg', 'Frieren', 'Anime', 'content', 11, 2023, 'anime');

        $this->assertStringContainsString('content/poster.jpg', $url);
        Http::assertNothingSent();
    }

    public function test_an_existing_external_url_wins_and_is_never_replaced(): void
    {
        Storage::fake('public');
        Http::fake();

        $url = ImageArtwork::source('https://example.test/custom.jpg', 'Frieren', 'Anime', 'content', 12, 2023, 'anime');

        $this->assertSame('https://example.test/custom.jpg', $url);
        Http::assertNothingSent();
    }

    public function test_generated_seeder_artwork_yields_to_a_real_poster_but_survives_a_miss(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('catalog-artwork/content/1-frieren.svg', '<svg/>');
        Http::fake(fn (Request $request) => str_contains($request->url(), 'q=Frieren')
            ? Http::response(['data' => [['images' => ['jpg' => ['large_image_url' => self::JIKAN_POSTER]]]]])
            : Http::response(['data' => []]));

        $this->assertStringContainsString(
            'catalog-artwork/content/1-frieren.svg',
            ImageArtwork::source('catalog-artwork/content/1-frieren.svg', 'No Such Anime Anywhere', 'Anime', 'content', 13)
        );

        $this->assertSame(
            self::JIKAN_POSTER,
            ImageArtwork::source('catalog-artwork/content/1-frieren.svg', 'Frieren', 'Anime', 'content', 14, 2023, 'anime')
        );
    }

    public function test_results_are_cached_so_the_api_is_only_called_once_per_title(): void
    {
        Http::fake(['api.jikan.moe/*' => Http::response([
            'data' => [['images' => ['jpg' => ['large_image_url' => self::JIKAN_POSTER]]]],
        ])]);

        $first = ImageArtwork::source(null, 'Steins Gate', 'Anime', 'content', 15, 2011, 'anime');
        $second = ImageArtwork::source(null, 'Steins Gate', 'Anime', 'content', 15, 2011, 'anime');

        $this->assertSame(self::JIKAN_POSTER, $first);
        $this->assertSame(self::JIKAN_POSTER, $second);

        // Title cleaning is stable, so only one Jikan call is made in total.
        Http::assertSentCount(1);
    }

    public function test_a_blank_tmdb_token_skips_the_request_entirely(): void
    {
        config(['services.tmdb.token' => '']);
        Http::fake();

        $url = ImageArtwork::source(null, 'Arrival', 'Movies', 'content', 16, 2016, 'movie');

        $this->assertStringStartsWith('data:image/svg+xml;base64,', $url);
        Http::assertNothingSent();
    }

    public function test_the_feature_can_be_switched_off_entirely(): void
    {
        config(['services.media_lookup.enabled' => false]);
        Http::fake();

        $this->assertStringStartsWith('data:image/svg+xml;base64,', ImageArtwork::source(null, 'Frieren', 'Anime', 'content', 17));
        Http::assertNothingSent();
    }

    public function test_untrusted_image_hosts_from_an_api_response_are_rejected(): void
    {
        Http::fake(['api.jikan.moe/*' => Http::response([
            'data' => [['images' => ['jpg' => ['large_image_url' => 'https://evil.test/tracker.gif']]]],
        ])]);

        $url = ImageArtwork::source(null, 'Frieren', 'Anime', 'content', 18, 2023, 'anime');

        $this->assertStringStartsWith('data:image/svg+xml;base64,', $url);
    }

    public function test_a_real_card_renders_the_poster_and_never_leaks_the_token(): void
    {
        Http::fake(['api.jikan.moe/*' => Http::response([
            'data' => [['images' => ['jpg' => ['large_image_url' => self::JIKAN_POSTER]]]],
        ])]);

        $user = User::factory()->create();
        $category = Category::create(['name' => 'Anime', 'slug' => 'anime', 'status' => 'active']);
        $content = Content::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Frieren: Beyond Journeys End',
            'body' => 'A journey beyond the journey.',
            'status' => 'published',
            'type' => 'anime',
            'year' => 2023,
        ]);

        $html = $this->get(route('contents.show', $content))->assertOk()->getContent();

        $this->assertStringContainsString(self::JIKAN_POSTER, $html);
        $this->assertStringContainsString('<img src="'.self::JIKAN_POSTER.'"', $html);
        $this->assertStringNotContainsString(self::TOKEN, $html);
    }

    public function test_homepage_card_passes_the_resolved_poster_to_its_image_source(): void
    {
        Http::fake(['api.jikan.moe/v4/anime*' => Http::response([
            'data' => [['images' => ['jpg' => ['large_image_url' => self::JIKAN_POSTER]]]],
        ])]);

        $user = User::factory()->create();
        $category = Category::create(['name' => 'Anime', 'slug' => 'anime', 'status' => 'active']);
        Content::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Jujutsu Kaisen',
            'body' => 'A sorcerer story.',
            'status' => 'published',
            'type' => 'anime',
            'year' => 2020,
        ]);

        $html = $this->get(route('home'))->assertOk()->getContent();

        $this->assertStringContainsString('<img src="'.self::JIKAN_POSTER.'"', $html);
        Http::assertSent(fn (Request $request) => str_contains($request->url(), 'api.jikan.moe/v4/anime'));
    }
}
;
