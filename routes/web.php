<?php

use App\Actions\Auth\Logout;
use App\Livewire\Auth\ConfirmPassword;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Admin;
use App\Livewire\Blog;
use App\Livewire\Dashboard;
use App\Livewire\Posts;
use App\Livewire\Settings;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('home');
Route::get('/blog/{slug}', Blog\Show::class)->name('blog.show');

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/posts', Posts\Index::class)->name('posts.index');
    Route::get('/posts/create', Posts\Create::class)->name('posts.create');
    Route::get('/posts/{post}/edit', Posts\Edit::class)->name('posts.edit');
    Route::get('/settings', Settings::class)->name('settings');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', Admin\Dashboard::class)->name('dashboard');
        Route::get('/users', Admin\Users\Index::class)->name('users.index');
        Route::get('/users/create', Admin\Users\Create::class)->name('users.create');
        Route::get('/users/{user}/edit', Admin\Users\Edit::class)->name('users.edit');
        Route::get('/roles', Admin\Roles\Index::class)->name('roles.index');
        Route::get('/roles/create', Admin\Roles\Create::class)->name('roles.create');
        Route::get('/roles/{role}/edit', Admin\Roles\Edit::class)->name('roles.edit');
    });
    Route::get('/verify-email', VerifyEmail::class)->name('verification.notice');
    Route::get('/confirm-password', ConfirmPassword::class)->name('password.confirm');
    Route::post('/logout', Logout::class)->name('logout');
});

// Signed email verification
Route::middleware(['auth', 'signed'])->group(function () {
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->intended(route('dashboard').'?verified=1');
    })->name('verification.verify');
});
