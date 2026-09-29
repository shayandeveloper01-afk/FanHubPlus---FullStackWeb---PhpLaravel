<x-app-layout>
    <section class="fh-category-page">
        <x-breadcrumb :crumbs="[['label' => 'Categories', 'url' => route('categories.index')], ['label' => $category->name]]" />
        <div class="fh-category-page__intro">
            <span class="fh-category-page__eyebrow">Category</span>
            <h1>{{ $category->name }}</h1>
            <p>{{ $category->description }}</p>
        </div>
        <div class="fh-category-content-grid">
            @forelse ($contents as $content)
                <x-content-card :content="$content" />
            @empty
                <x-fh-empty-state title="No content yet" desc="Published {{ strtolower($category->name) }} content will show here." />
            @endforelse
        </div>
        {{ $contents->links() }}
    </section>
</x-app-layout>
