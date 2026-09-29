<?php

use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CharacterController as AdminCharacterController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\MerchandiseController as AdminMerchandiseController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ContentNoteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FandomProfileController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\MyListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TimelineEventController;
use App\Http\Controllers\WatchProgressController;
use Illuminate\Support\Facades\Route;

// ── Public routes ─────────────────────────────────────────────────────────────
Route::get('/', HomeController::class)->name('home');
Route::get('/explore', ExploreController::class)->name('explore');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::view('/about', 'about.index')->name('about');
Route::get('/categories/{category}', fn (string $category) => redirect()->route('categories.show', $category, 301))
    ->name('categories.legacy');
Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::view('/privacy-policy', 'legal.privacy')->name('privacy-policy');
Route::view('/terms', 'legal.terms')->name('terms');
Route::get('/api/contents/search', [ExploreController::class, 'search'])->name('api.contents.search');
Route::get('/contents/{content}', [ContentController::class, 'show'])->whereNumber('content')->name('contents.show');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->whereNumber('article')->name('articles.show');

Route::get('/merchandise', [MerchandiseController::class, 'index'])->name('merchandise.index');
Route::get('/merchandise/{merchandise:slug}', [MerchandiseController::class, 'show'])
    ->where('merchandise', '^(?!create$)[a-z0-9-]+')->name('merchandise.show');

Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/{resource}/download', [ResourceController::class, 'download'])->name('resources.download');
Route::post('/resources', [ResourceController::class, 'store'])->middleware('auth')->name('resources.store');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/filter', [EventController::class, 'filter'])->name('events.filter');
Route::get('/events/nearby', [EventController::class, 'nearby'])->name('events.nearby');
Route::get('/events/{event:slug}/ics', [EventController::class, 'ics'])->name('events.ics');
Route::get('/events/{event:slug}', [EventController::class, 'show'])
    ->where('event', '^(?!create$)[a-z0-9-]+')->name('events.show');
Route::post('/events/{event:slug}/rsvp', [EventController::class, 'rsvp'])->name('events.rsvp')->middleware('auth');

// Feedback (public — guests can submit too)
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store')->middleware('throttle:5,1');
Route::match(['get', 'post'], '/feedback/status', [FeedbackController::class, 'status'])
    ->name('feedback.status')->middleware('throttle:10,1');

// FAQ keyword search (AJAX)
Route::get('/faqs/search', [FaqController::class, 'search'])->name('faqs.search')->middleware('throttle:60,1');

// Chatbot API — /chat/message is rate-limited to 20 requests/hour per user or IP
Route::get('/chat/history', [ChatController::class, 'history'])->name('chat.history');
Route::post('/chat/message', [ChatController::class, 'message'])->name('chat.message')->middleware('throttle:chat-messages');
Route::post('/chat/messages/{message}/feedback', [ChatController::class, 'feedback'])->name('chat.feedback');
Route::post('/chat/clear', [ChatController::class, 'clear'])->name('chat.clear');

// Analytics beacon — rate-limited to 60 requests/minute per IP to prevent abuse
Route::post('/analytics/track', [AnalyticsController::class, 'track'])
    ->name('analytics.track')
    ->middleware('throttle:60,1');

// Fandom profiles (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/profiles', [FandomProfileController::class, 'index'])->name('profiles.index');
    Route::post('/profiles', [FandomProfileController::class, 'store'])->name('profiles.store');
    Route::post('/profiles/{profile}/select', [FandomProfileController::class, 'select'])->name('profiles.select');
    Route::post('/profiles/{profile}/switch', [FandomProfileController::class, 'select'])->name('profiles.switch');
    Route::patch('/profiles/{profile}', [FandomProfileController::class, 'update'])->name('profiles.update');
    Route::delete('/profiles/{profile}', [FandomProfileController::class, 'destroy'])->name('profiles.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/my-messages', [FeedbackController::class, 'mine'])->name('feedback.mine');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'destroyAvatar'])->name('profile.avatar.destroy');
    Route::put('/profile/password', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('contents', ContentController::class)->except(['show']);

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/{content}/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

    Route::post('/ratings/{content}', [RatingController::class, 'store'])->name('ratings.store');

    Route::post('/notes/{content}', [ContentNoteController::class, 'upsert'])->name('notes.upsert');
    Route::delete('/notes/{content}', [ContentNoteController::class, 'destroy'])->name('notes.destroy');

    // My List toggle (AJAX, profile-scoped)
    Route::post('/my-list/{content}/toggle', [MyListController::class, 'toggle'])->name('mylist.toggle');

    // Watch progress update (AJAX, profile-scoped)
    Route::post('/watch-progress/{content}', [WatchProgressController::class, 'update'])->name('watch-progress.update');

    Route::post('/contents/{content}/characters', [CharacterController::class, 'store'])->name('characters.store');
    Route::delete('/contents/{content}/characters/{character}', [CharacterController::class, 'destroy'])->name('characters.destroy');

    Route::post('/contents/{content}/timeline', [TimelineEventController::class, 'store'])->name('timeline.store');
    Route::delete('/contents/{content}/timeline/{timelineEvent}', [TimelineEventController::class, 'destroy'])->name('timeline.destroy');

    Route::resource('articles', ArticleController::class)->except(['show']);

    Route::resource('merchandise', MerchandiseController::class)->except(['index', 'show'])->parameters(['merchandise' => 'merchandise:slug']);
    Route::delete('/merchandise/{merchandise:slug}/images/{image}', [MerchandiseController::class, 'destroyImage'])->name('merchandise.images.destroy');

    Route::resource('events', EventController::class)->except(['index', 'show'])->parameters(['events' => 'event:slug']);
});

