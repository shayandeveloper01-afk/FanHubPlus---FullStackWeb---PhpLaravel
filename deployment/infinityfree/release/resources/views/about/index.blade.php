<x-app-layout>
    <section class="fh-category-page max-w-5xl">
        <x-breadcrumb :crumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'About']]" />
        <header class="fh-category-page__intro">
            <span class="fh-category-page__eyebrow">About FanHub Plus</span>
            <h1>A home for every fandom.</h1>
            <p>FanHub Plus brings entertainment discovery and fan community tools together in one place.</p>
        </header>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <article class="rounded-2xl border border-white/10 bg-white/[.03] p-6 sm:p-7">
                <span class="mb-4 grid h-11 w-11 place-items-center rounded-xl border border-violet-300/20 bg-violet-500/10 text-violet-200" aria-hidden="true">✦</span>
                <h2 class="text-lg font-bold text-white">Discover what you love</h2>
                <p class="mt-2 text-sm leading-6 text-gray-400">Explore anime, comics, cosplay, gaming, manga, movies, and TV series through the content shared on FanHub Plus.</p>
            </article>
            <article class="rounded-2xl border border-white/10 bg-white/[.03] p-6 sm:p-7">
                <span class="mb-4 grid h-11 w-11 place-items-center rounded-xl border border-fuchsia-300/20 bg-fuchsia-500/10 text-fuchsia-200" aria-hidden="true">⌁</span>
                <h2 class="text-lg font-bold text-white">Make it your own</h2>
                <p class="mt-2 text-sm leading-6 text-gray-400">Save titles to your bookmarks, rate content, follow events, and browse fan merchandise using the tools already available on the platform.</p>
            </article>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('explore') }}" class="fh-nav__btn fh-nav__btn--primary">Explore FanHub Plus</a>
            <a href="{{ route('feedback.create') }}" class="fh-nav__btn fh-nav__btn--ghost border border-white/10">Contact the team</a>
        </div>
    </section>
</x-app-layout>
