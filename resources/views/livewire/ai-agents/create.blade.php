<div class="flex flex-col gap-6">
    <!-- Header -->
    <div>
        <x-breadcrumbs class="mb-4">
            <x-breadcrumb-item href="{{ route('agents.index') }}">{{ __('AI Agents') }}</x-breadcrumb-item>
            <x-breadcrumb-item :active="true">{{ __('Create') }}</x-breadcrumb-item>
        </x-breadcrumbs>

        <x-typography.heading accent size="xl" level="1">{{ __('Create Agent') }}</x-typography.heading>
        <x-typography.subheading size="lg">{{ __('Configure a new AI agent') }}</x-typography.subheading>
    </div>

    <x-separator />

    <!-- Form -->
    <form wire:submit="save" class="max-w-2xl space-y-6">
        <div>
            <x-input-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" wire:model="name" class="mt-1" placeholder="{{ __('Agent name') }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="description" value="{{ __('Description') }}" />
            <x-textarea
                id="description"
                wire:model="description"
                rows="2"
                class="mt-1"
                placeholder="{{ __('What does this agent do?') }}"
            />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="provider" value="{{ __('Provider') }}" />
                <x-select id="provider" wire:model.live="provider" class="mt-1">
                    @foreach ($providers as $provider)
                        <option value="{{ $provider->value }}">{{ $provider->label() }}</option>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('provider')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="model" value="{{ __('Model') }}" />
                <x-select id="model" wire:model="model" class="mt-1">
                    @foreach ($availableModels as $availableModel)
                        <option value="{{ $availableModel }}">{{ $availableModel }}</option>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('model')" class="mt-2" />
            </div>
        </div>

        <div>
            <x-input-label for="system_prompt" value="{{ __('System Prompt') }}" />
            <x-textarea
                id="system_prompt"
                wire:model="system_prompt"
                rows="6"
                class="mt-1"
                placeholder="{{ __('You are a helpful assistant that...') }}"
            />
            <x-input-error :messages="$errors->get('system_prompt')" class="mt-2" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="temperature" value="{{ __('Temperature') }}" />
                <x-input
                    id="temperature"
                    type="number"
                    wire:model="temperature"
                    class="mt-1"
                    min="0"
                    max="2"
                    step="0.1"
                />
                <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">
                    {{ __('0 = deterministic, 2 = creative') }}
                </p>
                <x-input-error :messages="$errors->get('temperature')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="max_tokens" value="{{ __('Max Tokens') }}" />
                <x-input id="max_tokens" type="number" wire:model="max_tokens" class="mt-1" min="1" max="128000" />
                <x-input-error :messages="$errors->get('max_tokens')" class="mt-2" />
            </div>
        </div>

        @if (auth()->user()->isAdmin())
            <div>
                <x-toggle id="is_public" wire:model="is_public">
                    {{ __('Make Public') }}
                </x-toggle>
                <p class="mt-1 text-xs text-on-surface dark:text-on-surface-dark">
                    {{ __('Public agents are accessible to all users.') }}
                </p>
            </div>
        @endif

        <div class="flex items-center gap-3">
            <x-button type="submit">{{ __('Create Agent') }}</x-button>
            <x-button variant="ghost" href="{{ route('agents.index') }}">{{ __('Cancel') }}</x-button>
        </div>
    </form>
</div>
