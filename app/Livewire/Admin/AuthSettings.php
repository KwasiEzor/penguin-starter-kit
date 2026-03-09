<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Livewire\Concerns\HasToast;
use App\Services\AuthSettingsService;
use Illuminate\Support\Facades\Crypt;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
final class AuthSettings extends Component
{
    use HasToast;

    // Registration
    public bool $registration_enabled = true;

    public bool $email_verification_required = false;

    public string $domain_whitelist = '';

    // Social Auth - Google
    public bool $social_google_enabled = false;

    public string $social_google_client_id = '';

    public string $social_google_client_secret = '';

    public string $social_google_redirect = '';

    public bool $hasGoogleSecret = false;

    // Social Auth - GitHub
    public bool $social_github_enabled = false;

    public string $social_github_client_id = '';

    public string $social_github_client_secret = '';

    public string $social_github_redirect = '';

    public bool $hasGithubSecret = false;

    // Social Auth - Facebook
    public bool $social_facebook_enabled = false;

    public string $social_facebook_client_id = '';

    public string $social_facebook_client_secret = '';

    public string $social_facebook_redirect = '';

    public bool $hasFacebookSecret = false;

    // Security
    public bool $two_factor_enabled = false;

    public bool $two_factor_mandatory_for_admins = false;

    public int $password_min_length = 8;

    public bool $password_mixed_case = false;

    public bool $password_symbols = false;

    public bool $password_numbers = false;

    // Passwordless
    public bool $magic_links_enabled = false;

    public bool $otp_enabled = false;

    // Session
    public int $session_lifetime = 120;

    public bool $multi_device_logout_enabled = true;

    public function mount(AuthSettingsService $authSettingsService): void
    {
        $settings = $authSettingsService->getAll();

        foreach ($settings as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        $this->updateSecretFlags($settings);
    }

    private function updateSecretFlags(array $settings): void
    {
        $this->hasGoogleSecret = ! empty($settings['social_google_client_secret']);
        $this->hasGithubSecret = ! empty($settings['social_github_client_secret']);
        $this->hasFacebookSecret = ! empty($settings['social_facebook_client_secret']);

        // Clear secret values from component state to avoid exposing them in the UI
        $this->social_google_client_secret = '';
        $this->social_github_client_secret = '';
        $this->social_facebook_client_secret = '';
    }

    public function save(AuthSettingsService $authSettingsService): void
    {
        $this->validate([
            'registration_enabled' => 'boolean',
            'email_verification_required' => 'boolean',
            'domain_whitelist' => 'nullable|string',
            'social_google_enabled' => 'boolean',
            'social_google_client_id' => 'required_if:social_google_enabled,true|nullable|string',
            'social_google_client_secret' => 'nullable|string',
            'social_google_redirect' => 'required_if:social_google_enabled,true|nullable|string',
            'social_github_enabled' => 'boolean',
            'social_github_client_id' => 'required_if:social_github_enabled,true|nullable|string',
            'social_github_client_secret' => 'nullable|string',
            'social_github_redirect' => 'required_if:social_github_enabled,true|nullable|string',
            'social_facebook_enabled' => 'boolean',
            'social_facebook_client_id' => 'required_if:social_facebook_enabled,true|nullable|string',
            'social_facebook_client_secret' => 'nullable|string',
            'social_facebook_redirect' => 'required_if:social_facebook_enabled,true|nullable|string',
            'two_factor_enabled' => 'boolean',
            'two_factor_mandatory_for_admins' => 'boolean',
            'password_min_length' => 'required|integer|min:4|max:100',
            'password_mixed_case' => 'boolean',
            'password_symbols' => 'boolean',
            'password_numbers' => 'boolean',
            'magic_links_enabled' => 'boolean',
            'otp_enabled' => 'boolean',
            'session_lifetime' => 'required|integer|min:1',
            'multi_device_logout_enabled' => 'boolean',
        ]);

        $settingsToSave = [
            'registration_enabled' => $this->registration_enabled,
            'email_verification_required' => $this->email_verification_required,
            'domain_whitelist' => $this->domain_whitelist,
            'social_google_enabled' => $this->social_google_enabled,
            'social_google_client_id' => $this->social_google_client_id,
            'social_google_redirect' => $this->social_google_redirect,
            'social_github_enabled' => $this->social_github_enabled,
            'social_github_client_id' => $this->social_github_client_id,
            'social_github_redirect' => $this->social_github_redirect,
            'social_facebook_enabled' => $this->social_facebook_enabled,
            'social_facebook_client_id' => $this->social_facebook_client_id,
            'social_facebook_redirect' => $this->social_facebook_redirect,
            'two_factor_enabled' => $this->two_factor_enabled,
            'two_factor_mandatory_for_admins' => $this->two_factor_mandatory_for_admins,
            'password_min_length' => $this->password_min_length,
            'password_mixed_case' => $this->password_mixed_case,
            'password_symbols' => $this->password_symbols,
            'password_numbers' => $this->password_numbers,
            'magic_links_enabled' => $this->magic_links_enabled,
            'otp_enabled' => $this->otp_enabled,
            'session_lifetime' => $this->session_lifetime,
            'multi_device_logout_enabled' => $this->multi_device_logout_enabled,
        ];

        if (! empty($this->social_google_client_secret)) {
            $settingsToSave['social_google_client_secret'] = Crypt::encryptString($this->social_google_client_secret);
        }

        if (! empty($this->social_github_client_secret)) {
            $settingsToSave['social_github_client_secret'] = Crypt::encryptString($this->social_github_client_secret);
        }

        if (! empty($this->social_facebook_client_secret)) {
            $settingsToSave['social_facebook_client_secret'] = Crypt::encryptString($this->social_facebook_client_secret);
        }

        $authSettingsService->save($settingsToSave);

        $this->updateSecretFlags($authSettingsService->getAll());

        $this->toastSuccess('Authentication settings saved successfully.');
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('livewire.admin.auth-settings');
    }
}
