<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Content;
use App\Models\User;
use App\Support\ImageArtwork;
use Database\Seeders\CatalogArtworkSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CatalogArtworkTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_replace_and_remove_a_content_thumbnail(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::create(['name' => 'Anime', 'slug' => 'anime', 'status' => 'active']);
        $content = Content::create([
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Artwork test entry',
            'body' => 'Test body',
            'status' => 'draft',
            'type' => 'anime',
        ]);

        $this->actingAs($admin)->post(route('admin.contents.store'), [
            'title' => 'Uploaded entry', 'category_id' => $category->id, 'type' => 'anime',
            'body' => 'Test body', 'status' => 'draft', 'thumbnail' => UploadedFile::fake()->image('first.jpg'),
        ])->assertRedirect(route('admin.contents.index'));

        $uploaded = Content::where('title', 'Uploaded entry')->firstOrFail();
        Storage::disk('public')->assertExists($uploaded->thumbnail);

        $this->actingAs($admin)->put(route('admin.contents.update', $content), [
            'title' => $content->title, 'category_id' => $category->id, 'type' => 'anime',
            'body' => 'Test body', 'status' => 'draft', 'thumbnail' => UploadedFile::fake()->image('replacement.webp'),
        ])->assertRedirect(route('admin.contents.index'));
        $content->refresh();
        Storage::disk('public')->assertExists($content->thumbnail);
        $replacementPath = $content->thumbnail;

        $this->actingAs($admin)->put(route('admin.contents.update', $content), [
            'title' => $content->title, 'category_id' => $category->id, 'type' => 'anime',
            'body' => 'Test body', 'status' => 'draft', 'remove_thumbnail' => '1',
        ])->assertRedirect(route('admin.contents.index'));
        $this->assertNull($content->fresh()->thumbnail);
        Storage::disk('public')->assertMissing($replacementPath);
    }

    public function test_missing_artwork_is_unique_and_seeded_into_the_existing_image_column(): void
    {
        Storage::fake('public');
        $first = ImageArtwork::dataUri('First title', 'Anime', 'content', 1);
        $second = ImageArtwork::dataUri('Second title', 'Gaming', 'content', 2);
        $this->assertNotSame($first, $second);

        $user = User::factory()->create();
        $category = Category::create(['name' => 'Anime', 'slug' => 'anime', 'status' => 'active']);
        $content = Content::create([
            'user_id' => $user->id, 'category_id' => $category->id,
            'title' => 'Seeded unique art', 'body' => 'Test body', 'status' => 'published', 'type' => 'anime',
        ]);

        app(CatalogArtworkSeeder::class)->run();
        $content->refresh();
        $this->assertNotEmpty($content->thumbnail);
        Storage::disk('public')->assertExists($content->thumbnail);
    }
}
