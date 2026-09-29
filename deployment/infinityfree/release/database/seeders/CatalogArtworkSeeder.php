<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Character;
use App\Models\Content;
use App\Models\Event;
use App\Models\Merchandise;
use App\Models\Resource as FanResource;
use App\Support\ImageArtwork;
use App\Support\EventArtwork;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CatalogArtworkSeeder extends Seeder
{
    public function run(): void
    {
        $this->fill(Content::with('category')->get(), 'thumbnail', 'content', fn (Content $item) => $item->category?->name ?? $item->type ?? 'Fan content');
        $this->fill(Article::with('category')->get(), 'cover_image', 'article', fn (Article $item) => $item->category?->name ?? 'Editorial');
        $this->fill(Character::with('content.category')->get(), 'image', 'character', fn (Character $item) => $item->content?->category?->name ?? 'Character');
        $this->fillEvents(Event::withTrashed()->with('category')->get());
        $this->fill(Merchandise::with('category')->get(), 'image', 'merchandise', fn (Merchandise $item) => $item->category?->name ?? 'Merchandise');
        $this->fill(FanResource::with('content.category')->get(), 'thumbnail_path', 'resource', fn (FanResource $item) => $item->content?->category?->name ?? ucfirst($item->type));
    }

    private function fill($items, string $field, string $kind, callable $category): void
    {
        foreach ($items as $item) {
            /** @var Model $item */
            $current = trim((string) $item->getAttribute($field));
            if ($current !== '' && (filter_var($current, FILTER_VALIDATE_URL) || Storage::disk('public')->exists($current))) continue;

            $title = (string) ($item->title ?? $item->name ?? 'FanHub+');
            $categoryName = (string) $category($item);
            $path = "catalog-artwork/{$kind}/{$item->getKey()}-".Str::slug($title).'.svg';
            Storage::disk('public')->put($path, ImageArtwork::svg($title, $categoryName, $kind, $item->getKey()));
            $item->forceFill([$field => $path])->saveQuietly();
        }
    }

    private function fillEvents($events): void
    {
        foreach ($events as $event) {
            $current = trim((string) $event->cover_image);
            $generated = str_starts_with($current, 'catalog-artwork/event/');
            $validRemote = filter_var($current, FILTER_VALIDATE_URL);
            $validFile = $current !== '' && Storage::disk('public')->exists($current);
            if ($current !== '' && ! $generated && ($validRemote || $validFile)) continue;

            $path = 'catalog-artwork/event/'.$event->id.'-'.Str::slug($event->title).'.svg';
            Storage::disk('public')->put($path, EventArtwork::svg($event->title, $event->category?->name ?? 'Fan Event', $event->city, $event->id));
            if ($current !== $path) $event->forceFill(['cover_image' => $path])->saveQuietly();
        }
    }
}
