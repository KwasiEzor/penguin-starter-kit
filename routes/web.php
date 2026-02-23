<?php

use App\Actions\Auth\Logout;
use App\Livewire\Admin;
use App\Livewire\AiAgents;
use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Billing;
use App\Livewire\Blog;
use App\Livewire\CheckoutCancel;
use App\Livewire\CheckoutSuccess;
use App\Livewire\Dashboard;
use App\Livewire\Posts;
use App\Livewire\Pricing;
use App\Livewire\Settings;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Spatie\MarkdownResponse\Middleware\ProvideMarkdownResponse;

Route::middleware(ProvideMarkdownResponse::class)->group(function () {

    Route::get('/', fn(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View => view('welcome'))->name('home');
    Route::get('/blog/{slug}', Blog\Show::class)->name('blog.show');

    // Guest-only auth routes
    Route::middleware('guest')->group(function (): void {
        Route::get('/login', Login::class)->name('login');
        Route::get('/register', Register::class)->name('register');
        Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
        Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
    });

    // Authenticated routes
    Route::middleware('auth')->group(function (): void {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/posts', Posts\Index::class)->name('posts.index');
        Route::get('/posts/create', Posts\Create::class)->name('posts.create');
        Route::get('/posts/{post}/edit', Posts\Edit::class)->name('posts.edit');
        Route::get('/agents', AiAgents\Index::class)->name('agents.index');
        Route::get('/agents/create', AiAgents\Create::class)->name('agents.create');
        Route::get('/agents/{aiAgent}/edit', AiAgents\Edit::class)->name('agents.edit');
        Route::get('/agents/{aiAgent}', AiAgents\Show::class)->name('agents.show');
        Route::get('/settings', Settings::class)->name('settings');

        // Admin routes
        Route::middleware('admin')->prefix('admin')->name('admin.')->group(function (): void {
            Route::get('/dashboard', Admin\Dashboard::class)->name('dashboard');
            Route::get('/users', Admin\Users\Index::class)->name('users.index');
            Route::get('/users/create', Admin\Users\Create::class)->name('users.create');
            Route::get('/users/{user}/edit', Admin\Users\Edit::class)->name('users.edit');
            Route::get('/roles', Admin\Roles\Index::class)->name('roles.index');
            Route::get('/roles/create', Admin\Roles\Create::class)->name('roles.create');
            Route::get('/roles/{role}/edit', Admin\Roles\Edit::class)->name('roles.edit');
            Route::get('/payments', Admin\Payments\Settings::class)->name('payments');
            Route::get('/categories', Admin\Categories\Index::class)->name('categories.index');
            Route::get('/ai-settings', Admin\AiSettings::class)->name('ai-settings');
        });

        // Payment routes (only when payments are enabled)
        Route::middleware('payments')->group(function (): void {
            Route::get('/pricing', Pricing::class)->name('pricing');
            Route::get('/billing', Billing::class)->name('billing');
            Route::get('/checkout/success', CheckoutSuccess::class)->name('checkout.success');
            Route::get('/checkout/cancel', CheckoutCancel::class)->name('checkout.cancel');
        });
        Route::get('/verify-email', VerifyEmail::class)->name('verification.notice');
        Route::get('/confirm-password', ConfirmPassword::class)->name('password.confirm');
        Route::post('/logout', Logout::class)->name('logout');
    });

    // Signed email verification
    Route::middleware(['auth', 'signed'])->group(function (): void {
        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();

            return redirect()->intended(route('dashboard') . '?verified=1');
        })->name('verification.verify');
    });
});
