<x-app-layout>
    <section class="fh-resource-page">
        <h1>Fan Resources</h1>
        <p>Community made files, reviewed before publication.</p>
        @auth
            <form method="POST" action="{{ route('resources.store') }}" enctype="multipart/form-data" class="fh-resource-form">
                @csrf
                <label>Title <input name="title" required maxlength="255"></label>
                <label>Type
                    <select name="type" required>
                        @foreach (['wallpaper', 'fanart', 'fanfic', 'subtitle', 'theme', 'audio'] as $type)
                            <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </label>
                <label>Description <textarea name="description" rows="3"></textarea></label>
                <label>File <input name="file" type="file" required accept=".jpg,.jpeg,.png,.webp,.gif,.pdf,.mp3,.wav,.srt,.zip"></label>
                <label>License <input name="license" maxlength="100"></label>
                <button type="submit">Submit for review</button>
            </form>
        @endauth
        <div class="fh-resource-grid">
            @forelse ($resources as $resource)
                <article class="fh-resource-card">
                    <img src="{{ asset('images/thumbnail-placeholder.svg') }}" alt="" aria-hidden="true" class="w-full aspect-video object-cover rounded-lg">
                    <h2>{{ $resource->title }}</h2>
                    <p>{{ $resource->description }}</p>
                    <p>{{ ucfirst($resource->type) }} · {{ number_format($resource->file_size_kb) }} KB · {{ $resource->download_count }} downloads</p>
                    <a href="{{ route('resources.download', $resource) }}">Download</a>
                </article>
            @empty
                <x-fh-empty-state title="No resources yet" desc="Approved fan resources will appear here." />
            @endforelse
        </div>
        {{ $resources->links() }}
    </section>
</x-app-layout>
