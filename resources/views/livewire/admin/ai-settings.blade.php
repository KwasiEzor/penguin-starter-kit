<div class="flex flex-col gap-8">
    <!-- Header -->
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-black tracking-tight text-on-surface-strong dark:text-on-surface-dark-strong">
            {{ __('AI Configuration') }}
        </h1>
        <p class="text-on-surface/60 dark:text-on-surface-dark/60 font-medium">
            {{ __('Manage AI model providers and set global API keys.') }}
        </p>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <!-- Sidebar Info -->
        <div class="lg:col-span-1 flex flex-col gap-6">
            <div class="p-6 rounded-2xl bg-primary/5 border border-primary/10">
                <div class="flex size-10 items-center justify-center rounded-xl bg-primary/10 text-primary mb-4">
                    <x-icons.sparkles variant="outline" size="sm" />
                </div>
                <h3 class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong mb-2">
                    {{ __('How it works') }}
                </h3>
                <p class="text-xs text-on-surface/70 leading-relaxed">
                    {{ __('Users can provide their own API keys in their personal settings. If they don\'t, the system will fall back to these global keys. All keys are encrypted before storage.') }}
                </p>
            </div>
            
            <div class="flex flex-col gap-4">
                <h4 class="text-xs font-bold uppercase tracking-widest text-on-surface/40 px-1">{{ __('Status') }}</h4>
                <x-card class="!bg-surface">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-semibold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('AI Feature') }}</span>
                        <x-toggle id="ai-enabled-toggle" wire:model.live="aiEnabled" />
                    </div>
                </x-card>
            </div>
        </div>

        <!-- Main Settings Form -->
        <div class="lg:col-span-2 flex flex-col gap-8">
            <x-card padding="false">
                <x-slot name="header">
                    <span class="text-sm font-bold text-on-surface-strong dark:text-on-surface-dark-strong">{{ __('Global API Provider Keys') }}</span>
                </x-slot>

                <form wire:submit="saveSettings" class="p-8 space-y-8">
                    <div class="grid gap-8">
                        <!-- OpenAI -->
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="size-6 rounded bg-black flex items-center justify-center">
                                    <svg viewBox="0 0 24 24" class="size-4 text-white fill-current"><path d="M22.2819 9.8211a5.9847 5.9847 0 0 0-.5153-4.9108 6.0462 6.0462 0 0 0-4.4471-3.2872 6.0856 6.0856 0 0 0-5.2092.9961L11.0599 3.253a.4125.4125 0 0 1 .4101.0341l8.3227 4.802a.8251.8251 0 0 1 .4126.7147v9.604a.4125.4125 0 0 1-.6188.3574l-8.3227-4.802a.8251.8251 0 0 1-.4126-.7147V3.253a.4125.4125 0 0 1 .6188-.3574l.0504.0291a6.0714 6.0856 0 0 0 5.3312 2.3214 6.0503 6.0503 0 0 0 4.3627 3.272 6.0005 6.0005 0 0 0 .1413 1.303Z"/></svg>
                                </div>
                                <x-input-label value="{{ __('OpenAI API Key') }}" for="openai-key" class="!mb-0" />
                            </div>
                            <x-input
                                id="openai-key"
                                type="password"
                                wire:model="openaiKey"
                                placeholder="{{ $hasKeys['openai'] ? __('••••••••••••••••') : __('sk-...') }}"
                            />
                        </div>

                        <!-- Anthropic -->
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="size-6 rounded bg-[#D97757] flex items-center justify-center text-white font-black text-[10px]">A</div>
                                <x-input-label value="{{ __('Anthropic API Key') }}" for="anthropic-key" class="!mb-0" />
                            </div>
                            <x-input
                                id="anthropic-key"
                                type="password"
                                wire:model="anthropicKey"
                                placeholder="{{ $hasKeys['anthropic'] ? __('••••••••••••••••') : __('sk-ant-...') }}"
                            />
                        </div>

                        <!-- Gemini -->
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="size-6 rounded bg-blue-600 flex items-center justify-center text-white font-black text-[10px]">G</div>
                                <x-input-label value="{{ __('Gemini API Key') }}" for="gemini-key" class="!mb-0" />
                            </div>
                            <x-input
                                id="gemini-key"
                                type="password"
                                wire:model="geminiKey"
                                placeholder="{{ $hasKeys['gemini'] ? __('••••••••••••••••') : __('AI...') }}"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-outline dark:border-outline-dark">
                        <span class="text-xs text-on-surface/50 italic">{{ __('Sensitive data is always encrypted.') }}</span>
                        <x-button type="submit" class="shadow-lg shadow-primary/20">
                            {{ __('Update AI Keys') }}
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</div>
