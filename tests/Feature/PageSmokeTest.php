<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Models\Content;
use App\Models\Event;
use App\Models\Merchandise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_render(): void
    {
        foreach ([
            '/', '/explore', '/categories', '/resources', '/events',
            '/events/filter', '/feedback', '/feedback/status',
            '/login', '/register', '/forgot-password',
        ] as $path) {
            $response = $this->get($path);
            $this->assertSame(200, $response->status(), "{$path} returned {$response->status()}");
        }

        $this->get('/')->assertSee('aria-label="Open notifications"', false)
            ->assertSee('all caught up')
            ->assertSee('aria-label="FanHub+"', false);
        $this->getJson('/events/nearby?lat=0&lng=0')->assertOk();
    }

    public function test_category_index_and_requested_category_pages_render_database_content(): void
    {
        $user = User::factory()->create();
        $names = [
            'anime' => 'Anime',
            'comics' => 'Comics',
            'cosplay' => 'Cosplay',
            'gaming' => 'Gaming',
            'manga' => 'Manga',
            'movies' => 'Movies',
            'tv-series' => 'TV Series',
        ];

        foreach ($names as $slug => $name) {
            Category::create(['name' => $name, 'slug' => $slug, 'status' => 'active']);
        }

        $anime = Category::where('slug', 'anime')->firstOrFail();
        $content = Content::create([
            'user_id' => $user->id,
            'category_id' => $anime->id,
            'title' => 'Database backed Anime entry',
            'body' => 'A published category test entry.',
            'status' => 'published',
        ]);

        $this->get('/categories')->assertOk()->assertSee('TV Series');

        foreach ($names as $slug => $name) {
            $response = $this->get('/category/' . $slug)->assertOk()->assertSee($name);
            if ($slug === 'anime') {
                $response->assertSee($content->title);
            }
        }
    }

    public function test_authenticated_user_pages_render(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Anime', 'slug' => 'anime', 'status' => 'active']);
        $content = Content::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Smoke Test Content',
            'body' => 'A published detail page.',
            'status' => 'published',
        ]);
        $article = Article::create([
            'user_id' => $user->id,
            'title' => 'Smoke Test Article',
            'body' => 'A published article page.',
            'status' => 'published',
        ]);
        $event = Event::create([
            'user_id' => $user->id,
            'title' => 'Smoke Test Event',
            'venue_name' => 'FanHub Hall',
            'city' => 'Lahore',
            'start_datetime' => now()->addWeek(),
        ]);
        $merchandise = Merchandise::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Smoke Test Merchandise',
            'price' => 12.50,
            'status' => 'active',
        ]);

        $this->actingAs($user);
        $this->get('/dashboard')->assertSee('aria-label="Open notifications"', false);

        foreach ([
            '/dashboard', '/profile', '/profiles', '/articles', '/articles/create',
            '/contents', '/contents/create', '/bookmarks', '/merchandise',
            '/merchandise/create', '/events/create',
        ] as $path) {
            $response = $this->get($path);
            $this->assertSame(200, $response->status(), "{$path} returned {$response->status()}");
        }

        $this->get(route('contents.show', $content))->assertOk();
        $this->get(route('contents.edit', $content))->assertOk();
        $this->get(route('articles.show', $article))->assertOk();
        $this->get(route('articles.edit', $article))->assertOk();
        $this->get(route('events.show', $event))->assertOk();
        $this->get(route('events.edit', $event))->assertOk();
        $this->get(route('merchandise.show', $merchandise))->assertOk();
        $this->get(route('merchandise.edit', $merchandise))->assertOk();
    }

    public function test_admin_pages_render_for_role_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $owner = User::factory()->create();
        $category = Category::create(['name' => 'Admin Smoke', 'slug' => 'admin-smoke', 'status' => 'active']);
        $content = Content::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'title' => 'Admin Smoke Content',
            'body' => 'Admin edit page test.',
            'status' => 'published',
        ]);
        $article = Article::create([
            'user_id' => $owner->id,
            'title' => 'Admin Smoke Article',
            'body' => 'Admin edit page test.',
            'status' => 'published',
        ]);
        $event = Event::create([
            'user_id' => $owner->id,
            'title' => 'Admin Smoke Event',
            'venue_name' => 'FanHub Hall',
            'city' => 'Lahore',
            'start_datetime' => now()->addWeek(),
        ]);
        $merchandise = Merchandise::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'title' => 'Admin Smoke Merch',
            'price' => 10,
            'status' => 'active',
        ]);
        $this->actingAs($admin);
        $this->get('/profile')->assertOk();

        foreach ([
            '/admin', '/admin/profile', '/admin/activity-log', '/admin/analytics', '/admin/analytics/data',
            '/admin/analytics/export', '/admin/articles', '/admin/categories',
            '/admin/categories/create', '/admin/characters', '/admin/characters/create',
            '/admin/chatbot/analytics', '/admin/contents', '/admin/contents/create',
            '/admin/events', '/admin/faqs', '/admin/faqs/create', '/admin/feedback',
            '/admin/feedback/analytics', '/admin/merchandise', '/admin/resources',
            '/admin/settings', '/admin/users',
        ] as $path) {
            $response = $this->get($path);
            $this->assertSame(200, $response->status(), "{$path} returned {$response->status()}");
        }

        $this->get(route('admin.users.show', $owner))->assertOk();
        $this->get(route('admin.categories.edit', $category))->assertOk();
        $this->get(route('admin.contents.edit', $content))->assertOk();
        $this->get(route('admin.articles.edit', $article))->assertOk();
        $this->get(route('admin.events.edit', $event))->assertOk();
        $this->get(route('admin.merchandise.edit', $merchandise))->assertOk();
    }
}
