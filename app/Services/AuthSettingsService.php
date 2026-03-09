<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;

final class AuthSettingsService
{
    /**
     * Get all auth settings.
     *
     * @return array<string, mixed>
     */
    public function getAll(): array
    {
        return [
            // Registration
            'registration_enabled' => (bool) Setting::get('auth.registration_enabled', true),
            'email_verification_required' => (bool) Setting::get('auth.email_verification_required', false),
            'domain_whitelist' => Setting::get('auth.domain_whitelist', ''),

            // Social Auth
            'social_google_enabled' => (bool) Setting::get('auth.social_google_enabled', false),
            'social_google_client_id' => Setting::get('auth.social_google_client_id', ''),
            'social_google_client_secret' => $this->getDecrypted('auth.social_google_client_secret'),
            'social_google_redirect' => Setting::get('auth.social_google_redirect', config('app.url').'/auth/google/callback'),

            'social_github_enabled' => (bool) Setting::get('auth.social_github_enabled', false),
            'social_github_client_id' => Setting::get('auth.social_github_client_id', ''),
            'social_github_client_secret' => $this->getDecrypted('auth.social_github_client_secret'),
            'social_github_redirect' => Setting::get('auth.social_github_redirect', config('app.url').'/auth/github/callback'),

            'social_facebook_enabled' => (bool) Setting::get('auth.social_facebook_enabled', false),
            'social_facebook_client_id' => Setting::get('auth.social_facebook_client_id', ''),
            'social_facebook_client_secret' => $this->getDecrypted('auth.social_facebook_client_secret'),
            'social_facebook_redirect' => Setting::get('auth.social_facebook_redirect', config('app.url').'/auth/facebook/callback'),

            // Security
            'two_factor_enabled' => (bool) Setting::get('auth.two_factor_enabled', false),
            'two_factor_mandatory_for_admins' => (bool) Setting::get('auth.two_factor_mandatory_for_admins', false),
            'password_min_length' => (int) Setting::get('auth.password_min_length', 8),
            'password_mixed_case' => (bool) Setting::get('auth.password_mixed_case', false),
            'password_symbols' => (bool) Setting::get('auth.password_symbols', false),
            'password_numbers' => (bool) Setting::get('auth.password_numbers', false),

            // Passwordless
            'magic_links_enabled' => (bool) Setting::get('auth.magic_links_enabled', false),
            'otp_enabled' => (bool) Setting::get('auth.otp_enabled', false),

            // Session
            'session_lifetime' => (int) Setting::get('auth.session_lifetime', 120),
            'multi_device_logout_enabled' => (bool) Setting::get('auth.multi_device_logout_enabled', true),
        ];
    }

    private function getDecrypted(string $key): string
    {
        $value = Setting::get($key, '');

        if (empty($value)) {
            return '';
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception) {
            return '';
        }
    }

    /**
     * Save multiple auth settings at once.
     *
     * @param  array<string, mixed>  $settings
     */
    public function save(array $settings): void
    {
        foreach ($settings as $key => $value) {
            Setting::set('auth.'.$key, $value, 'auth');
        }
    }

    /**
     * Check if registration is enabled.
     */
    public function isRegistrationEnabled(): bool
    {
        return (bool) Setting::get('auth.registration_enabled', true);
    }

    /**
     * Check if social login is enabled for a provider.
     */
    public function isSocialEnabled(string $provider): bool
    {
        return (bool) Setting::get("auth.social_{$provider}_enabled", false);
    }
}
