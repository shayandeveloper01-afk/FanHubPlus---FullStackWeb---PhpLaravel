<x-app-layout>
    <section class="fh-category-page">
        <x-breadcrumb :crumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Categories']]" />
        <div class="fh-category-page__intro">
            <span class="fh-category-page__eyebrow">Find your fandom</span>
            <h1>Explore categories</h1>
            <p>Browse stories and fan content from the communities you love.</p>
        </div>
        <div class="fh-category-grid">
            @foreach ($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="fh-category-card" style="--fh-category-color:{{ $category->color ?: '#8b5cf6' }}">
                    @php($representativeContent = $category->contents->first())
                    <x-media-image :src="$representativeContent?->thumbnailUrl()" :title="$representativeContent?->title ?? $category->name" :category="$category->name" kind="category" :record-key="$category->id" :alt="$category->name.' category artwork'" class="w-full h-full object-cover" />
                    <span class="fh-category-card__label">Category</span>
                    <strong>{{ $category->name }}</strong>
                    <small>{{ $category->description }}</small>
                    <span class="fh-category-card__count">{{ $category->contents_count }} {{ \Illuminate\Support\Str::plural('title', $category->contents_count) }}</span>
                </a>
            @endforeach
        </div>
    </section>
</x-app-layout>
