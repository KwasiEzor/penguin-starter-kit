<div class="flex flex-col gap-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
    <!-- Header -->
    <div class="flex flex-col gap-2">
        <x-typography.heading accent size="xl" level="1" class="font-extrabold tracking-tight">
            {{ __('Authentication Settings') }}
        </x-typography.heading>
        <x-typography.subheading size="lg" class="text-on-surface/70 dark:text-on-surface-dark/70">
            {{ __('Manage registration, social logins, security policies, and session behavior.') }}
        </x-typography.subheading>
    </div>

    <form wire:submit="save" class="space-y-8">
        <x-tabs active="general">
            <x-slot:tabs>
                <x-tab name="general">{{ __('Registration') }}</x-tab>
                <x-tab name="social">{{ __('Social Auth') }}</x-tab>
                <x-tab name="security">{{ __('Security & 2FA') }}</x-tab>
                <x-tab name="passwordless">{{ __('Passwordless') }}</x-tab>
                <x-tab name="session">{{ __('Session') }}</x-tab>
            </x-slot:tabs>

            <!-- Registration Settings -->
            <x-tab-panel name="general" class="space-y-6">
                <x-card class="p-6">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-radius border border-outline dark:border-outline-dark">
                            <div class="space-y-1">
                                <x-typography.heading size="sm" level="4">{{ __('Enable Registration') }}</x-typography.heading>
                                <p class="text-xs text-on-surface/60">{{ __('Allow new users to create accounts on your platform.') }}</p>
                            </div>
                            <x-toggle wire:model="registration_enabled" />
                        </div>

                        <div class="flex items-center justify-between p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-radius border border-outline dark:border-outline-dark">
                            <div class="space-y-1">
                                <x-typography.heading size="sm" level="4">{{ __('Require Email Verification') }}</x-typography.heading>
                                <p class="text-xs text-on-surface/60">{{ __('Users must verify their email address before they can access the application.') }}</p>
                            </div>
                            <x-toggle wire:model="email_verification_required" />
                        </div>

                        <div class="space-y-2">
                            <x-input-label for="domain_whitelist" :value="__('Domain Whitelist')" />
                            <x-input id="domain_whitelist" type="text" class="mt-1 block w-full" wire:model="domain_whitelist" placeholder="example.com, company.org" />
                            <p class="mt-1 text-xs text-on-surface/60">{{ __('Only allow registration from these domains. Separate with commas. Leave empty for all.') }}</p>
                            <x-input-error :messages="$errors->get('domain_whitelist')" class="mt-2" />
                        </div>
                    </div>
                </x-card>
            </x-tab-panel>

            <!-- Social Auth Settings -->
            <x-tab-panel name="social" class="space-y-6">
                <!-- Google -->
                <x-card class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-red-50 dark:bg-red-950/30 rounded-full">
                            <x-icons.sparkles class="size-6 text-red-600 dark:text-red-400" />
                        </div>
                        <div class="flex-1">
                            <x-typography.heading size="base" level="3">{{ __('Google Authentication') }}</x-typography.heading>
                            <p class="text-xs text-on-surface/60">{{ __('Enable users to sign in with their Google accounts.') }}</p>
                        </div>
                        <x-toggle wire:model="social_google_enabled" />
                    </div>

                    @if($social_google_enabled)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-in fade-in slide-in-from-top-2 duration-300">
                            <div class="space-y-2">
                                <x-input-label for="social_google_client_id" :value="__('Client ID')" />
                                <x-input id="social_google_client_id" type="text" class="mt-1 block w-full" wire:model="social_google_client_id" />
                                <x-input-error :messages="$errors->get('social_google_client_id')" class="mt-2" />
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <x-input-label for="social_google_client_secret" :value="__('Client Secret')" />
                                    @if($hasGoogleSecret)
                                        <x-badge variant="success" size="xs">{{ __('Configured') }}</x-badge>
                                    @endif
                                </div>
                                <x-input id="social_google_client_secret" type="password" class="mt-1 block w-full" wire:model="social_google_client_secret" />
                                <x-input-error :messages="$errors->get('social_google_client_secret')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <x-input-label for="social_google_redirect" :value="__('Redirect URI')" />
                                <x-input id="social_google_redirect" type="text" class="mt-1 block w-full bg-surface-alt/50 cursor-not-allowed" wire:model="social_google_redirect" readonly />
                                <p class="text-[10px] text-on-surface/50">{{ __('Copy this to your Google Cloud Console authorized redirect URIs.') }}</p>
                            </div>
                        </div>
                    @endif
                </x-card>

                <!-- GitHub -->
                <x-card class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-slate-900 dark:bg-slate-800 rounded-full">
                            <x-icons.sparkles class="size-6 text-white" />
                        </div>
                        <div class="flex-1">
                            <x-typography.heading size="base" level="3">{{ __('GitHub Authentication') }}</x-typography.heading>
                            <p class="text-xs text-on-surface/60">{{ __('Enable users to sign in with their GitHub accounts.') }}</p>
                        </div>
                        <x-toggle wire:model="social_github_enabled" />
                    </div>

                    @if($social_github_enabled)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-in fade-in slide-in-from-top-2 duration-300">
                            <div class="space-y-2">
                                <x-input-label for="social_github_client_id" :value="__('Client ID')" />
                                <x-input id="social_github_client_id" type="text" class="mt-1 block w-full" wire:model="social_github_client_id" />
                                <x-input-error :messages="$errors->get('social_github_client_id')" class="mt-2" />
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <x-input-label for="social_github_client_secret" :value="__('Client Secret')" />
                                    @if($hasGithubSecret)
                                        <x-badge variant="success" size="xs">{{ __('Configured') }}</x-badge>
                                    @endif
                                </div>
                                <x-input id="social_github_client_secret" type="password" class="mt-1 block w-full" wire:model="social_github_client_secret" />
                                <x-input-error :messages="$errors->get('social_github_client_secret')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <x-input-label for="social_github_redirect" :value="__('Redirect URI')" />
                                <x-input id="social_github_redirect" type="text" class="mt-1 block w-full bg-surface-alt/50 cursor-not-allowed" wire:model="social_github_redirect" readonly />
                                <p class="text-[10px] text-on-surface/50">{{ __('Copy this to your GitHub OAuth App configuration.') }}</p>
                            </div>
                        </div>
                    @endif
                </x-card>

                <!-- Facebook -->
                <x-card class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-full">
                            <x-icons.sparkles class="size-6 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div class="flex-1">
                            <x-typography.heading size="base" level="3">{{ __('Facebook Authentication') }}</x-typography.heading>
                            <p class="text-xs text-on-surface/60">{{ __('Enable users to sign in with their Facebook accounts.') }}</p>
                        </div>
                        <x-toggle wire:model="social_facebook_enabled" />
                    </div>

                    @if($social_facebook_enabled)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-in fade-in slide-in-from-top-2 duration-300">
                            <div class="space-y-2">
                                <x-input-label for="social_facebook_client_id" :value="__('App ID')" />
                                <x-input id="social_facebook_client_id" type="text" class="mt-1 block w-full" wire:model="social_facebook_client_id" />
                                <x-input-error :messages="$errors->get('social_facebook_client_id')" class="mt-2" />
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <x-input-label for="social_facebook_client_secret" :value="__('App Secret')" />
                                    @if($hasFacebookSecret)
                                        <x-badge variant="success" size="xs">{{ __('Configured') }}</x-badge>
                                    @endif
                                </div>
                                <x-input id="social_facebook_client_secret" type="password" class="mt-1 block w-full" wire:model="social_facebook_client_secret" />
                                <x-input-error :messages="$errors->get('social_facebook_client_secret')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <x-input-label for="social_facebook_redirect" :value="__('Redirect URI')" />
                                <x-input id="social_facebook_redirect" type="text" class="mt-1 block w-full bg-surface-alt/50 cursor-not-allowed" wire:model="social_facebook_redirect" readonly />
                            </div>
                        </div>
                    @endif
                </x-card>
            </x-tab-panel>

            <!-- Security Settings -->
            <x-tab-panel name="security" class="space-y-6">
                <x-card class="p-6 space-y-6">
                    <div class="flex items-center justify-between p-4 bg-primary/5 rounded-radius border border-primary/20">
                        <div class="flex gap-4">
                            <div class="p-2 bg-primary/10 rounded-lg shrink-0">
                                <x-icons.shield class="size-6 text-primary" />
                            </div>
                            <div class="space-y-1">
                                <x-typography.heading size="sm" level="4">{{ __('Two-Factor Authentication (2FA)') }}</x-typography.heading>
                                <p class="text-xs text-on-surface/60">{{ __('Add an extra layer of security to user accounts using TOTP apps (Google Authenticator, etc.).') }}</p>
                            </div>
                        </div>
                        <x-toggle wire:model="two_factor_enabled" />
                    </div>

                    @if($two_factor_enabled)
                        <div class="flex items-center justify-between p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-radius border border-outline dark:border-outline-dark animate-in fade-in slide-in-from-top-2 duration-300">
                            <div class="space-y-1">
                                <x-typography.heading size="sm" level="4">{{ __('Enforce 2FA for Administrators') }}</x-typography.heading>
                                <p class="text-xs text-on-surface/60">{{ __('Require all users with admin roles to set up 2FA to access the dashboard.') }}</p>
                            </div>
                            <x-toggle wire:model="two_factor_mandatory_for_admins" />
                        </div>
                    @endif

                    <div class="pt-4 border-t border-outline dark:border-outline-dark">
                        <x-typography.heading size="base" level="3" class="mb-4">{{ __('Password Policy') }}</x-typography.heading>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <x-input-label for="password_min_length" :value="__('Minimum Length')" />
                                <x-input id="password_min_length" type="number" class="mt-1 block w-full" wire:model="password_min_length" />
                                <x-input-error :messages="$errors->get('password_min_length')" class="mt-2" />
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-on-surface/80">{{ __('Require Mixed Case (aA)') }}</span>
                                    <x-toggle wire:model="password_mixed_case" />
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-on-surface/80">{{ __('Require Numbers (123)') }}</span>
                                    <x-toggle wire:model="password_numbers" />
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-on-surface/80">{{ __('Require Symbols (!@#)') }}</span>
                                    <x-toggle wire:model="password_symbols" />
                                </div>
                            </div>
                        </div>
                    </div>
                </x-card>
            </x-tab-panel>

            <!-- Passwordless Settings -->
            <x-tab-panel name="passwordless" class="space-y-6">
                <x-card class="p-6 space-y-6">
                    <div class="flex items-center justify-between p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-radius border border-outline dark:border-outline-dark">
                        <div class="flex gap-4">
                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg shrink-0">
                                <x-icons.sparkles class="size-6 text-indigo-600 dark:text-indigo-400" />
                            </div>
                            <div class="space-y-1">
                                <x-typography.heading size="sm" level="4">{{ __('Magic Links') }}</x-typography.heading>
                                <p class="text-xs text-on-surface/60">{{ __('Allow users to sign in via a secure link sent to their email.') }}</p>
                            </div>
                        </div>
                        <x-toggle wire:model="magic_links_enabled" />
                    </div>

                    <div class="flex items-center justify-between p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-radius border border-outline dark:border-outline-dark">
                        <div class="flex gap-4">
                            <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg shrink-0">
                                <x-icons.sparkles class="size-6 text-purple-600 dark:text-purple-400" />
                            </div>
                            <div class="space-y-1">
                                <x-typography.heading size="sm" level="4">{{ __('One-Time Password (OTP)') }}</x-typography.heading>
                                <p class="text-xs text-on-surface/60">{{ __('Send a numeric code via email for passwordless authentication.') }}</p>
                            </div>
                        </div>
                        <x-toggle wire:model="otp_enabled" />
                    </div>
                </x-card>
            </x-tab-panel>

            <!-- Session Settings -->
            <x-tab-panel name="session" class="space-y-6">
                <x-card class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <x-input-label for="session_lifetime" :value="__('Session Lifetime (Minutes)')" />
                            <x-input id="session_lifetime" type="number" class="mt-1 block w-full" wire:model="session_lifetime" />
                            <p class="mt-1 text-xs text-on-surface/60">{{ __('Default is 120 minutes (2 hours).') }}</p>
                            <x-input-error :messages="$errors->get('session_lifetime')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-between p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-radius border border-outline dark:border-outline-dark self-start mt-8">
                            <div class="space-y-1">
                                <x-typography.heading size="sm" level="4">{{ __('Multi-Device Logout') }}</x-typography.heading>
                                <p class="text-xs text-on-surface/60">{{ __('Allow users to view and revoke their active sessions from other devices.') }}</p>
                            </div>
                            <x-toggle wire:model="multi_device_logout_enabled" />
                        </div>
                    </div>
                </x-card>
            </x-tab-panel>
        </x-tabs>

        <div class="flex justify-end gap-3 pt-6 border-t border-outline dark:border-outline-dark">
            <x-button type="button" variant="outline" wire:click="$refresh">
                {{ __('Reset Changes') }}
            </x-button>
            <x-button type="submit" variant="primary" wire:loading.attr="disabled">
                <span wire:loading.remove>{{ __('Save Settings') }}</span>
                <span wire:loading>{{ __('Saving...') }}</span>
            </x-button>
        </div>
    </form>
</div>
