<div class="animate-in fade-in duration-500">
    <x-card class="overflow-hidden border-none shadow-premium-lg ring-1 ring-outline/5 dark:ring-outline-dark/5">
        <x-slot name="header">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary/10 dark:bg-primary-dark/10 rounded-radius text-primary dark:text-primary-dark">
                    <x-icons.cog class="size-5" />
                </div>
                <div>
                    <x-typography.heading size="lg" accent class="font-bold">
                        {{ __('API Tokens') }}
                    </x-typography.heading>
                    <x-typography.subheading size="sm">
                        {{ __('Create and manage API tokens for external access to your account.') }}
                    </x-typography.subheading>
                </div>
            </div>
        </x-slot>

        <div class="space-y-8">
            <!-- Create Token -->
            <div class="p-4 rounded-radius bg-surface-alt/30 border border-outline/20 dark:bg-surface-dark/30 dark:border-outline-dark/20">
                <form wire:submit="createToken" class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <x-input-label for="tokenName" :value="__('New Token Name')" class="sr-only" />
                            <x-input
                                id="tokenName"
                                wire:model="tokenName"
                                placeholder="{{ __('Token name (e.g. Mobile App, CI/CD)') }}"
                                class="w-full transition-all duration-200 border-outline/40 bg-surface dark:border-outline-dark/40 dark:bg-surface-dark"
                            />
                            <x-input-error :messages="$errors->get('tokenName')" class="mt-2" />
                        </div>
                        <x-button type="submit" variant="primary" class="shrink-0 shadow-md">
                            <x-icons.plus class="size-4 mr-2" />
                            {{ __('Create Token') }}
                        </x-button>
                    </div>

                    <div>
                        <x-input-label :value="__('Token Abilities')" class="text-xs font-bold uppercase tracking-wider opacity-60 mb-2" />
                        <p class="text-xs text-on-surface/50 dark:text-on-surface-dark/50 mb-3">
                            {{ __('Leave unchecked to grant full access.') }}
                        </p>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($availableAbilities as $ability => $label)
                                <label class="inline-flex items-center gap-2 cursor-pointer text-sm">
                                    <input
                                        type="checkbox"
                                        wire:model="selectedAbilities"
                                        value="{{ $ability }}"
                                        class="rounded border-outline/40 text-primary focus:ring-primary/50 dark:border-outline-dark/40 dark:bg-surface-dark"
                                    />
                                    <span class="text-on-surface/80 dark:text-on-surface-dark/80">{{ __($label) }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-input-error :messages="$errors->get('selectedAbilities')" class="mt-2" />
                    </div>
                </form>
            </div>

            <!-- New Token Display -->
            @if ($newToken)
                <div class="animate-in zoom-in-95 duration-300">
                    <div class="p-4 rounded-radius bg-success/5 border-2 border-dashed border-success/30">
                        <div class="flex items-center gap-2 mb-2 text-success-strong">
                            <x-icons.check-circle class="size-5" />
                            <p class="font-bold text-sm">{{ __('Token created successfully!') }}</p>
                        </div>
                        <p class="text-xs text-on-surface/70 dark:text-on-surface-dark/70 mb-3">
                            {{ __('Copy your new API token now. For security reasons, it won\'t be shown again:') }}
                        </p>
                        <div class="flex items-center gap-2">
                            <code class="flex-1 block break-all rounded bg-surface border border-success/20 p-3 text-xs font-mono text-success-strong select-all dark:bg-surface-dark">
                                {{ $newToken }}
                            </code>
                        </div>
                    </div>
                </div>
            @endif

            <x-separator class="opacity-50" />

            <!-- Token List -->
            <div class="space-y-4">
                <x-typography.heading size="base" accent class="font-bold uppercase tracking-wider text-xs opacity-60">
                    {{ __('Active Tokens') }} ({{ $tokens->count() }})
                </x-typography.heading>

                @if ($tokens->count())
                    <div class="divide-y divide-outline/10 dark:divide-outline-dark/10">
                        @foreach ($tokens as $token)
                            <div
                                wire:key="token-{{ $token->id }}"
                                class="flex items-center justify-between py-4 group transition-all duration-200 hover:bg-surface-alt/20 -mx-4 px-4 rounded-radius"
                            >
                                <div class="flex items-center gap-4">
                                    <div class="p-2 bg-surface-alt dark:bg-surface-dark-alt rounded-full text-on-surface/40 dark:text-on-surface-dark/40">
                                        <x-icons.shield class="size-4" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
                                            {{ $token->name }}
                                        </p>
                                        <p class="text-xs text-on-surface/50 dark:text-on-surface-dark/50">
                                            {{ __('Created') }} {{ $token->created_at->diffForHumans() }}
                                            @if($token->last_used_at)
                                                <span class="mx-1.5 text-outline/40">•</span>
                                                {{ __('Last used') }} {{ $token->last_used_at->diffForHumans() }}
                                            @endif
                                        </p>
                                        @if($token->abilities && $token->abilities !== ['*'])
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach($token->abilities as $ability)
                                                    <span class="inline-block px-1.5 py-0.5 text-[10px] font-medium rounded bg-primary/10 text-primary dark:bg-primary-dark/10 dark:text-primary-dark">
                                                        {{ $ability }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <button
                                    type="button"
                                    wire:click="confirmDelete({{ $token->id }})"
                                    class="p-2 text-on-surface/40 hover:text-danger hover:bg-danger/5 rounded-full transition-all duration-200"
                                    title="{{ __('Revoke Token') }}"
                                >
                                    <x-icons.trash class="size-5" />
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center border-2 border-dashed border-outline/20 rounded-radius">
                        <div class="p-4 bg-surface-alt dark:bg-surface-dark-alt rounded-full mb-4">
                            <x-icons.cog class="size-8 text-on-surface/20" />
                        </div>
                        <p class="text-sm text-on-surface/50 dark:text-on-surface-dark/50">{{ __('No API tokens found.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </x-card>

    <!-- Delete Confirmation Modal -->
    <x-modal wire:model="showDeleteModal" maxWidth="sm">
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4 text-danger">
                <x-icons.trash class="size-6" />
                <x-typography.heading accent size="lg" class="font-bold">
                    {{ __('Revoke Token') }}
                </x-typography.heading>
            </div>
            
            <p class="text-sm text-on-surface/70 dark:text-on-surface-dark/70 mb-6">
                {{ __('Are you sure you want to revoke this token? Any applications using it will lose access immediately.') }}
            </p>
            
            <div class="flex justify-end gap-3">
                <x-button size="sm" variant="ghost" wire:click="cancelDelete">
                    {{ __('Cancel') }}
                </x-button>
                <x-button size="sm" variant="danger" wire:click="deleteToken">
                    {{ __('Revoke Token') }}
                </x-button>
            </div>
        </div>
    </x-modal>
</div>
