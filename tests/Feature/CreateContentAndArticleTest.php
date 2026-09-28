<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\Content;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateContentAndArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_form_saves_release_date_and_media_url(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Anime', 'slug' => 'anime', 'status' => 'active']);

        $this->actingAs($user)->post(route('contents.store'), [
            'title' => 'FanHub Feature',
            'category_id' => $category->id,
            'type' => 'anime',
            'genre' => 'Adventure',
            'year' => 2026,
            'release_date' => '2026-05-12',
            'trailer_url' => 'https://example.com/trailer',
            'body' => 'A community description.',
            'status' => 'draft',
        ])->assertRedirect(route('contents.index'));

        $this->assertDatabaseHas('contents', [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'FanHub Feature',
            'trailer_url' => 'https://example.com/trailer',
        ]);
        $content = Content::where('title', 'FanHub Feature')->firstOrFail();
        $this->assertSame('2026-05-12', $content->release_date->format('Y-m-d'));
    }

    public function test_article_form_saves_category_and_rich_text_content(): void
    {
        $user = User::factory()->create();
        $category = Category::create(['name' => 'Reviews', 'slug' => 'reviews', 'status' => 'active']);

        $this->actingAs($user)->post(route('articles.store'), [
            'title' => 'A thoughtful review',
            'category_id' => $category->id,
            'excerpt' => 'A short introduction.',
            'body' => '<p>A longer review body.</p>',
            'status' => 'draft',
            'is_featured' => '1',
        ])->assertRedirect(route('articles.index'));

        $article = Article::where('title', 'A thoughtful review')->firstOrFail();
        $this->assertSame($category->id, $article->category_id);
        $this->assertSame('<p>A longer review body.</p>', $article->body);
        $this->assertTrue($article->is_featured);
    }
}
