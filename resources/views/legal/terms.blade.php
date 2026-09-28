<x-app-layout>
    <section class="fh-category-page max-w-3xl">
        <x-breadcrumb :crumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Terms']]" />
        <div class="fh-category-page__intro">
            <span class="fh-category-page__eyebrow">Legal</span>
            <h1>Terms</h1>
            <p>Our terms page is being prepared. For questions, contact FanHub Plus through the feedback form.</p>
        </div>
        <a href="{{ route('feedback.create') }}" class="fh-nav__btn fh-nav__btn--primary">Contact FanHub Plus</a>
    </section>
</x-app-layout>