// ── Admin routes ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('profile', [AdminProfileController::class, 'edit'])->name('profile.index');
    Route::patch('profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('resources', [\App\Http\Controllers\Admin\ResourceController::class, 'index'])->name('resources.index');
    Route::post('resources/{resource}/moderate', [\App\Http\Controllers\Admin\ResourceController::class, 'moderate'])->name('resources.moderate');
    Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('reviews/{rating}/moderate', [\App\Http\Controllers\Admin\ReviewController::class, 'moderate'])->name('reviews.moderate');

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard.index');

    // Categories (full CRUD)
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Content
    Route::post('contents/{id}/restore', [AdminContentController::class, 'restore'])->name('contents.restore');
    Route::patch('contents/{content}/moderate', [AdminContentController::class, 'moderate'])->name('contents.moderate');
    Route::resource('contents', AdminContentController::class)->except(['show']);

    // Articles
    Route::post('articles/{id}/restore', [AdminArticleController::class, 'restore'])->name('articles.restore');
    Route::resource('articles', AdminArticleController::class)->only(['index', 'edit', 'update', 'destroy']);

    // Characters
    Route::resource('characters', AdminCharacterController::class)->except(['show']);

    // Merchandise
    Route::post('merchandise/{id}/restore', [AdminMerchandiseController::class, 'restore'])->name('merchandise.restore');
    Route::patch('merchandise/{merchandise}/moderate', [AdminMerchandiseController::class, 'moderate'])->name('merchandise.moderate');
    Route::resource('merchandise', AdminMerchandiseController::class)->only(['index', 'edit', 'update', 'destroy']);

    // Events
    Route::post('events/{id}/restore', [AdminEventController::class, 'restore'])->name('events.restore');
    Route::resource('events', AdminEventController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    // Users
    Route::post('users/{id}/restore', [AdminUserController::class, 'restore'])->name('users.restore');
    Route::post('users/{user}/promote', [AdminUserController::class, 'promote'])->name('users.promote');
    Route::post('users/{user}/demote',  [AdminUserController::class, 'demote'])->name('users.demote');
    Route::post('users/{user}/ban',     [AdminUserController::class, 'ban'])->name('users.ban');
    Route::post('users/{user}/unban',   [AdminUserController::class, 'unban'])->name('users.unban');
    Route::resource('users', AdminUserController::class)->only(['index', 'show', 'destroy']);

    // Keep this fixed path before /feedback/{feedback} so it is not treated as an ID.
    Route::get('feedback/analytics', [AdminAnalyticsController::class, 'feedbackAnalytics'])->name('feedback.analytics');

    // Feedback
    Route::resource('feedback', AdminFeedbackController::class)->only(['index', 'show', 'update', 'destroy']);

    // FAQs
    Route::resource('faqs', AdminFaqController::class)->except(['show']);

    // Analytics
    Route::get('analytics',          [AdminAnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('analytics/data',     [AdminAnalyticsController::class, 'data'])->name('analytics.data');
    Route::get('analytics/export',   [AdminAnalyticsController::class, 'export'])->name('analytics.export');
    Route::get('chatbot/analytics',  [AdminAnalyticsController::class, 'chatbotAnalytics'])->name('chatbot.analytics');
    // Inline feedback status update (AJAX)
    Route::patch('feedback/{feedback}/status', [AdminFeedbackController::class, 'update'])->name('feedback.status.update');

    // Settings
    Route::get('settings',  [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::put('settings',  [AdminSettingsController::class, 'update'])->name('settings.update');

    // Audit / Activity Log
    Route::get('activity-log', [AdminActivityLogController::class, 'index'])->name('activity-log.index');
});

require __DIR__.'/auth.php';
