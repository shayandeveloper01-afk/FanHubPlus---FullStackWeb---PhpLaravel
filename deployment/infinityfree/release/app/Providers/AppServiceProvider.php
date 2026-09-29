<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Bookmark;
use App\Models\Content;
use App\Models\ContentNote;
use App\Models\Event;
use App\Models\Merchandise;
use App\Policies\ArticlePolicy;
use App\Policies\BookmarkPolicy;
use App\Policies\ContentNotePolicy;
use App\Policies\ContentPolicy;
use App\Policies\EventPolicy;
use App\Policies\MerchandisePolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use PDO;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Singleton so the per-request memo in MediaImageService guarantees a
        // title is only ever looked up once while rendering a page.
        $this->app->singleton(\App\Services\MediaImageService::class);
    }

    public function boot(): void
    {
        RateLimiter::for('chat-messages', fn (Request $request) => Limit::perHour(20)->by(
            (string) ($request->user()?->id ?? $request->ip())
        ));
        \Illuminate\Support\Facades\Blade::directive('role', function ($expression) {
            return "<?php if(auth()->check() && (auth()->user()->is_admin || auth()->user()->role === {$expression})): ?>";
        });
        \Illuminate\Support\Facades\Blade::directive('endrole', fn () => '<?php endif; ?>');
        Gate::policy(Content::class, ContentPolicy::class);
        Gate::policy(Article::class, ArticlePolicy::class);
        Gate::policy(Bookmark::class, BookmarkPolicy::class);
        Gate::policy(ContentNote::class, ContentNotePolicy::class);
        Gate::policy(Merchandise::class, MerchandisePolicy::class);
        Gate::policy(Event::class, EventPolicy::class);

        $this->registerSqliteHaversineFunction();
    }

    /**
     * SQLite builds do not expose trigonometric functions by default. Register
     * the same Haversine calculation used by the MySQL query for test runs.
     */
    private function registerSqliteHaversineFunction(): void
    {
        if (config('database.default') !== 'sqlite') {
            return;
        }

        $pdo = DB::connection()->getPdo();

        if (! method_exists($pdo, 'sqliteCreateFunction')) {
            return;
        }

        $pdo->sqliteCreateFunction(
            'haversine_distance',
            static function ($lat1, $lng1, $lat2, $lng2): float {
                $earthRadiusKm = 6371.0;
                $lat1 = deg2rad((float) $lat1);
                $lat2 = deg2rad((float) $lat2);
                $deltaLat = $lat2 - $lat1;
                $deltaLng = deg2rad((float) $lng2 - (float) $lng1);

                $haversine = sin($deltaLat / 2) ** 2
                    + cos($lat1) * cos($lat2) * sin($deltaLng / 2) ** 2;

                return $earthRadiusKm * 2 * asin(min(1.0, sqrt(max(0.0, $haversine))));
            },
            4,
            defined('PDO::SQLITE_DETERMINISTIC') ? PDO::SQLITE_DETERMINISTIC : 0
        );
    }
}
