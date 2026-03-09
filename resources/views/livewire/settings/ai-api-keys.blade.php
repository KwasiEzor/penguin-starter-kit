<div class="animate-in fade-in duration-500">
    <x-card class="overflow-hidden border-none shadow-premium-lg ring-1 ring-outline/5 dark:ring-outline-dark/5">
        <x-slot name="header">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary/10 dark:bg-primary-dark/10 rounded-radius text-primary dark:text-primary-dark">
                    <x-icons.sparkles class="size-5" />
                </div>
                <div>
                    <x-typography.heading size="lg" accent class="font-bold">
                        {{ __('AI API Keys') }}
                    </x-typography.heading>
                    <x-typography.subheading size="sm">
                        {{ __('Configure your personal API keys for AI providers.') }}
                    </x-typography.subheading>
                </div>
            </div>
        </x-slot>

        <form wire:submit="saveKeys" class="space-y-8">
            <div class="grid grid-cols-1 gap-8">
                @foreach ($providers as $provider)
                    <div class="space-y-3 group">
                        <div class="flex items-center justify-between">
                            <x-input-label 
                                value="{{ $provider->label() }}" 
                                for="key-{{ $provider->value }}" 
                                class="text-xs font-bold uppercase tracking-wider text-on-surface/60 dark:text-on-surface-dark/60"
                            />
                            @if ($hasKeys[$provider->value])
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-success/10 text-success-strong text-[10px] font-bold uppercase tracking-tight">
                                    <span class="size-1 rounded-full bg-success animate-pulse"></span>
                                    {{ __('Configured') }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex gap-3">
                            <div class="relative flex-1 group/input">
                                <x-input
                                    id="key-{{ $provider->value }}"
                                    type="password"
                                    wire:model="{{ $provider->value === 'openai' ? 'openaiKey' : ($provider->value === 'anthropic' ? 'anthropicKey' : 'geminiKey') }}"
                                    placeholder="{{ $hasKeys[$provider->value] ? __('••••••••••••••••••••••••••••') : __('Enter your ' . $provider->label() . ' API key...') }}"
                                    class="w-full transition-all duration-200 border-outline/40 bg-surface-alt/30 hover:bg-surface-alt/50 focus:bg-surface-alt/20 dark:border-outline-dark/40 dark:bg-surface-dark/30 pl-3 pr-10"
                                />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-on-surface/20 group-hover/input:text-on-surface/40 transition-colors">
                                    <x-icons.shield class="size-4" />
                                </div>
                            </div>
                            
                            @if ($hasKeys[$provider->value])
                                <x-button
                                    type="button"
                                    variant="ghost"
                                    wire:click="removeKey('{{ $provider->value }}')"
                                    class="text-danger hover:bg-danger/5 transition-colors shrink-0"
                                    title="{{ __('Remove Key') }}"
                                >
                                    <x-icons.trash class="size-5" />
                                </x-button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-4 rounded-radius bg-surface-alt/50 dark:bg-surface-dark/20 flex items-start gap-3 border border-outline/10 dark:border-outline-dark/10">
                <div class="text-primary dark:text-primary-dark mt-0.5">
                    <x-icons.shield class="size-4" />
                </div>
                <p class="text-xs text-on-surface/60 dark:text-on-surface-dark/60 leading-relaxed">
                    {{ __('Your API keys are stored with enterprise-grade encryption. They are only used to authenticate your requests to the respective AI providers. Leave a field blank to keep its current value.') }}
                </p>
            </div>

            <div class="flex items-center justify-end pt-4 border-t border-outline/10 dark:border-outline-dark/10">
                <x-button variant="primary" type="submit" class="px-8 shadow-lg shadow-primary/20">
                    {{ __('Save AI Keys') }}
                </x-button>
            </div>
        </form>
    </x-card>
</div>
