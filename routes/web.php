<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SystemUpdateController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UiPageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageViewController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ─── Public Frontend Routes ───────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Dynamic CMS pages
Route::get('/page/{slug}', [PageViewController::class, 'show'])->name('pages.show');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Adminator)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest-only auth routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Logout (authenticated)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protect all admin routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Adminator UI pages (sidebar menu)
        Route::get('email', fn () => app(UiPageController::class)->show('email'))->name('email');
        Route::get('compose', fn () => app(UiPageController::class)->show('compose'))->name('compose');
        Route::get('calendar', fn () => app(UiPageController::class)->show('calendar'))->name('calendar');
        Route::get('chat', fn () => app(UiPageController::class)->show('chat'))->name('chat');
        Route::get('charts', fn () => app(UiPageController::class)->show('charts'))->name('charts');
        Route::get('forms', fn () => app(UiPageController::class)->show('forms'))->name('forms');
        Route::get('ui-elements', fn () => app(UiPageController::class)->show('ui'))->name('ui');
        Route::get('buttons', fn () => app(UiPageController::class)->show('buttons'))->name('buttons');
        Route::get('basic-table', fn () => app(UiPageController::class)->show('basic-table'))->name('basic-table');
        Route::get('datatable', fn () => app(UiPageController::class)->show('datatable'))->name('datatable');
        Route::get('google-maps', fn () => app(UiPageController::class)->show('google-maps'))->name('google-maps');
        Route::get('vector-maps', fn () => app(UiPageController::class)->show('vector-maps'))->name('vector-maps');
        Route::get('blank', fn () => app(UiPageController::class)->show('blank'))->name('blank');
        Route::get('signup', fn () => app(UiPageController::class)->show('signup'))->name('signup');
        Route::get('errors/404', fn () => app(UiPageController::class)->show('404'))->name('error.404');
        Route::get('errors/500', fn () => app(UiPageController::class)->show('500'))->name('error.500');


        // Services
        Route::resource('services', AdminServiceController::class)->except('show');
        Route::patch('services/{service}/toggle', [AdminServiceController::class, 'toggle'])->name('services.toggle');

        // Projects
        Route::resource('projects', AdminProjectController::class)->except('show');
        Route::patch('projects/{project}/toggle-featured', [AdminProjectController::class, 'toggleFeatured'])->name('projects.toggle-featured');

        // Clients
        Route::resource('clients', ClientController::class)->except('show');
        Route::patch('clients/{client}/toggle', [ClientController::class, 'toggle'])->name('clients.toggle');

        // Testimonials
        Route::resource('testimonials', TestimonialController::class)->except('show');
        Route::patch('testimonials/{testimonial}/toggle', [TestimonialController::class, 'toggle'])->name('testimonials.toggle');

        // Team Members
        Route::resource('team', TeamMemberController::class)
            ->except('show')
            ->parameters(['team' => 'teamMember']);
        Route::patch('team/{teamMember}/toggle', [TeamMemberController::class, 'toggle'])->name('team.toggle');

        // Blog Posts
        Route::resource('posts', AdminPostController::class)->except('show');

        // Contact Messages
        Route::get('messages', [ContactMessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [ContactMessageController::class, 'show'])->name('messages.show');
        Route::patch('messages/{message}/mark-replied', [ContactMessageController::class, 'markReplied'])->name('messages.mark-replied');
        Route::patch('messages/{message}/mark-read', [ContactMessageController::class, 'markRead'])->name('messages.mark-read');
        Route::delete('messages/{message}', [ContactMessageController::class, 'destroy'])->name('messages.destroy');

        // Users (admin only - enforced in controller)
        Route::resource('users', UserController::class)->except('show');
        Route::patch('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');

        // Settings
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

        // System updates (admin only — enforced in controller)
        Route::get('settings/updates/status', [SystemUpdateController::class, 'status'])->name('settings.updates.status');
        Route::post('settings/updates/check', [SystemUpdateController::class, 'check'])->name('settings.updates.check');
        Route::post('settings/updates/pull', [SystemUpdateController::class, 'pull'])->name('settings.updates.pull');
        Route::post('settings/updates/maintenance', [SystemUpdateController::class, 'maintenance'])->name('settings.updates.maintenance');

        // CMS Pages
        Route::resource('pages', AdminPageController::class)->except('show');
    });
});
