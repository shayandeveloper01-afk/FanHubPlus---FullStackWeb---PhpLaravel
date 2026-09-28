<x-app-layout>
    <section class="fh-category-page max-w-4xl">
        <x-breadcrumb :crumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'FAQ']]" />
        <div class="fh-category-page__intro">
            <span class="fh-category-page__eyebrow">FanHub Plus help</span>
            <h1>Frequently asked questions</h1>
            <p>Quick answers from the FanHub Plus community team.</p>
        </div>
        <div class="space-y-3">
            @forelse ($faqs as $faq)
                <details class="rounded-xl border border-white/10 bg-white/[.03] p-4 open:border-violet-400/40 open:bg-violet-500/[.05]">
                    <summary class="cursor-pointer font-semibold text-gray-100 marker:text-violet-300">{{ $faq->question }}</summary>
                    <p class="mt-3 text-sm leading-6 text-gray-400">{{ $faq->answer }}</p>
                </details>
            @empty
                <x-fh-empty-state title="No FAQs published yet" desc="Please use the feedback form if you need help." />
                <a href="{{ route('feedback.create') }}" class="fh-nav__btn fh-nav__btn--primary">Contact FanHub Plus</a>
            @endforelse
        </div>
    </section>
</x-app-layout>
