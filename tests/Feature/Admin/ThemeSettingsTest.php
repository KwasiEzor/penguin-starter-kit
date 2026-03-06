<?php

/**
 * Tests for the admin theme customization feature.
 *
 * Covers access control, saving/loading theme overrides, preset application,
 * reset to default, CSS generation, font family changes, and validation.
 */

use App\Livewire\Admin\ThemeSettings;
use App\Models\Setting;
use App\Models\User;
use App\Services\ThemeService;
use Livewire\Livewire;

it('allows admin to access theme page', function (): void {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.theme'))
        ->assertOk()
        ->assertSee('Theme Customization');
});

it('forbids non-admin from accessing theme page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('admin.theme'))
        ->assertForbidden();
});

it('redirects guest to login', function (): void {
    $this->get(route('admin.theme'))
        ->assertRedirect(route('login'));
});

it('saves theme and stores correct JSON in settings table', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(ThemeSettings::class)
        ->set('lightPrimary', '#0369a1')
        ->set('darkPrimary', '#38bdf8')
        ->set('semanticInfo', '#06b6d4')
        ->set('radius', '0.75rem')
        ->set('speed', '0.25s')
        ->set('fontFamily', 'Inter')
        ->set('preset', 'ocean')
        ->call('saveTheme')
        ->assertHasNoErrors();

    \Illuminate\Support\Facades\Cache::forget('setting.theme.overrides');
    \Illuminate\Support\Facades\Cache::forget('setting.theme.preset');
    \Illuminate\Support\Facades\Cache::forget('setting.theme.font_family');

    $overrides = json_decode(Setting::get('theme.overrides'), true);
    expect($overrides['light']['primary'])->toBe('#0369a1');
    expect($overrides['dark']['primary'])->toBe('#38bdf8');
    expect($overrides['semantic']['info'])->toBe('#06b6d4');
    expect($overrides['radius'])->toBe('0.75rem');
    expect($overrides['transition-duration'])->toBe('0.25s');
    expect(Setting::get('theme.preset'))->toBe('ocean');
    expect(Setting::get('theme.font_family'))->toBe('Inter');
});

it('applies a preset and populates properties', function (): void {
    $admin = User::factory()->admin()->create();

    $component = Livewire::actingAs($admin)
        ->test(ThemeSettings::class)
        ->call('applyPreset', 'ocean');

    $component->assertSet('preset', 'ocean');
    $component->assertSet('lightPrimary', '#0369a1');
    $component->assertSet('darkPrimary', '#38bdf8');
    $component->assertSet('fontFamily', 'Inter');
    $component->assertSet('radius', '0.75rem');
});

it('resets to default and saves', function (): void {
    $admin = User::factory()->admin()->create();

    // First save a non-default theme
    Livewire::actingAs($admin)
        ->test(ThemeSettings::class)
        ->call('applyPreset', 'ocean')
        ->call('saveTheme');

    \Illuminate\Support\Facades\Cache::forget('setting.theme.overrides');
    \Illuminate\Support\Facades\Cache::forget('setting.theme.preset');
    \Illuminate\Support\Facades\Cache::forget('setting.theme.font_family');

    // Now reset
    Livewire::actingAs($admin)
        ->test(ThemeSettings::class)
        ->call('resetToDefault');

    \Illuminate\Support\Facades\Cache::forget('setting.theme.overrides');
    \Illuminate\Support\Facades\Cache::forget('setting.theme.preset');
    \Illuminate\Support\Facades\Cache::forget('setting.theme.font_family');

    expect(Setting::get('theme.preset'))->toBe('default');
    expect(Setting::get('theme.font_family'))->toBe('Instrument Sans');
});

it('generates correct CSS root overrides', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(ThemeSettings::class)
        ->set('lightPrimary', '#0369a1')
        ->set('fontFamily', 'Inter')
        ->call('saveTheme');

    \Illuminate\Support\Facades\Cache::forget('setting.theme.overrides');
    \Illuminate\Support\Facades\Cache::forget('setting.theme.font_family');

    $themeService = new ThemeService();
    $css = $themeService->generateCss();

    expect($css)->toContain(':root {');
    expect($css)->toContain('--color-primary: #0369a1;');
    expect($css)->toContain("--font-sans: 'Inter'");
});

it('generates empty CSS when no overrides exist', function (): void {
    $themeService = new ThemeService();
    $css = $themeService->generateCss();

    expect($css)->toBe('');
});

it('changes font family correctly', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(ThemeSettings::class)
        ->set('fontFamily', 'DM Sans')
        ->call('saveTheme')
        ->assertHasNoErrors();

    \Illuminate\Support\Facades\Cache::forget('setting.theme.font_family');

    $themeService = new ThemeService();
    expect($themeService->getFontFamily())->toBe('DM Sans');
});

it('rejects invalid hex color values', function (): void {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(ThemeSettings::class)
        ->set('lightPrimary', 'not-a-color')
        ->call('saveTheme')
        ->assertHasErrors('lightPrimary');
});

it('loads saved theme on mount', function (): void {
    $admin = User::factory()->admin()->create();

    // Save a theme first
    Livewire::actingAs($admin)
        ->test(ThemeSettings::class)
        ->call('applyPreset', 'forest')
        ->call('saveTheme');

    \Illuminate\Support\Facades\Cache::forget('setting.theme.overrides');
    \Illuminate\Support\Facades\Cache::forget('setting.theme.preset');
    \Illuminate\Support\Facades\Cache::forget('setting.theme.font_family');

    // Mount a fresh component and verify values loaded
    $component = Livewire::actingAs($admin)
        ->test(ThemeSettings::class);

    $component->assertSet('preset', 'forest');
    $component->assertSet('lightPrimary', '#15803d');
    $component->assertSet('fontFamily', 'DM Sans');
});
