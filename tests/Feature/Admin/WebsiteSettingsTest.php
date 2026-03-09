<?php

use App\Livewire\Admin\WebsiteSettings;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('allows admin to access website settings page', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.settings'))
        ->assertOk()
        ->assertSee('Website Settings');
});

it('forbids non-admin from accessing website settings page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.settings'))
        ->assertForbidden();
});

it('saves general settings correctly', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(WebsiteSettings::class)
        ->set('name', 'My Custom Site')
        ->set('tagline', 'My custom tagline')
        ->set('contactEmail', 'test@example.com')
        ->call('save')
        ->assertHasNoErrors();

    expect(Setting::get('site.name'))->toBe('My Custom Site');
    expect(Setting::get('site.tagline'))->toBe('My custom tagline');
    expect(Setting::get('site.contact_email'))->toBe('test@example.com');
});

it('saves branding assets correctly', function (): void {
    Storage::fake('public');
    $admin = User::factory()->admin()->create();

    $logo = UploadedFile::fake()->image('logo.png');
    $favicon = UploadedFile::fake()->image('favicon.png');

    Livewire::actingAs($admin)
        ->test(WebsiteSettings::class)
        ->set('logoLight', $logo)
        ->set('favicon', $favicon)
        ->call('save')
        ->assertHasNoErrors();

    $logoPath = Setting::get('site.logo_light');
    $faviconPath = Setting::get('site.favicon');

    expect($logoPath)->not->toBeNull();
    expect($faviconPath)->not->toBeNull();

    Storage::disk('public')->assertExists($logoPath);
    Storage::disk('public')->assertExists($faviconPath);
});

it('saves SEO settings correctly', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(WebsiteSettings::class)
        ->set('seoTitle', 'SEO Page Title')
        ->set('seoDescription', 'SEO Page Description')
        ->set('seoKeywords', 'seo, keywords, test')
        ->call('save')
        ->assertHasNoErrors();

    expect(Setting::get('site.seo_title'))->toBe('SEO Page Title');
    expect(Setting::get('site.seo_description'))->toBe('SEO Page Description');
    expect(Setting::get('site.seo_keywords'))->toBe('seo, keywords, test');
});

it('saves integrations and scripts correctly', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(WebsiteSettings::class)
        ->set('googleAnalyticsId', 'G-123456')
        ->set('customScriptsHeader', '<script>console.log("head");</script>')
        ->call('save')
        ->assertHasNoErrors();

    expect(Setting::get('site.google_analytics_id'))->toBe('G-123456');
    expect(Setting::get('site.custom_scripts_header'))->toBe('<script>console.log("head");</script>');
});
