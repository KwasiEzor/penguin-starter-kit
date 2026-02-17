<section class="space-y-6">
    <header>
        <x-typography.heading class="mb-2" accent>{{ __('API Tokens') }}</x-typography.heading>
        <x-typography.subheading>{{ __('Create and manage API tokens for external access') }}</x-typography.subheading>
    </header>

    <!-- Create Token -->
    <form wire:submit="createToken" class="flex gap-3">
        <div class="flex-1">
            <x-input wire:model="tokenName" placeholder="{{ __('Token name (e.g. Mobile App)') }}" />
            <x-input-error :messages="$errors->get('tokenName')" class="mt-1" />
        </div>
        <x-button type="submit">{{ __('Create') }}</x-button>
    </form>

    <!-- New Token Display -->
    @if ($newToken)
        <x-alert variant="success">
            <p class="font-medium">{{ __('Copy your new API token. It won\'t be shown again:') }}</p>
            <code class="mt-2 block break-all rounded bg-success/10 p-2 text-xs font-mono">{{ $newToken }}</code>
        </x-alert>
    @endif

    <!-- Token List -->
    @if ($tokens->count())
        <div class="space-y-2">
            @foreach ($tokens as $token)
                <div wire:key="token-{{ $token->id }}" class="flex items-center justify-between rounded-radius border border-outline p-3 dark:border-outline-dark">
                    <div>
                        <p class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ $token->name }}</p>
                        <p class="text-xs text-on-surface dark:text-on-surface-dark">{{ __('Created') }} {{ $token->created_at->diffForHumans() }}</p>
                    </div>
                    <x-button size="xs" variant="ghost" wire:click="confirmDelete({{ $token->id }})" class="text-danger">
                        {{ __('Revoke') }}
                    </x-button>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Delete Confirmation -->
    @if ($deletingTokenId)
        <x-alert variant="warning">
            {{ __('Are you sure you want to revoke this token?') }}
            <div class="mt-2 flex gap-2">
                <x-button size="xs" variant="danger" wire:click="deleteToken">{{ __('Revoke') }}</x-button>
                <x-button size="xs" variant="ghost" wire:click="$set('deletingTokenId', null)">{{ __('Cancel') }}</x-button>
            </div>
        </x-alert>
    @endif
</section>
