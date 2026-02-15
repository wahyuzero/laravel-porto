<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\NewsletterController;

// Admin controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SkillController as AdminSkillController;
use App\Http\Controllers\Admin\ExperienceController as AdminExperienceController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\GuestBookController as AdminGuestBookController;
use App\Http\Controllers\Admin\ChangelogController as AdminChangelogController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\ImportController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

// ═══════════════════════════════════════
// PUBLIC ROUTES
// ═══════════════════════════════════════

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/tag/{tag}', [BlogController::class, 'byTag'])->name('blog.tag');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::get('/guestbook', [GuestBookController::class, 'index'])->name('guestbook.index');
Route::get('/guestbook/edit/{token}', [GuestBookController::class, 'edit'])->name('guestbook.edit');
Route::put('/guestbook/edit/{token}', [GuestBookController::class, 'update'])->name('guestbook.update');
Route::get('/changelog', [ChangelogController::class, 'index'])->name('changelog.index');
Route::get('/badges', function () {
    return view('badges');
})->name('badges');
Route::get('/theme-creator', function () {
    return view('theme-creator');
})->name('theme-creator');
Route::get('/.plan', [PlanController::class, 'show'])->name('plan');

// Rate-limited form submissions
Route::middleware('throttle:5,1')->group(function () {
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    Route::post('/guestbook', [GuestBookController::class, 'store'])->name('guestbook.store');
    Route::post('/blog/{slug}/comments', [BlogController::class, 'storeComment'])->name('blog.comment');
    Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
});

// Newsletter verify/unsubscribe (no rate limit)
Route::get('/newsletter/verify/{token}', [NewsletterController::class, 'verify'])->name('newsletter.verify');
Route::get('/newsletter/unsubscribe/{token}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
Route::get('/newsletter/archive', [NewsletterController::class, 'archive'])->name('newsletter.archive');

// Easter egg
Route::get('/inspect', function () {
    return view('inspect');
})->name('inspect');

// RSS Feed
Route::get('/feed', function () {
    $posts = \App\Models\BlogPost::published()->latest()->take(20)->get();
    $siteName = \App\Models\SiteSetting::get('site_name', 'FrugalDev');
    return response()->view('feed', compact('posts', 'siteName'))
        ->header('Content-Type', 'application/rss+xml');
})->name('feed');

// Comments RSS Feed
Route::get('/feed/comments', function () {
    $comments = \App\Models\Comment::approved()
        ->with('blogPost')
        ->latest()
        ->take(30)
        ->get();
    $siteName = \App\Models\SiteSetting::get('site_name', 'FrugalDev');
    return response()->view('feed-comments', compact('comments', 'siteName'))
        ->header('Content-Type', 'application/rss+xml');
})->name('feed.comments');

// Sitemap
Route::get('/sitemap.xml', function () {
    $data = Cache::remember('sitemap', 3600, function () {
        return [
            'projects' => \App\Models\Project::visible()->get(['slug', 'updated_at']),
            'posts' => \App\Models\BlogPost::published()->get(['slug', 'updated_at']),
        ];
    });
    return response()->view('sitemap', $data)
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// ═══════════════════════════════════════
// AUTH ROUTES (Breeze)
// ═══════════════════════════════════════

require __DIR__ . '/auth.php';

// ═══════════════════════════════════════
// ADMIN ROUTES
// ═══════════════════════════════════════

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    // Data Export
    Route::get('/export', [ExportController::class, 'index'])->name('export.index');
    Route::get('/export/download', [ExportController::class, 'download'])->name('export.download');
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('/import', [ImportController::class, 'index'])->name('import.index');
    Route::post('/import', [ImportController::class, 'process'])->name('import.process');
    Route::get('/newsletter-preview', function () {
        $posts = \App\Models\BlogPost::published()->latest('published_at')->get();
        $preview = request('post_id') ? \App\Models\BlogPost::find(request('post_id')) : null;
        return view('admin.newsletter-preview', compact('posts', 'preview'));
    })->name('newsletter-preview');

    // Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Resources
    Route::resource('projects', AdminProjectController::class);
    Route::resource('skills', AdminSkillController::class);
    Route::resource('experiences', AdminExperienceController::class);
    Route::resource('blog', AdminBlogPostController::class);
    Route::post('/blog/bulk', [AdminBlogPostController::class, 'bulk'])->name('blog.bulk');
    Route::get('/blog/{blog}/preview', [AdminBlogPostController::class, 'preview'])->name('blog.preview');
    Route::resource('testimonials', AdminTestimonialController::class);
    Route::resource('changelog', AdminChangelogController::class);

    // Comments moderation
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{comment}', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/bulk', [AdminCommentController::class, 'bulk'])->name('comments.bulk');

    // Messages
    Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('/messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

    // Settings
    Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

    // Guest book moderation
    Route::get('/guestbook', [AdminGuestBookController::class, 'index'])->name('guestbook.index');
    Route::patch('/guestbook/{guestbook}', [AdminGuestBookController::class, 'approve'])->name('guestbook.approve');
    Route::delete('/guestbook/{guestbook}', [AdminGuestBookController::class, 'destroy'])->name('guestbook.destroy');

    // Cache clear
    Route::post('/cache/clear', function () {
        Cache::flush();
        return back()->with('success', 'Cache cleared.');
    })->name('cache.clear');
});
