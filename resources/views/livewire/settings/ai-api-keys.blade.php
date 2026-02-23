<div>
    <x-typography.heading accent>{{ __('AI API Keys') }}</x-typography.heading>
    <x-typography.subheading class="mt-1">
        {{ __('Optional — uses global keys if not set.') }}
    </x-typography.subheading>

    <form wire:submit="saveKeys" class="mt-4 flex flex-col gap-4">
        @foreach ($providers as $provider)
            <div>
                <x-input-label value="{{ $provider->label() }} {{ __('API Key') }}" for="key-{{ $provider->value }}" />
                <div class="mt-1 flex gap-2">
                    <x-input
                        id="key-{{ $provider->value }}"
                        type="password"
                        wire:model="{{ $provider->value === 'openai' ? 'openaiKey' : ($provider->value === 'anthropic' ? 'anthropicKey' : 'geminiKey') }}"
                        placeholder="{{ $hasKeys[$provider->value] ? __('Key configured — leave blank to keep') : __('Enter API key...') }}"
                        class="flex-1"
                    />
                    @if ($hasKeys[$provider->value])
                        <x-button
                            type="button"
                            variant="ghost"
                            size="sm"
                            wire:click="removeKey('{{ $provider->value }}')"
                            class="text-danger hover:text-danger"
                        >
                            {{ __('Remove') }}
                        </x-button>
                    @endif
                </div>
            </div>
        @endforeach

        <p class="text-xs text-on-surface dark:text-on-surface-dark">
            {{ __('All keys are stored encrypted. Leave blank to keep current value.') }}
        </p>

        <div>
            <x-button type="submit">{{ __('Save Keys') }}</x-button>
        </div>
    </form>
</div>
