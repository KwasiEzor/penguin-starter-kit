<div class="flex flex-col gap-6">
    <!-- Header -->
    <div>
        <x-breadcrumbs class="mb-4">
            <x-breadcrumb-item href="{{ route('admin.dashboard') }}">{{ __('Admin') }}</x-breadcrumb-item>
            <x-breadcrumb-item :active="true">{{ __('AI Settings') }}</x-breadcrumb-item>
        </x-breadcrumbs>

        <x-typography.heading accent size="xl" level="1">{{ __('AI Settings') }}</x-typography.heading>
        <x-typography.subheading size="lg">
            {{ __('Configure AI providers and API keys') }}
        </x-typography.subheading>
    </div>

    <x-separator />

    <x-tabs active="settings">
        <x-slot name="tabs">
            <x-tab name="settings">{{ __('Settings') }}</x-tab>
            <x-tab name="api-keys">{{ __('API Keys') }}</x-tab>
        </x-slot>

        <!-- Settings Tab -->
        <x-tab-panel name="settings">
            <x-card>
                <x-slot name="header">
                    <x-typography.heading accent>{{ __('General Settings') }}</x-typography.heading>
                </x-slot>

                <form wire:submit="saveSettings" class="flex flex-col gap-4">
                    <div>
                        <x-toggle id="ai-enabled" wire:model="aiEnabled">
                            {{ __('Enable AI Agents') }}
                        </x-toggle>
                        <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">
                            {{ __('When enabled, users can create and use AI agents.') }}
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <x-button type="submit">{{ __('Save Settings') }}</x-button>
                    </div>
                </form>
            </x-card>
        </x-tab-panel>

        <!-- API Keys Tab -->
        <x-tab-panel name="api-keys">
            <x-card>
                <x-slot name="header">
                    <x-typography.heading accent>{{ __('Global API Keys') }}</x-typography.heading>
                </x-slot>

                <form wire:submit="saveSettings" class="flex flex-col gap-4">
                    <p class="text-sm text-on-surface dark:text-on-surface-dark">
                        {{ __('Configure global API keys used when users do not provide their own.') }}
                    </p>

                    <div>
                        <x-input-label value="{{ __('OpenAI API Key') }}" for="openai-key" />
                        <x-input
                            id="openai-key"
                            type="password"
                            wire:model="openaiKey"
                            placeholder="{{ $hasKeys['openai'] ? __('Key configured — leave blank to keep') : __('sk-...') }}"
                            class="mt-1"
                        />
                    </div>

                    <div>
                        <x-input-label value="{{ __('Anthropic API Key') }}" for="anthropic-key" />
                        <x-input
                            id="anthropic-key"
                            type="password"
                            wire:model="anthropicKey"
                            placeholder="{{ $hasKeys['anthropic'] ? __('Key configured — leave blank to keep') : __('sk-ant-...') }}"
                            class="mt-1"
                        />
                    </div>

                    <div>
                        <x-input-label value="{{ __('Gemini API Key') }}" for="gemini-key" />
                        <x-input
                            id="gemini-key"
                            type="password"
                            wire:model="geminiKey"
                            placeholder="{{ $hasKeys['gemini'] ? __('Key configured — leave blank to keep') : __('AI...') }}"
                            class="mt-1"
                        />
                    </div>

                    <p class="text-xs text-on-surface dark:text-on-surface-dark">
                        {{ __('Leave blank to keep current value. All keys are stored encrypted.') }}
                    </p>

                    <div class="flex justify-end">
                        <x-button type="submit">{{ __('Save API Keys') }}</x-button>
                    </div>
                </form>
            </x-card>
        </x-tab-panel>
    </x-tabs>
</div>
